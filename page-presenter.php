<?php
require_once('snaf/all.php');
require_once('lib/page-presenters.inc.php'); 

snaf_load_components(array('page-presenter','layout'));


$presenters = page_presenters::get_all();



$layout = array();
$layout['TITLE'] = 'Page Presenters';
$layout['BODY'] = array('name' => 'Clara', 'page' => '3');

$top_layout = array('BODY'=>array($layout));

echo build_layout_html($layout);


?>
