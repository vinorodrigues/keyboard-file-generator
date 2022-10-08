<?php

function __(&$d) {
  if (isset($d)) {
    if (!empty($d)) {
      return $d;
    } else {
      return '??';
    }
  } else {
    return '!!';
  }
}

function _t($n = 1) {
  $res = '';
  for ($i=0; $i < $n; $i++) $res .= '    ';
  return($res);
}

function _empty(&$var) {
  return (empty($var) && ($var !== '0'));
}

function go_to_die() {
  echo 'No data';
  die();
}

function get_meta($name) {
  global $meta;
  if (is_array($meta) && isset($meta[$name]) && !empty($meta[$name])) {
    return $meta[$name];
  } else {
    return '?' . $name . '?';
  }
}

function count_keys(&$data, $return_full_count = true) {
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
