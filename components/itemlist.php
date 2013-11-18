<?php

/* Dependencies */

require_once('lib/items.inc.php');

snaf_load_components(array('item'));

/* Set up functions */

function build_itemlist_html($data, $section=FALSE) {
	$items = array();
	foreach ($data['ITEMS'] as $item) {
		$items[] = build_item_html($item);
	}
	$data['ITEMS'] = $items;
	$pages = array();
	foreach ($data['pages'] as $page) {
		if ($page=='100') $name='ScavOlympics';
		else $name=$page;
		$pages[] = "<a href='/page.php?id=$page'>$name</a>";
	}
	$data['pages'] = $pages;
	$statuses = array();
	$statname = items::get_statuses();
	$statuses[] = "<div class='status_column'>";
	$i = 1;
	foreach ($statname as $s=>$name) {
		$i++;
		$num = ($data['statuses'][$s])?$data['statuses'][$s]:0;
		$c = items::get_status_code($s);
		$statuses[] = "<a class='status' href='/page.php?status=$s'><img src='/img/status-$c.png' /> {$num} {$name}</a>";
		if (($i == 13) || ($i == 25)) {
		   $statuses[] = "</div><div class='status_column'>";
		}
	}
        $statuses[] = "</div><p class='clearing'></p>";	
	$data['statuses'] = $statuses;
	$captains = array();
	foreach ($data['captains'] as $captain) {
		$captains[] = "<a href='/people.php?id={$captain['person_id']}'>{$captain['nickname']}</a>";
	}
	$data['captains'] = $captains;
	return snaf_build_bottom_up($data, 'itemlist');
}

function build_itemlist_css($data, $section=FALSE) {
	return snaf_build_bottom_up($data, 'itemlist', 'css');
}

function get_itemlist_data($request=FALSE) {
    $data = array();
	$items = array();

	$match = array();
	if ($request['tag']) {
		$match['tag'] = $request['tag'];
	}
	if ($request['page']) {
		$match['page'] = $request['page'];
		$data['captains'] = people::get_page_captains($request['page']);
	}
	if ($request['status']){
		$match['status'] = $request['status'];
	}
	if ($request['status_match']) {
	   $match['status_match'] = $request['status_match']; 
	   }
	if ($request['sort']) {
		$sort = $request['sort'];
	} else {
		$sort = 'item_id';
	}
	$items = items::get_match($match, $sort);
	$data['pages'] = items::get_page_numbers();
	
	if (!is_array($items)) {
		$items = array();
	}

	$data['NUM'] = count($items);
	$data['ITEMS'] = array();

	foreach ($items as $item) {
		$item['item_id'] = float2num($item['item_id']);
		$item['tag'] = tag2html(items::get_item_tags($item['item_id']));
		$item['tag'].= '';
		$item['status_code'] = items::get_status_code($item['status']);
	    $data['statuses'][$item['status']]++;
		$data['ITEMS'][] = snaf_wrap_data($item, 'item', 'itemlist');
	}
	
    return snaf_wrap_data($data, 'itemlist', 'itemlist');
}

/* Init code goes here */


?>
