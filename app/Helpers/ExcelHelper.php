<?php
namespace App\Helpers;
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

//class for parsing excel file using phpSpreadSheet
class ExcelHelper
{
    private $workbook;
    private $spreadsheet;
    private $highestRow;
    private $highestColumn;

    public function __construct($file)
    {
        //zwraca obiekt phpSpreadSheet
        $this->workbook = IOFactory::load($file);
        $this->spreadsheet = $this->workbook->getActiveSheet();
        $this->highestRow = $this->spreadsheet->getHighestDataRow();
        $this->highestColumn = Coordinate::columnIndexFromString($this->spreadsheet->getHighestDataColumn());
    }



    # Pobierz wartości z kolumny podając nazwę kolumny oraz numer wiersza z tytułami z formatowaniem
    public function getColumnValues($columnName, $titleRow)
    {
        $columnName = mb_strtoupper($columnName);
        $targetColumn = $this->isTitle($columnName, $titleRow);

        if ($targetColumn !== false) {

            $iterator = 0;
            $values = array();
            for ($currentRow = $titleRow + 1; $currentRow <= $this->highestRow; $currentRow++) {

                $currentCell = $this->spreadsheet->getCell([$targetColumn, $currentRow])->getFormattedValue();
                $values[$iterator] = trim($currentCell);
                $iterator++;

            }

            return (sizeof($values) > 0) ? $values : false;

        }
        else
        {
            return false;
        }

    }


    # Sprawdź czy istnieje kolumna o podanym tytule
    public function isTitle($columnName, $titleRow)
    {
        for ($currentColumn = 1; $currentColumn <= $this->highestColumn; $currentColumn++)
        {
            $currentCell = $this->spreadsheet->getCell([$currentColumn, $titleRow])->getFormattedValue();
            $currentCell = trim(mb_strtoupper($currentCell));

            if ($currentCell === $columnName) {
                return $currentColumn;
            }

        }

        return false;

    }

}
