<?php

global $data;

/**
 * Keycaps are 18x18mm (0.7087x0.7087inch), PCB spacing is 19.05x19.05mm (0.75x0.75inch)
 * XML generated to 300dpi
 */

define('LEN_1U', (0.75 * 300));
define('CAP_1U', (0.7087 * 300));
define('DELTA', (LEN_1U - CAP_1U));
define('HALFD', (DELTA / 2));

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) {
    echo 'No data';
    die();
  }
  header('Content-Type: image/svg+xml');
  header('Content-Disposition: attachment; filename="kb.svg"');
}

if (!$is_inline) {
  echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
}

if (isset($data[0]['>'])) {  // max co-ordinates
  $maxx = $data[0]['>'][0];
  $maxy = $data[0]['>'][1];
} else {
  $maxx = $maxy = 0.0;
  foreach ($data as $item) {
    if ($item['x'] > $maxx) $maxx = $item['x'];
    if ($item['y'] > $maxy) $maxy = $item['y'];
  }
}

echo '<svg';
// echo ' width="' . (($maxx + 1) * LEN_1U) . 'px" height="' . (($maxy + 1) * LEN_1U) . 'px"';
echo ' viewBox="' . (1 - DELTA) . ' ' . (1 - DELTA) . ' ' . ((($maxx + 1) * LEN_1U) + (DELTA * 2)) . ' ' . ((($maxy + 1) * LEN_1U) + (DELTA * 2)) . '"';
if (!$is_inline) {
  echo ' version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"';
} else {
  echo ' class="svg img-fluid"';
}
echo ' xmlns="http://www.w3.org/2000/svg">' . PHP_EOL;

echo '<g id="SVG_KeyMap" fill="none" fill-rule="evenodd">';

$sz = count($data);
if ($sz < 10) { $sz = 1; } elseif ($sz < 100) { $sz = 2; } else { $sz = 3; }
$sz = '%0'.$sz.'d';

// echo '<rect stroke="#eeeeee" fill="#eeeeee" stroke-width="1" x="1" y="1" width="' . ((($maxx + 1) * LEN_1U) - 1) . '" height="' . ((($maxy + 1) * LEN_1U) - 1) . '"></rect>';

/** Key Outline */
echo PHP_EOL . '  <g stroke="#000000" stroke-width="5" fill-opacity="1.0">';
foreach ($data as $item) {
  if (array_key_exists('d', $item) && $item['d']) {
    // ignore and continue
  } elseif (array_key_exists('e', $item)) {
    echo PHP_EOL . '    <ellipse' .
      ' id="K_' . sprintf($sz, $item['i']) . '"' .
      ' cx="' . (($item['x'] * LEN_1U) + ((LEN_1U * $item['w']) / 2)) . '"' .
      ' cy="' . (($item['y'] * LEN_1U) + ((LEN_1U * $item['h']) / 2)) . '"' . 
      ' rx="' . (($item['w'] * (LEN_1U) / 2) - HALFD) . '"' .
      ' ry="' . (($item['h'] * (LEN_1U) / 2) - HALFD) . '"' .
      ' fill="' . $item['c'] . '"' . 
      ' />';

    echo PHP_EOL . '    <ellipse' .
      ' id="L_' . sprintf($sz, $item['i']) . '"' .
      ' cx="' . (($item['x'] * LEN_1U) + ((LEN_1U * $item['w']) / 2)) . '"' .
      ' cy="' . (($item['y'] * LEN_1U) + ((LEN_1U * $item['h']) / 2)) . '"' . 
      ' rx="' . (($item['w'] * (LEN_1U) / 2) - (HALFD * 3)) . '"' .
      ' ry="' . (($item['h'] * (LEN_1U) / 2) - (HALFD * 3)) . '"' .
      ' stroke-opacity="0.3" fill="#FFFFFF" fill-opacity="0.4"' . 
      ' />';
  } else {
    echo PHP_EOL . '    <rect' . 
      ' id="K_' . sprintf($sz, $item['i']) . '"' .
      ' x="' . (($item['x'] * LEN_1U) + HALFD) . '"' .
      ' y="' . (($item['y'] * LEN_1U) + HALFD) . '"' . 
      ' width="' . ((LEN_1U * $item['w']) - DELTA) . '"' . 
      ' height="' . ((LEN_1U * $item['h']) - DELTA) . '"' .
      ' rx="' . (CAP_1U / 10) . '"' .
      ' fill="' . $item['c'] . '"' . 
      ' />';

    echo PHP_EOL . '    <rect' . 
      ' id="L_' . sprintf($sz, $item['i']) . '"' .
      ' x="' . (($item['x'] * LEN_1U) + HALFD + DELTA) . '"' .
      ' y="' . (($item['y'] * LEN_1U) + HALFD + DELTA) . '"' . 
      ' width="' . ((LEN_1U * $item['w']) - (DELTA * 3)) . '"' . 
      ' height="' . ((LEN_1U * $item['h']) - (DELTA * 3) - (CAP_1U / 8)) . '"' .
      ' rx="' . (DELTA * 2) . '"' .
      ' stroke-opacity="0.3" fill="#FFFFFF" fill-opacity="0.4"' . 
      ' />';
  }
}
echo PHP_EOL . '  </g>';

/** Key text */

echo PHP_EOL . '  <g font-family="Helvetica" font-size="48" font-weight="normal">';
foreach ($data as $item) {

  $ofs = array_key_exists('e', $item) ? 0 : HALFD;
  $_x = ($item['x'] * LEN_1U) + ((LEN_1U * $item['w']) / 2);
  $_y = ($item['y'] * LEN_1U) + ((LEN_1U * $item['h']) / 2) - $ofs;
  echo PHP_EOL . '    <text' . 
    ' id="T_' . sprintf($sz, $item['i']) . '"' .
    ' x="' . $_x . '"' .
    ' y="' . $_y . '"' . 
    ' fill="' . $item['t'] . '"' .
    ' text-anchor="middle" alignment-baseline="middle"' .
    '>' .
    $item['_'][7] .
    '</text>';

  if (array_key_exists('e', $item)) {
    if (!empty($item['_'][3])) {
      $_x = ($item['x'] * LEN_1U) + (LEN_1U / 8);
      $_y = ($item['y'] * LEN_1U) + (LEN_1U / 8);
      echo PHP_EOL . '    <text' .
        ' transform="rotate(-45.0, ' . $_x . ', ' . $_y . ')"' . 
        ' font-size="36"' .
        ' id="T_CCW_' . sprintf($sz, $item['i']) . '"' .
        ' x="' . $_x . '"' .
        ' y="' . $_y . '"' . 
        ' fill="' . $item['t'] . '"' .
        ' text-anchor="middle" alignment-baseline="middle" font-weight="bold"' .
        '>' .
        $item['_'][3] .
        '</text>';
    }
    if (!empty($item['_'][5])) {
      $_x = ($item['x'] * LEN_1U) + (LEN_1U * $item['w']) - (LEN_1U / 8);
      $_y = ($item['y'] * LEN_1U) + (LEN_1U / 8);
      echo PHP_EOL . '    <text' . 
        ' transform="rotate(45.0, ' . $_x . ', ' . $_y . ')"' . 
        ' font-size="36"' .
        ' id="T_CW_' . sprintf($sz, $item['i']) . '"' .
        ' x="' . $_x . '"' .
        ' y="' . $_y . '"' . 
        ' fill="' . $item['t'] . '"' .
        ' text-anchor="middle" alignment-baseline="middle" font-weight="bold"' .
        '>' .
        $item['_'][5] .
        '</text>';
    }
  }
}
echo PHP_EOL . '  </g>';

echo PHP_EOL . '</g>';
echo PHP_EOL . '</svg>';
