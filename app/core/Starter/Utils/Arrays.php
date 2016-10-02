<?php

namespace Starter\Utils;

class Arrays {

    /**
     * @param array $array
     * @param string $sep
     * @param string $glue
     * @return string
     */
    public static function implodeAssoc ($array, $sep = '=', $glue = '|') {
        $str = '';
        foreach ($array as $key => $item) {
            $str .= $key . $sep . $item . $glue;
        }
        return rtrim ($str, $glue);
    } // implodeAssoc ();

}; // Arrays;