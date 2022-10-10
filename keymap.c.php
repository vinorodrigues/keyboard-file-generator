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

function generate_keymap_out(&$data, $default_key_text) {
  $runx = 0;
  $cnt = 0;
  foreach ($data as $item) {
    if (!array_key_exists('x', $item) || !array_key_exists('y', $item)) {
      // no x & y, ignore
    } elseif (array_key_exists('d', $item) && $item['d']) {
      // it's a decal, ignore and continue
    } else {
      if ($cnt > 0) echo ',';
      if ($item['x'] <= $runx) {
        echo PHP_EOL . _t(2);
        $runx = 0;
      } else {
        $runx = $item['x'];
        if ($cnt > 0) echo ' ';
      }
      echo $default_key_text;
    }
    $cnt++;
  }
  echo PHP_EOL;
}

?>
// Copyright <?= date("Y") ?> <?= get_meta('author') ?> (@<?= get_meta('handle') ?>)
// SPDX-License-Identifier: GPL-2.0-or-later

#include QMK_KEYBOARD_H
#include "keymaps.h"

enum {
    LYR_0,
    LYR_1,
    LYR_2,
    LYR_3
};

#define XXXXXXX KC_NO

const uint16_t PROGMEM keymaps[][MATRIX_ROWS][MATRIX_COLS] = {
    [LYR_0] = LAYOUT_all(<?php generate_keymap_out($data, 'XXXXXXX') ?>
    ),

    [LYR_1] = LAYOUT_all(<?php generate_keymap_out($data, '_______') ?>
    ),

    [LYR_2] = LAYOUT_all(<?php generate_keymap_out($data, '_______') ?>
    ),

    [LYR_3] = LAYOUT_all(<?php generate_keymap_out($data, '_______') ?>
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
