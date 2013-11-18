<?php

require_once('lib/db.inc.php');
require_once('lib/items.inc.php');
require_once('lib/people.inc.php');
require_once('lib/comments.inc.php');
require_once('lib/tags.inc.php');
require_once('lib/search.inc.php');

foreach ((range(1,19)) as $j) {
	foreach (items::get_page($j) as $i) {
//print_r($i);
search::index('items', $i['item_id'], $i['description']);
}
}
?>