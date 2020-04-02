<?php

require_once('vendor/autoload.php');

use App\Database\Database;
use App\Ui\UiGenerator;

$selectorArray = [
    'ru' => 'Русский',
    'en' => 'Английский',
    'fr' => 'Французский',
];

echo UiGenerator::selectFromArray($selectorArray);

// Получае html страницы kinorium
$ch = curl_init("https://ru.kinorium.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$content = curl_exec($ch);
curl_close($ch);

$content = trim($content);
$re = "/<a +class='link-info-movie-type-film' +data-id='([0-9]*)'+[^>]+> +<h3>([^<\/h3>]*)<\/h3> <h4>([^<\/h4>]*)/m";
preg_match_all($re, $content, $matches, PREG_SET_ORDER, 0);

$matches = array_map(function($item) {
    return [
        'ID' => str_replace('&nbsp;', ' ', $item[1]),
        'Русское' => html_entity_decode($item[2]),
        'Оригинальное' => html_entity_decode($item[3]),
    ];
}, $matches);

// Выводим результат парсинга в виде таблицы
echo UiGenerator::tableFromArray($matches);

$db = new Database();

// Запрашиваем фильмы без фото
$filmsNoPhoto = $db->query('SELECT m.* FROM movie AS m LEFT JOIN pictures AS p ON m.movie_id=p.movie_id WHERE p.movie_id IS NULL LIMIT 10');
echo UiGenerator::tableFromArray($filmsNoPhoto);

// Подсчет фильмов без фото
$countFilmsNoPhoto = $db->query('SELECT COUNT(*) AS films_without_photos FROM movie as m LEFT JOIN pictures AS p ON m.movie_id=p.movie_id WHERE p.movie_id IS NULL');
echo UiGenerator::tableFromArray($countFilmsNoPhoto);

?>

<div id="tree"></div>

<script>
    let obj = {
        "ветка#1": {
            "ветка#2": {
                "лист#1": {},
                "лист#2": {},
                "лист#3": {}
            },
            "лист#4": {},
            "лист#5": {}
        },
        "ветка#3": {
            "лист#6": {},
            "лист#7": {}
        }
    };

    function makeTreeFromObj(obj) {
        let tree = '';
        let leaf = '';

        for (let key in obj) {
            leaf += '<li>' + key + makeTreeFromObj(obj[key]) + '</li>';
        }

        if (leaf) {
            tree += '<ul>' + leaf + '</ul>';
        }

        return tree || '';
    }

    tree.innerHTML = makeTreeFromObj(obj);
</script>