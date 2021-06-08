<?php

namespace core;

class Utils
{
    public static function arrayFilter($row, $fields)
    {
        $newRow = [];
        foreach ($fields as $field)
            if (isset($row[$field]))
                $newRow[$field] = $row[$field];
        return $newRow;
    }
}