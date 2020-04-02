<?php

namespace App\Ui;

class UiGenerator
{
    public static function selectFromArray(array $items)
    {
        $selector = '<select>';
        if (!empty($items)) {
            foreach ($items as $key => $value) {
                $selector .= "<option value='{$key}'>{$value}</option>";
            }
        }
        $selector .= '</select>';

        return $selector;
    }

    public static function tableFromArray(array $items)
    {
        $table = '<table>';

        if (!empty($items)) {
            $cells = array_keys($items[0]);

            $table .= '<tr>';
            foreach ($cells as $name) {
                $table .= "<td>{$name}</td>";
            }
            $table .= '</tr>';


            $table .= '<tr>';
            foreach ($items as $item) {
                foreach ($item as $value) {
                    $table .= "<td>{$value}</td>";
                }
            }
            $table .= '</tr>';
        }

        $table .= '</table>';

        return $table;
    }
}