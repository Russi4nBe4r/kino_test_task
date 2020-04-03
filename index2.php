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

<style>
    .hidden {
        display: none;
    }
</style>

<div id="tree"></div>

<script>
    let obj = <?=makeFilmsObject($films)?>;

    function makeTreeFromObj(obj, level) {
        let tree = '';
        let leaf = '';

        for (let key in obj) {
            if (typeof(obj[key]) == 'object') {
                
                leaf += '<li>' + key + makeTreeFromObj(obj[key], level + 1) + '</li>';
            } else {
                leaf += '<li>' + obj[key] + '</li>';
            }
        }

        if (leaf) {
            if (level == 0) {
                tree += '<ul id="root">' + leaf + '</ul>';
            } else {
                tree += '<ul class="hidden">' + leaf + '</ul>';
            }
        }

        return tree || '';
    }

    tree.innerHTML = makeTreeFromObj(obj, 0);

    document.addEventListener('click', function(event) {
        if (event.target.tagName == 'LI') {
            let chidlren = event.target.childNodes;
            if (chidlren.length > 1) {
                console.log(chidlren[1]);
                if (chidlren[1].className == 'hidden') {
                    chidlren[1].classList.remove('hidden');
                } else {
                    chidlren[1].classList.add('hidden');
                }
            }
        }

    });
</script>