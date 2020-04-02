<?php

require_once('vendor/autoload.php');

use App\Database\Database;
use App\Ui\UiGenerator;

$selectorArray = [
    'ru' => 'Русский',
    'en' => 'Английский',
    'fr' => 'Французский',
];

//echo UiGenerator::selectFromArray($selectorArray);

$db = new Database();

// Запрашиваем фильмы без фото
$filmsNoPhoto = $db->query('SELECT m.* FROM movie AS m LEFT JOIN pictures AS p ON m.movie_id=p.movie_id WHERE p.movie_id IS NULL LIMIT 10');
echo UiGenerator::tableFromArray($filmsNoPhoto);

// Подсчет фильмов без фото
$countFilmsNoPhoto = $db->query('SELECT COUNT(*) AS films_without_photos FROM movie as m LEFT JOIN pictures AS p ON m.movie_id=p.movie_id WHERE p.movie_id IS NULL');
echo UiGenerator::tableFromArray($countFilmsNoPhoto);


