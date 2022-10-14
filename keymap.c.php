<?php

global $data, $meta;

include_once 'lib.php';

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) go_to_die();
  
  header('Content-Type: plain/text');
  header('Content-Disposition: attachment; filename="keymap.c"');
}

// if (isset($data[0]['?'])) {  // max co-ordinates
//   $m_cols = $data[0]['?'][0];
//   $m_rows = $data[0]['?'][1];
// }

function trim_to_last($string, $substr) {
  $p = strrpos($string, $substr);
  if ($p !== false) {
    return substr($string, 0, $p);
  } else {
    return $string;
  }
}

function get_keymap_output(&$data, $default_key_text, $do_guess = false) {
  $ret = '';

  if ($do_guess) 
    $guess = json_decode(file_get_contents('guess.json'), true);

  $cnt = 0;
  $runx = 0;
  foreach ($data as $item) {
    if (!array_key_exists('x', $item) || !array_key_exists('y', $item)) {
      // no x & y, ignore
    } elseif (array_key_exists('d', $item) && $item['d']) {
      // it's a decal, ignore and continue
    } else {
      if ($item['x'] <= $runx) {
        $ret .= PHP_EOL . _t(2);
        $runx = 0;
      } else {
        $runx = $item['x'];
        if ($cnt > 0) $ret .= ' ';
      }
 
      $s = $do_guess ? $item['_'][2] : '';
      if (_empty($s)) {
        $s = $item['_'][7];
        if ($do_guess && is_array($guess) && array_key_exists($s, $guess)) {
          $s = $guess[$s];
        } else {
          $s = $default_key_text;
        }
      }
      $ret .= str_pad($s . ',', 8);
    }
    $cnt++;
  }
  return trim_to_last($ret, ',') . PHP_EOL;
}

?>
// Copyright <?= date("Y") ?> <?= get_meta('author') ?> (@<?= get_meta('handle') ?>)
// SPDX-License-Identifier: GPL-2.0-or-later

#include QMK_KEYBOARD_H

enum {
    _L0,
    _L1,
    _L2,
    _L3
};

#define XXXXXXX KC_NO

const uint16_t PROGMEM keymaps[][MATRIX_ROWS][MATRIX_COLS] = {
    // TODO: Replace any XXXXXXXX with actual key codes
    [_L0] = LAYOUT_all(<?= get_keymap_output($data, 'XXXXXXX', true) ?>
    ),

    [_L1] = LAYOUT_all(<?= get_keymap_output($data, '_______') ?>
    ),

    [_L2] = LAYOUT_all(<?= get_keymap_output($data, '_______') ?>
    ),

    [_L3] = LAYOUT_all(<?= get_keymap_output($data, '_______') ?>
    )
};

<?php
// #if defined(ENCODER_MAP_ENABLE)

// const uint16_t PROGMEM encoder_map[][NUM_ENCODERS][2] = {
//     [LYR_0] = { ENCODER_CCW_CW(XXXXXXX, XXXXXXX) },
//     [LYR_1] = { ENCODER_CCW_CW(_______, _______) },
//     [LYR_2] = { ENCODER_CCW_CW(_______, _______) },
//     [LYR_3] = { ENCODER_CCW_CW(_______, _______) }
// };

// #endif
