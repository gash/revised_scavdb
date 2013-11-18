<?php

/* Dependencies */

require_once('lib/items.inc.php');

/* Set up functions */


function build_list_table_html($data, $statuses) {
	$new_statuses = array();
	foreach ($statuses as $st=>$stname) {
		$status = array();
		$c = items::get_status_code($st);
		$status['name'] = "<a href='/page.php?status=$st'>$st</a> <img src='/img/status-{$c}.png' />";
		$the_page = array();
		foreach ($data as $idx=>$page) {
		   $the_page[] = "<td><a href='/page.php?status=$stname&id=$idx'>{$page[$st]}</a></td>";
		}
		$status['page'] = $the_page;
		$new_statuses[] = snaf_wrap_data($status, 'status', 'list');
	}
	return $new_statuses;
}

/*
function build_list_table_html($data, $statuses){
	$pages = array();
	foreach ($data as $idx=>$page) {
		$page['num'] = $idx;
		if ($idx == 100) $page['name'] = 'ScavOlympics';
		else $page['name'] = 'Page '.$idx;
		$status = array();
		foreach ($statuses as $s=>$name) {

			$status[] = "<td><a href='/page.php?status=$s&id=$idx'>{$page[$s]}</a></td>";

		}
		$page['status'] = $status;
		$captains = array();
		foreach ($page['captains'] as $captain) {
			$captains[] = "<a href='/people.php?id={$captain['person_id']}'>{$captain['nickname']}</a>";
		}
		$page['captains'] = $captains;
		$pages[] = snaf_wrap_data($page, 'page', 'list');
	}
	return $pages;
}
*/

/*function build_list_html($data, $section=FALSE) {
	$statuses = $data['status'];
	$status = array();
	foreach ($statuses as $s=>$name) {
		$status[] = "<td><a href='/page.php?status=$s'><img src='/img/status-$s.png' /> $name</a></td>";
	}
	$data['status'] = $status;
	$data['pages'] = build_list_table_html($data['pages'], $statuses);
	return snaf_build_bottom_up($data, 'list');
}*/


function build_list_html($data, $section=FALSE) {
	$statuses = $data['status'];

	$new_page = array();
	$new_page[] = "<th>Pages:</th>";
	foreach ($data['pages'] as $idx=>$page) {
//	if ($idx == 17) { //This is bad, hard coded page number
	if ($idx == 19) { //This is bad, hard coded page number
	$new_page[] = "<th><a href='/page.php?id=$idx'><img src='/img/status-o.png' /></a></th>";
}
	else {
		$new_page[] = "<th><a href='/page.php?id=$idx'>$idx</a></th>";
}
	}
	$data['page_list'] = $new_page;
	$data['statuses'] = build_list_table_html($data['pages'], $statuses);
	return snaf_build_bottom_up($data, 'list');
}


function get_list_data($request=FALSE) {
    $data = array();
	$data['status'] = items::get_statuses();
	$data['pages'] = items::get_pages($request['points']);
    return snaf_wrap_data($data, 'list', 'list');
}

/* Init code goes here */


?>
