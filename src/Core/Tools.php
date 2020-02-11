<?php


namespace Src\Core;


class Tools
{
    static public function checkIfObligatoriesColumnsArePresent($vars_obligatorias, $user_data)
    {
        foreach($vars_obligatorias as $obligatoria) {
            if(!isset($user_data[$obligatoria]) || empty($user_data[$obligatoria])) {
                return false;
            }
        }

        return true;
    }
}