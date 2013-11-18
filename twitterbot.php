<?php
require_once('lib/people.inc.php');

$baseurl = 'http://search.twitter.com/search.json';
# $query = '?q=to%3Agashscav';
$query = '?q=%23gash';
# $query = '?q=%40gashscav';
$newq = `cat /tmp/twitter_query`;
if ($newq) $query = $newq;

function do_search($qstring) {
  global $baseurl;
  $url = $baseurl . $qstring;
  echo "Using $url\n";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $json = curl_exec($ch);
  if (!$json) {
    throw new Exception(curl_error($ch));
  }
  $data = json_decode($json, 1);
  return $data;
}

$data = do_search($query);
foreach ($data['results'] as $tweet) {
  echo $tweet['from_user'].': '.$tweet['text']."\n";
  try {
    people::tweet_status($tweet['from_user'], $tweet['text']);
  } catch (Exception $e) {
    echo $e->getMessage()."\n";
  }
}
$new_query = $data['refresh_url'];
`echo '$new_query' > /tmp/twitter_query`

?>
