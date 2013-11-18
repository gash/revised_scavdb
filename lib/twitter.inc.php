<?php

class Twitter {
  public static $username = 'gashscav';
  private static $password = 'bopcbopc';

  function call_api($base, $method, $params, $auth=false, $post=false) {
    $url = $base . $method . '.json';
    if (is_array($params)) {
      $parts = array();
      foreach ($params as $k => $v) {
	$parts[] = $k . '=' . urlencode($v);
      }
      $qstring = implode('&', $parts);
    } else {
      $qstring = $params;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($auth) {
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_USERPWD, self::$username . ':' . self::$password);
    }
    if ($post) {
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $qstring);
      curl_setopt($ch, CURLOPT_URL, $url);
    } else {
      if ($qstring) {
	if ($qstring[0] != '?') $url .= '?';
	$url .= $qstring;
      }
      curl_setopt($ch, CURLOPT_URL, $url);
    }

    $json = curl_exec($ch);
    $data = json_decode($json, 1);
    return $data;
  }

  function user_api($method, $params) {
    return self::call_api('http://twitter.com/', $method, $params, true);
  }

  function post_api($method, $params) {
    return self::call_api('http://twitter.com/', $method, $params, true, true);
  }

  function public_api($method, $params) {
    return self::call_api('http://twitter.com/', $method, $params, false);
  }

  function search_api($method, $params) {
    return self::call_api('http://search.twitter.com/', $method, $params, false);
  }

  function tweet($text) {
    return self::post_api('statuses/update', array('status' => $text));
  }

  function search($params) {
    return self::search_api('search', $params);
  }

  function friend_all() {
  }
}
?>
