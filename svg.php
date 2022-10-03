<?php

/**
 * Keycaps are 18x18mm (0.7087x0.7087inch), PCB spacing is 19.05x19.05mm (0.75x0.75inch)
 * XML generated to 300dpi
 */

/*
<?xml version="1.0" encoding="UTF-8"?>
<svg width="227px" height="227px" viewBox="0 0 227 227" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <!-- Generator: Sketch 61.2 (89653) - https://sketch.com -->
    <title>Page 1</title>
    <desc>Created with Sketch.</desc>
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect id="Frame" stroke="#000000" x="1" y="1" width="225" height="225"></rect>
        <rect id="L_0" stroke="#979797" fill="#D8D8D8"                    x="30" y="18" width="166" height="165" rx="8"></rect>
        <rect id="K_0" stroke="#777777" fill-opacity="0.5" fill="#CCCCCC" x="7" y="7" width="212.59842" height="212.59842" rx="8"></rect>
        <text id="Esc" fill="#000000" font-family="Roboto-Regular, Roboto" font-size="48" font-weight="normal">
            <tspan x="74.921875" y="130">Esc</tspan>
        </text>
    </g>
</svg>
*/

define('LEN_1U', (0.75 * 300));
define('CAP_1U', (0.7087 * 300));
define('DELTA', (LEN_1U - CAP_1U));
define('HALFD', (DELTA / 2));

$is_inline = isset($data);

if (!$is_inline) {
  header('Content-Type: image/svg+xml');
} else {

}

if (!$is_inline) {
  echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
} else {
  echo '<div class="svg-wrapper">';
}

$maxx = 0;
$maxy = 0;
foreach ($data as $key) {
  if ($key['x'] > $maxx) $maxx = $key['x'];
  if ($key['y'] > $maxy) $maxy = $key['y'];
}

echo '<svg xwidth="' . (($maxx + 1) * LEN_1U) . 'px" xheight="' . (($maxy + 1) * LEN_1U) . 'px" viewBox="0 0 ' . (($maxx + 1) * LEN_1U) . ' ' . (($maxy + 1) * LEN_1U) . '"';

if (!$is_inline) {
  echo ' version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"';
} else {
  echo ' class="the-svg"';
}
echo ' xmlns="http://www.w3.org/2000/svg">' . PHP_EOL;

echo '<g id="SVG_KeyMap" fill="none" fill-rule="evenodd">';

$sz = count($data);
if ($sz < 10) { $sz = 1; } elseif ($sz < 100) { $sz = 2; } else { $sz = 3; }
$sz = '%0'.$sz.'d';

// echo '<rect stroke="#eeeeee" fill="#eeeeee" stroke-width="1" x="1" y="1" width="' . ((($maxx + 1) * LEN_1U) - 1) . '" height="' . ((($maxy + 1) * LEN_1U) - 1) . '"></rect>';

/** Key Outline */
echo PHP_EOL . '<g stroke="#000000" stroke-width="5" fill-opacity="1.0">';
foreach ($data as $key) {
  if (!array_key_exists('e', $key)) {
    echo PHP_EOL . '  <rect' . 
      ' id="K_' . sprintf($sz, $key['i']) . '"' .
      ' x="' . (($key['x'] * LEN_1U) + HALFD) . '"' .
      ' y="' . (($key['y'] * LEN_1U) + HALFD) . '"' . 
      ' width="' . ((LEN_1U * $key['w']) - DELTA) . '"' . 
      ' height="' . ((LEN_1U * $key['h']) - DELTA) . '"' .
      ' rx="' . (CAP_1U / 10) . '"' .
      ' fill="' . $key['c'] . '"' . 
      ' />';

      echo PHP_EOL . '  <rect' . 
      ' id="L_' . sprintf($sz, $key['i']) . '"' .
      ' x="' . (($key['x'] * LEN_1U) + HALFD + DELTA) . '"' .
      ' y="' . (($key['y'] * LEN_1U) + HALFD + DELTA) . '"' . 
      ' width="' . ((LEN_1U * $key['w']) - (DELTA * 3)) . '"' . 
      ' height="' . ((LEN_1U * $key['h']) - (DELTA * 3) - (CAP_1U / 8)) . '"' .
      ' rx="' . (DELTA * 2) . '"' .
      ' stroke-opacity="0.3" fill="#FFFFFF" fill-opacity="0.4"' . 
      ' />';
  } else {
    echo PHP_EOL . '  <ellipse' .
      ' id="K_' . sprintf($sz, $key['i']) . '"' .
      ' cx="' . (($key['x'] * LEN_1U) + ((LEN_1U * $key['w']) / 2)) . '"' .
      ' cy="' . (($key['y'] * LEN_1U) + ((LEN_1U * $key['h']) / 2)) . '"' . 
      ' rx="' . (($key['w'] * (LEN_1U) / 2) - HALFD) . '"' .
      ' ry="' . (($key['h'] * (LEN_1U) / 2) - HALFD) . '"' .
      ' fill="' . $key['c'] . '"' . 
      ' />';

    echo PHP_EOL . '  <ellipse' .
      ' id="L_' . sprintf($sz, $key['i']) . '"' .
      ' cx="' . (($key['x'] * LEN_1U) + ((LEN_1U * $key['w']) / 2)) . '"' .
      ' cy="' . (($key['y'] * LEN_1U) + ((LEN_1U * $key['h']) / 2)) . '"' . 
      ' rx="' . (($key['w'] * (LEN_1U) / 2) - (HALFD * 3)) . '"' .
      ' ry="' . (($key['h'] * (LEN_1U) / 2) - (HALFD * 3)) . '"' .
      ' stroke-opacity="0.3" fill="#FFFFFF" fill-opacity="0.4"' . 
      ' />';
  }

}
echo PHP_EOL . '</g>';

/** Key text */

echo PHP_EOL . '<g font-family="Helvetica" font-size="48" font-weight="normal">';
foreach ($data as $key) {
  // var_dump($key);
  // break;
  echo PHP_EOL . '  <text' . 
    ' id="T_' . sprintf($sz, $key['i']) . '"' .
    ' x="' . (($key['x'] * LEN_1U) + ((LEN_1U * $key['w']) / 2)) . '"' .
    ' y="' . (($key['y'] * LEN_1U) + ((LEN_1U * $key['h']) / 2)) . '"' . 
    ' fill="' . $key['t'] . '"' .
    ' text-anchor="middle" alignment-baseline="middle"' .
    '>' .
    $key['_'][7] .
    '</text>';
}
echo PHP_EOL . '</g>';

  // <rect id="Frame" stroke="#000000" stroke-width="1" x="1" y="1" width="225" height="225"></rect>
  // <rect id="K_0" stroke="#777777" stroke-width="3" fill-opacity="0.5" fill="#CCCCCC" x="7" y="7" width="212.59842" height="212.59842" rx="16"></rect>
  // <text id="Esc" fill="#000000" font-family="Helvetica" font-size="48" font-weight="normal" x="112.5" y="112.5" text-anchor="middle" alignment-baseline="middle">Enter</text>

echo PHP_EOL . '</svg>';
if ($is_inline) {
  echo '</div>';
}
