<?php

require_once('lib/page-presenters.inc.php');

function build_page-presenter_html($data) {
	return snaf_build_bottom_up($data, 'page-presenters');

}

?>