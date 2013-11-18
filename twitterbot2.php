<?php
require_once('lib/people.inc.php');
require_once('lib/twitter.inc.php');

$query = array('q' => 'to:gashscav');
$newq = `cat /tmp/twitter_query2`;
if ($newq) $query = $newq;

$data = Twitter::search($query);
var_dump($data);
foreach ($data['results'] as $tweet) {
  echo $tweet['from_user'].': '.$tweet['text']."\n";
  $user = people::twitter_lookup($tweet['from_user']);
  if (!$user) continue;
  try {
    $text = str_replace('@gashscav ', '', $tweet['text']);
    $text .= ' - @'.$tweet['from_user'];
    echo $text."\n";
    Twitter::tweet($text);
  } catch (Exception $e) {
    echo $e->getMessage()."\n";
  }
}
$new_query = $data['refresh_url'];
`echo '$new_query' > /tmp/twitter_query2`

?>
