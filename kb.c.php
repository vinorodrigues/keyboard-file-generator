<?php

global $data, $meta;

include_once 'lib.php';

function build_matrix(&$data) {
  if (!isset($data) && !is_array($data)) return null;

  if (isset($data[0]['?']) && is_array($data[0]['?'])) {
    $_x = $data[0]['?'][0];
    $_y = $data[0]['?'][1];
  } else 
    return null;

  $ret = array();

  for ($i=0; $i < $_y; $i++) { 
    $ret[$i] = array();
    for ($j=0; $j < $_x ; $j++) { 
      $ret[$i][$j] = null;
    }
  }

  foreach($data as $item) {
    if (isset($item['_']) && isset($item['_'][0]) && !_empty($item['_'][0])) {
      $coord = explode(',', $item['_'][0]);
      if (2 == count($coord)) {
        $_c = $coord[0];
        $_r = $coord[1];
        $ret[$_c][$_r] = $item;
      }
    }
  }

  return $ret;
}

function do_led_matrix(&$data, &$matrix) {
  if (!isset($matrix) || !is_array($matrix)) return;

  $_r = count($matrix);
  $_c = count($matrix[0]);
  $_t = count_led_keys($data);
  if ($_t < 100) { $_p = 2; } else { $_p = 3; }

  $p = 0;
  for ($i=0; $i < $_r; $i++) { 
    echo _t() . '{ ';

    $q = 0;
    for ($j=0; $j < $_c; $j++) { 
      $v = null;
      if (!is_null($matrix[$i][$j]) && isset($matrix[$i][$j]['_']) && isset($matrix[$i][$j]['_'][10]) && is_numeric($matrix[$i][$j]['_'][10])) 
        $v = intval($matrix[$i][$j]['_'][10]);

      if (null === $v) {
        echo str_pad('__', $_p, ' ', STR_PAD_LEFT);
      } else {
        echo str_pad($v, $_p, ' ', STR_PAD_LEFT);
      }
      $q++;
      if ($q < $_c) echo ', ';
    }

    echo ' }';
    $p++;
    if ($p < $_r) echo ',' . PHP_EOL;
  }

  echo PHP_EOL;
}

function do_led_positions(&$data) {
  if (isset($data[0]['<']) && isset($data[0]['>'])) {  // min & max co-ordinates
    $minx = $data[0]['<'][0];
    $miny = $data[0]['<'][1];
    $maxx = $data[0]['>'][0];
    $maxy = $data[0]['>'][1];
  } else {
    $minx = $miny = 999.0;
    $maxx = $maxy = 0.0;
    foreach ($data as $item) {
      if ($item['x'] < $minx) $minx = $item['x'];
      if ($item['y'] < $miny) $miny = $item['y'];
      if ($item['x'] > $maxx) $maxx = $item['x'];
      if ($item['y'] > $maxy) $maxy = $item['y'];
    }
  }
  $maxx -= $minx;
  $maxy -= $miny;

  /*
   * @see: https://docs.qmk.fm/#/feature_rgb_matrix
   * expected range of values for { x, y } is the inclusive range { 0..224, 0..64 }
   */

  $constx = 224;
  $consty = 64;

  // $runy = 0.0;
  $runx = 0;
  $cnt = 0;
  echo _t(1);
  foreach ($data as $item) {
    if (!array_key_exists('x', $item) || !array_key_exists('y', $item)) {
      // no x & y, ignore
    } elseif (array_key_exists('d', $item) && $item['d']) {
      // it's a decal, ignore and continue
    } else {
      if ($cnt > 0) echo ',';
      if ($item['x'] <= $runx) {
        if ($cnt > 0) echo PHP_EOL . _t(1);
        $runx = 0;
      } else {
        $runx = $item['x'];
        if ($cnt > 0) echo ' ';
      }
      $valx = round( (($item['x'] + ($item['w'] / 2)) - 0.5 ) * ($constx / $maxx) );
      $valy = round( (($item['y'] + ($item['h'] / 2)) - 0.5 ) * ($consty / $maxy) );
      echo '{ ' . str_pad($valx, 3, ' ', STR_PAD_LEFT) . ', ' . str_pad($valy, 2, ' ') . ' }';
    }
    $cnt++;
  }
  echo PHP_EOL;
}

function do_led_flags(&$data) {
  $runx = 0;
  $cnt = 0;
  echo _t(1);
  foreach ($data as $item) {
    if (!array_key_exists('x', $item) || !array_key_exists('y', $item)) {
      // no x & y, ignore
    } elseif (array_key_exists('d', $item) && $item['d']) {
      // it's a decal, ignore and continue
    } else {
      if ($cnt > 0) echo ',';
      if ($item['x'] <= $runx) {
        if ($cnt > 0) echo PHP_EOL . _t(1);
        $runx = 0;
      } else {
        $runx = $item['x'];
        if ($cnt > 0) echo ' ';
      }
      echo '4';
    }
    $cnt++;
  }
  echo PHP_EOL;
}

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) go_to_die();
  
  header('Content-Type: text/plain');
  header('Content-Disposition: attachment; filename="kb.c"');
}

$has_led = count_led_keys($data, false);

if (!isset($matrix) || !is_array($matrix)) 
  $matrix = build_matrix($data);

?>
// Copyright <?= date("Y") ?> <?= get_meta('author') ?> (@<?= get_meta('handle') ?>)
// SPDX-License-Identifier: GPL-2.0-or-later

#include "??.h"

<?php if ($has_led) { ?>
#if defined(RGB_MATRIX_ENABLE)

#define __ NO_LED

led_config_t g_led_config = { {
    // Key Matrix to LED Index
<?= do_led_matrix($data, $matrix) ?>
}, {
    // LED Index to Physical Position
<?= do_led_positions($data) ?>
}, {
    // LED Index to Flag
    // MODIFIER = 0x01, UNDERGLOW = 0x02, KEYLIGHT = 0x04, & INDICATOR = 0x08
<?= do_led_flags($data) ?>
} };

#endif  // RGB_MATRIX_ENABLE
<?php } else { ?>
// No LED's defined in $data
<?php }
