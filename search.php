<?php
require_once('snaf/all.php');

snaf_load_components(array('search','layout'));

$data = get_search_data($_REQUEST);

$layout = array();
$layout['TITLE'] = 'Search'; 
$layout['BODY'] = array($data);

$top_layout = array('BODY'=>array($layout));

echo build_layout_html($layout);

?>
