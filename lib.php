<?php

function _empty(&$var) {
  return (empty($var) && ($var !== '0'));
}

function __($d, $length = -1, $pad_string = ' ', $pad_type = STR_PAD_RIGHT) {
  $ret = '';
  if (isset($d)) {
    if (!empty($d)) {
      $ret = $d;
    } elseif (is_numeric($d)) {
      $ret = 0;
    } else {
      $ret = '??';
    }
  } else {
    $ret = '!!';
  }
  return str_pad($ret, $length, $pad_string, $pad_type);
}

function _t($n = 1) {
  $res = '';
  for ($i=0; $i < $n; $i++) $res .= '    ';
  return($res);
}

function go_to_die() {
  header("HTTP/1.1 500 Server Error");
  http_response_code(500);
  @include '500.html';
  exit();
}

function get_meta($name) {
  global $meta;
  if (is_array($meta) && isset($meta[$name]) && !empty($meta[$name])) {
    return $meta[$name];
  } else {
    return '?' . $name . '?';
  }
}

function count_led_keys(&$data, $return_full_count = true) {
  $cnt = 0;
  foreach ($data as $item) {
    if (!_empty( $item['_'][10] )) $cnt++;
    if (!$return_full_count && ($cnt > 0)) break;
  }
  if ($return_full_count) {
    return $cnt;
  } else {
    return $cnt > 0;
  }
}

function jsspecialchars($str) {
  return str_replace(
    ["'",   "\"",   "`",   "\r", "\n"],
    ["\\'", "\\\"", "\\'", "",   "\\n \\\n"],
    $str
  );
}
