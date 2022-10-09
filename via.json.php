<?php

global $data, $meta, $vial;

$is_vial = isset($vial) ? true : isset($_REQUEST['vial']);  // test if Global is there

include_once 'lib.php';

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) go_to_die();
  
  header('Content-Type: application/json');
  header('Content-Disposition: attachment; filename="' . ($is_vial ? 'vial' : 'kb') . '.json"');
}

if (isset($data[0]['?'])) {  // max co-ordinates
  $m_cols = $data[0]['?'][0];
  $m_rows = $data[0]['?'][1];
} else {
  $m_cols = '';
  $m_rows = '';
}
$has_led = count_led_keys($data, false);

?>
{
<?php
if (!$is_vial) {
?>
    "name":"<?= __($meta['name']) ?>",
    "vendorId":"0x<?= __($meta['vid']) ?>",
    "productId":"0x<?= __($meta['pid']) ?>",
<?php
  if ($has_led) {
?>
    "lighting": {
        "extends":"qmk_rgblight",
        "supportedLightingValues": [128, 129, 130, 131],
        "underglowEffects": [
            ["00. None", 0]
        ]
    },
<?php
  }
}
?>
    "matrix":{ "rows":<?= __($m_rows) ?>, "cols":<?= __($m_cols) ?> },
    "layouts":{
        "keymap":[<?php

// [{"c":"#777777"},"0,0",{"c":"#cccccc"},"0,1","0,2","0,3","0,4","0,5","0,6","0,7","0,8","0,9","0,10","0,11","0,12",{"c":"#aaaaaa","w":2},"0,13"],
// [{"w":1.5},"1,0",{"c":"#cccccc"},"1,1","1,2","1,3","1,4","1,5","1,6","1,7","1,8","1,9","1,10","1,11","1,12",{"c":"#aaaaaa","w":1.5},"1,13"],
// [{"w":1.75},"2,0",{"c":"#cccccc"},"2,1","2,2","2,3","2,4","2,5","2,6","2,7","2,8","2,9","2,10","2,11",{"c":"#777777","w":2.25},"2,12"],
// [{"c":"#aaaaaa","w":2.25},"3,0",{"c":"#cccccc"},"3,2","3,3","3,4","3,5","3,6","3,7","3,8","3,9","3,10","3,11",{"c":"#aaaaaa","w":2.75},"3,12"],
// [{"w":1.25},"4,0",{"w":1.25},"4,1",{"w":1.25},"4,2",{"w":6.25},"4,6",{"w":1.25},"4,10",{"w":1.25},"4,11",{"w":1.25},"4,12",{"w":1.25},"4,13"]

// $cnt = 0;
$row = -1;
$col = 999;
$c_1st = false;
$r_1st = true;
$lstclr = '';
$runx = $runy = 0;

foreach ($data as $item) {
  if (!array_key_exists('x', $item) || !array_key_exists('y', $item)) {
    // no x & y, ignore
  } elseif (array_key_exists('d', $item) && $item['d']) {
    // it's a decal, ignore and continue
  } else {
    $ix = $item['x'];
    $iy = $item['y'];
    $iw = $item['w'];
    $ih = $item['h'];
    $ic = $item['c'];
    if ($iy > $row) {
      if (!$r_1st) {
        // ** new row **
        echo '],';
        $runx = 0;
        $runy++;
      } else {
        $r_1st = false;
      }
      echo PHP_EOL . _t(3) . '[';
      $row = $iy;
      $c_1st = true;
    }
    if (!$c_1st) {
      echo ',';
    }
    if (($iw != 1) || ($ih != 1) || ($lstclr != $ic) || ($runx <> $ix) || ($runy <> $iy)) {
      $attr = array();
      if ($iw != 1) $attr['w'] = $iw;
      if ($ih != 1) $attr['h'] = $ih;
      if ($lstclr != $ic) {
        $attr['c'] = $ic;
        $lstclr = $ic;
      }
      if ($runx <> $ix) $attr['x'] = $ix - $runx;
      if ($runy <> $iy) {
        $attr['y'] = $iy - $runy;
        if ($c_1st) $runy = $iy;  // adjust to new y .. should only happen on first item
      }
      echo json_encode($attr) . ',';
      unset($attr);
    }
    echo '"' . $item['_'][0];
    if (!_empty($item['_'][4]) && ('e' == $item['_'][4][0])) {
      // rotary encoder position, only if it's an 'e'
      echo '\n\n\n\n\n\n\n\n\n';
      if (!$is_vial) { 
        echo $item['_'][4];
      } else { 
        echo 'e'; // just first char
      }
    }
    echo '"';
    $c_1st = false;
    $runx = $ix + $iw;
  }
  // $cnt++;
}
if (!$r_1st) {
  echo ']' . PHP_EOL;
}

?>
        ]
    }
}
