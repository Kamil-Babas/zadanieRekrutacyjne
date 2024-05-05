<?php

namespace App\Http\Controllers;

use App\Helpers\ExcelHelper;
use App\Helpers\ArrayHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExcelController extends Controller
{
    public function loadExcelView(){
        return view('loadExcelView');
    }

    public function parseExcel(Request $request){

        $validator = Validator::make($request->all(), [
            'select_excel' => 'required|file|mimes:csv,xlsx,xls,ods'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productCount = Product::count();

        // if data in DB doesnt exist
        if($productCount === 0)
        {
            $filePath = $request->file('select_excel')->path();
            $excelParser = new ExcelHelper($filePath);

            //column values in file
            $produktColumn = $excelParser->getColumnValues('Nazwa produktu', 1);
            $producentColumn = $excelParser->getColumnValues('Producent', 1);
            $jednostkaCenyColumn = $excelParser->getColumnValues('Jednostka ceny', 1);

            $wagaColumn = $excelParser->getColumnValues('Waga', 1);
            $srednicaColumn = $excelParser->getColumnValues('Średnica', 1);
            $dlugoscColumn = $excelParser->getColumnValues('Długość', 1);

            $szerokoscColumn = $excelParser->getColumnValues('Szerokość', 1);
            $wysokoscColumn = $excelParser->getColumnValues('Wysokość', 1);
            $gruboscColumn = $excelParser->getColumnValues('Grubość', 1);

            $typOpakowaniaColumn = $excelParser->getColumnValues('Typ pakowania', 1);
            $jednostkiZakupuColumn = $excelParser->getColumnValues('Merged_N+O_columns', 1);


            $equalSizeCheck = ArrayHelper::areArraySizesEqual(
                $produktColumn,
                $producentColumn,
                $jednostkaCenyColumn,
                $wagaColumn,
                $srednicaColumn,
                $dlugoscColumn,
                $szerokoscColumn,
                $wysokoscColumn,
                $gruboscColumn,
                $typOpakowaniaColumn,
                $jednostkiZakupuColumn
            );

            if($equalSizeCheck){

                for($i = 0; $i < count($producentColumn); $i++){

                    $product = Product::create([
                        'nazwa_produktu' => $produktColumn[$i],
                        'producent' => $producentColumn[$i],
                        'jednostka_ceny' => $jednostkaCenyColumn[$i],
                        'waga' => floatval($wagaColumn[$i]),
                        'srednica' => floatval($srednicaColumn[$i]),
                        'dlugosc' => floatval($dlugoscColumn[$i]),
                        'szerokosc' => floatval($szerokoscColumn[$i]),
                        'wysokosc' => floatval($wysokoscColumn[$i]),
                        'grubosc' => floatval($gruboscColumn[$i]),
                        'typ_opakowania' => $typOpakowaniaColumn[$i],
                        'jednostki_zakupu' => $jednostkiZakupuColumn[$i],
                    ]);

                }

            }

            return response()->json([
                'message' => 'File was parsed successfully <br/> The data has been inserted into database',
                'products'=> Product::all()->toArray(),
            ], 201);

        }
        else
        {
            return response()->json([
                'message' => 'The data already exists in database'
            ], 200);
        }


    }



}
