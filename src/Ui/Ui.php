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
}