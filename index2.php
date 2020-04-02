<?php

require_once('vendor/autoload.php');

use App\Database\Database;

$db = new Database();

$films = $db->query('SELECT m.movie_id, m.title, COUNT(p.picture_id) AS pictures FROM movie AS m LEFT JOIN pictures AS p ON m.movie_id=p.movie_id GROUP BY m.movie_id');

function makeFilmsObject(array $films)
{
    $filmsSorted = [
        'films' => [
            'with' => [],
            'without' => [],
        ],
    ];

    foreach ($films as $film) {
        if ($film['pictures'] > 0) {
            $filmsSorted['films']['with'][] = $film['title'];
        } else {
            $filmsSorted['films']['without'][] = $film['title'];
        }
    }

    return json_encode($filmsSorted);
}

?>

<div id="tree"></div>

<script>
    let obj = <?=makeFilmsObject($films)?>;

    function makeTreeFromObj(obj) {
        let tree = '';
        let leaf = '';

        for (let key in obj) {
            if (typeof(obj[key]) == 'object') {
                
                leaf += '<li>' + key + makeTreeFromObj(obj[key]) + '</li>';
            } else {
                leaf += '<li>' + obj[key] + '</li>';
            }
        }

        if (leaf) {
            tree += '<ul>' + leaf + '</ul>';
        }

        return tree || '';
    }

    tree.innerHTML = makeTreeFromObj(obj);
</script>