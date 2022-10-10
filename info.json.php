<?php

global $data, $meta;

include_once 'lib.php';

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) go_to_die();

  header('Content-Type: application/json');
  // header('Content-Type: text/plain');
  header('Content-Disposition: attachment; filename="info.json"');
}

if (isset($data[0]['?'])) {  // max co-ordinates
  $m_cols = $data[0]['?'][0];
  $m_rows = $data[0]['?'][1];
}

// @see: https://docs.qmk.fm/#/reference_info_json 

?>
{
    "manufacturer": "<?= __($meta['manuf']) ?>",
    "keyboard_name": "<?= __($meta['name']) ?>",
    "maintainer": "<?= __($meta['author']) ?>",
    "bootloader": "??",
    "diode_direction": "<?= $m_cols > $m_rows ? 'ROW2COL' : 'COL2ROW' ?>",
    "features": {
        "bootmagic": true,
        "command": false,
        "console": false,
        "extrakey": true,
        "mousekey": true,
        "nkro": true
    },
    "matrix_pins": {
        "cols": [<?php for ($i = 0; $i < $m_cols; $i++) { if ($i > 0) echo ', '; echo '"??"'; } ?>],
        "rows": [<?php for ($i = 0; $i < $m_rows; $i++) { if ($i > 0) echo ', '; echo '"??"'; } ?>]
    },
    "processor": "??",
    "url": "<?= __($meta['url']) ?>",
    "usb": {
        "vid": "0x<?= __($meta['vid'], 4, '0', STR_PAD_LEFT) ?>",
        "pid": "0x<?= __($meta['pid'], 4, '0', STR_PAD_LEFT) ?>",
        "device_version": "<?= __(intval($meta['vmaj'])) ?>.<?= __(intval($meta['vmin'])) ?>.<?= __(intval($meta['vrel'])) ?>"
    },
    "layouts": {
        "LAYOUT_all": {
            "layout": [<?php

  $cnt = 0;
  $lastx = 0;
  foreach ($data as $item) {
    if (isset($item['_'][0]) && !_empty($item['_'][0])) {
      $coord = explode(',', $item['_'][0]);
      $_col = $coord[0];
      $_row = $coord[1];
    } else {
      continue;
    }

    if ($cnt != 0) echo ',';

    if ($item['x'] < $lastx) {
      echo PHP_EOL;
    }
    $lastx = $item['x'];

    echo PHP_EOL . _t(4) . '{';
    echo '"matrix": [' . $_col . ', ' . $_row . ']';
    echo ', "x": ' . $item['x'];
    echo ', "y": ' . $item['y'];

    if (isset($item['w']) && ($item['w'] > 1)) 
      echo ', "w": ' . $item['w'];
    if (isset($item['h']) && ($item['h'] > 1)) 
      echo ', "h": ' . $item['h'];

    if (isset($item['_'][7]) && !_empty($item['_'][7]))
      echo ', "label": "' . htmlspecialchars(str_replace('\\', '\\\\', $item['_'][7])) . '"';

    echo '}';
    $cnt++;
  }

// { "label": "Backspace", "matrix": [0, 13], "x":13, "y":0, "w":2 },

  echo PHP_EOL;
?>
            ]
        }
    }
}
