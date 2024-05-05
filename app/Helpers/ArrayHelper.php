<?php

namespace App\Helpers;

class ArrayHelper
{
    public static function areArraySizesEqual()
    {
        $arrays = func_get_args();

        foreach ($arrays as $array) {
            if (!is_array($array)) {
                return false;
            }
        }

        if (count($arrays) < 2) {
            return true; // If there are fewer than two arrays, they are equal by default.
        }

        $firstArraySize = count($arrays[0]);
        foreach ($arrays as $array) {
            if (count($array) !== $firstArraySize) {
                return false;
            }
        }

        return true;
    }

}

?>
