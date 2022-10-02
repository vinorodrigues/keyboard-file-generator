<?php

$err = "";

$a_map = array(
  0 => array( 0,  8,  2,     6,  9,  7,     1, 10,  3,     4, 11,  5),
  1 => array(-1,  0, -1,    -1,  6, -1,    -1,  1, -1,     4, 11,  5),
  2 => array(-1, -1, -1,     0,  8,  2,    -1, -1, -1,     4, 11,  5),
  3 => array(-1, -1, -1,    -1,  0, -1,    -1, -1, -1,     4, 11,  5),
  4 => array( 0,  8,  2,     6,  9,  7,     1, 10,  3,    -1,  4, -1),
  5 => array(-1,  0, -1,    -1,  6, -1,    -1,  1, -1,    -1,  4, -1),
  6 => array(-1, -1, -1,     0,  8,  2,    -1, -1, -1,    -1,  4, -1),
  7 => array(-1, -1, -1,    -1,  0, -1,    -1, -1, -1,    -1,  4, -1),
);

if (isset($_REQUEST['raw'])) {
  $raw = '{ "keymap":[' . trim($_REQUEST['raw']) . ']}';
  // var_dump($raw);

  $raw = str_replace(
    ['a:', 'c:', 'x:', 'y:', 'w:', 'h:', '\n'],
    ['"a":', '"c":', '"x":', '"y":', '"w":', '"h":', '·'],
    $raw
  );
  // var_dump($raw);

  // echo '<hr>';

  $json = json_decode($raw);
  // var_dump($json);

  $data = array();

  if (is_array($json->keymap)) {
    $root = $json->keymap;

    $row_c = 0;
    $pos_y = 0.0;
    $a = 7;
    $cnt = 0;
    $idy = 0;
    $color = '#000000';

    foreach ($root as $row) {
      if (is_array($row)) {
        $idx = 0;
        $pos_x = 0.0;

        $move_x = 0.0;
        $move_y = 0.0;
        $width = 1.0;
        $height = 1.0;
        foreach ($row as $entry) {
          if (is_object($entry)) {
            $entry = json_decode(json_encode($entry), true);
            if (isset($entry['c'])) $color = $entry['c'];
            if (isset($entry['x'])) $move_x = $entry['x'];
            if (isset($entry['y'])) $move_y = $entry['y'];
            if (isset($entry['w'])) $width = $entry['w'];
            if (isset($entry['h'])) $height = $entry['h'];
            if (isset($entry['a'])) {
              $a = intval($entry['a']);
              if (($a < 0) || ($a > 7)) {
                $err = 'The "a" value is out of range';
                break 2;
              }
            } 
            // echo "O";  // var_dump($entry);
          } elseif (is_string($entry)) {

            $item = array();
            $item['i'] = $cnt;

            /*  KLE locations
                0  8  2
                6  9  7
                1  10 3
                4  11 5
            */

            $item['a'] = $a;
            $item['w'] = $width;
            $item['h'] = $height;
            $item['t'] = array();
            for ($i = 0; $i <= 12; $i++) $item['t'][] = '';  // fill with 12 blanks

            $content = explode('·', $entry, 12);
            /* 0 1 2
               3 4 5
               6 7 8
               9 A B */
            for ($i = 0; $i <= (count($content)-1); $i++) {
              $x = array_search($i, $a_map[$a]);
              if ($x !== false) {
                $item['t'][$x] = $content[$i];
              }
            }

            $pos_x += $move_x;
            $pos_y += $move_y;

            $item['x'] = $pos_x;
            $item['y'] = $pos_y;
            $item['c'] = $color;

            $data[] = $item;

            // echo '[' . $entry . '] ';

            $idx += 1;
            $cnt += 1;

            $pos_x += $width;
            $move_x = 0.0;
            $move_y = 0.0;
            $width = 1.0;
            $height = 1.0;
          } else {
            $err = 'Unknown data at row ' . ($row_c+1) . ', item ' . ($idx+1);
            break 2;
          }
        }


        // var_dump($row);
      } else {
        $err = 'Row ' . ($row_c+1) . ' is not an array';
        break 1;
      }

      $idy += 1;
      $pos_y += 1.0;
    }  // foreeach row

  } else {
    $err = 'Root is not an array';
  }

  // echo '<br><small><pre><b>$data</b> = '; var_dump($data); echo '</pre></small>';
}

// echo "</pre></code>";

if ('' != $err ) {
  echo 'ERROR: ' . $err;
}

// echo "<hr>";
