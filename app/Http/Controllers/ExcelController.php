<?php

namespace App\Http\Controllers;

use App\Helpers\ExcelHelper;
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

        $filePath = $request->file('select_excel')->path();
        $excelParser = new ExcelHelper($filePath);

        $productColumn = $excelParser->getColumnValues('Nazwa produktu', 1);

        return response()->json([
            'message' => 'success',
            'products'=> $productColumn
            ], 200);
    }



}
