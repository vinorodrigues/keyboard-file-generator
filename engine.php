<?php

$err = "";

/*  KLE locations
  0  8  2
  6  9  7
  1  10 3
  4  11 5
*/

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
    ['a:', 'c:', 'x:', 'y:', 'w:', 'h:', 'd:', 'n:',  '\n', ':true', ':false'],
    ['"a":', '"c":', '"x":', '"y":', '"w":', '"h":', '"d":', '"n":',  '·', ':1', ':0'],
    $raw
  );
  
  // echo '<textarea>';
  // var_dump($raw);
  // echo '</textarea>';

  // echo '<hr>';

  $json = json_decode($raw);
  // var_dump($json);

  $data = array();

  if (is_array($json->keymap)) {
    $root = $json->keymap;

    $row_c = 0;
    $pos_y = 0.0;
    $a = 4;
    $cnt = 0;
    $idy = 0;
    $color = '#000000';
    $text = '#000000';
    $m_rows = 0;
    $m_cols = 0;
    $decal_next = false;

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
            if (isset($entry['t'])) $text = $entry['t'];
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
            if (isset($entry['d']) && ($entry['d'] == 1)) $decal_next = true;
            // echo "O";  // var_dump($entry);

          } elseif (is_string($entry)) {

            $item = array();
            $item['i'] = $cnt;

            $item['a'] = $a;
            $item['w'] = $width;
            $item['h'] = $height;

            $item['_'] = array();
            for ($i = 0; $i <= 12; $i++) $item['_'][] = '';  // fill with 12 blanks
            $content = explode('·', $entry, 12);
            /* 0 1 2
               3 4 5
               6 7 8
               9 A B */
            for ($i = 0; $i <= (count($content)-1); $i++) {
              $x = array_search($i, $a_map[$a]);
              if ($x !== false) {
                $item['_'][$x] = $content[$i];
              }
            }

            // check if top left is matrix row,col
            if ($item['_'][0] != '') {
              $m = explode(',', $item['_'][0]);
              if (count($m) == 2) {
                $item['m'] = $m;
                if ($m[0] > $m_rows) $m_rows = $m[0];
                if ($m[1] > $m_cols) $m_cols = $m[1];
              }
            }

            // check if bottom right is group,option numbers
            if ($item['_'][0] != '') {
              $g = explode(',', $item['_'][11]);
              if (count($g) == 2) {
                $item['o'] = $g;
              }
            }

            // check if rotary encoder
            if (($item['_'][4] != '') && (str_starts_with($item['_'][4], 'e'))) {
              $s = substr($item['_'][4], 1);
              if (empty($s)) {
                $i = 0;
              } else {
                $i = intval($s);
              }
              $item['e'] = $i;
            }

            $pos_x += $move_x;
            $pos_y += $move_y;

            $item['x'] = $pos_x;
            $item['y'] = $pos_y;
            $item['c'] = $color;
            $item['t'] = $text;

            if ($decal_next) {
              $decal_next = false;
              $item['d'] = true;
            }

            /* assignment */

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

    if (count($data) > 0) {
      // first key will have the matrix size
      $data[0]['n'] = array($m_rows + 1, $m_cols + 1);
    }

  } else {
    $err = 'Root is not an array';

    echo '<p class="text-danger">JSON Decode Error - ';
    switch (json_last_error()) {
      case JSON_ERROR_NONE:           echo '?none'; break;
      case JSON_ERROR_DEPTH:          echo 'Maximum stack depth exceeded'; break;
      case JSON_ERROR_STATE_MISMATCH: echo 'Underflow or the modes mismatch'; break;
      case JSON_ERROR_CTRL_CHAR:      echo 'Unexpected control character found'; break;
      case JSON_ERROR_SYNTAX:         echo 'Syntax error, malformed JSON'; break;
      case JSON_ERROR_UTF8:           echo 'Malformed UTF-8 characters, possibly incorrectly encoded'; break;
      default:                        echo 'Unknown error'; break;
    }
    echo '</p>';
  }

  // echo '<br><small><pre><b>$data</b> = '; var_dump($data); echo '</pre></small>';
}

// echo "</pre></code>";

if ('' != $err ) {
  echo 'ERROR: ' . $err;
}

// echo "<hr>";
