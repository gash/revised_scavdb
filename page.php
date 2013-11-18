<?php
require_once('snaf/all.php');

snaf_load_components(array('itemlist','list','layout'));

$page = isset($_REQUEST['id'])?$_REQUEST['id']:false;
$status = isset($_REQUEST['status'])?$_REQUEST['status']:false;
$tag = isset($_REQUEST['tag'])?$_REQUEST['tag']:false;
$status_match = isset($_REQUEST['status_match'])?$_REQUEST['status_match']:false;

if ($page || $status || $tag || $status_match) {
	$list = get_itemlist_data(array('page'=>$page,'status'=>$status,'tag'=>$tag,'sort'=>$_REQUEST['sort'],'status_match' => $status_match));
	$statuses = items::get_statuses();
	if ($page) $title = 'Page '.$page.' | ';
	if ($status) $title .= $statuses[$status].' Items';	
	if ($status_match) $title .= "Items needing " . $status_match;
	else $title .= 'All Items';
	if ($tag) $title.= ' tagged "'.$tag.'"';
} else {
	$list = get_list_data($_REQUEST);
	$title = 'The List';
//	if ($_REQUEST['points']) $title.=' <a href="?">by Items</a> | by Points';
//	else $title.=' by Items | <a href="?points=1">by Points</a>';
}


$layout = array();
$layout['TITLE'] = $title;
$itemlist['TITLE'] = $layout['TITLE'];
$layout['BODY'] = array($list);

$top_layout = array('BODY'=>array($layout));
echo build_layout_html($layout);

?>