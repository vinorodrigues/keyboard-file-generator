<?php

global $data, $meta;

include_once 'lib.php';

$is_inline = isset($data);
if (!$is_inline) {
  include 'engine.php';

  if (!isset($data) || empty($data)) go_to_die();
  
  header('Content-Type: application/json');
  header('Content-Disposition: attachment; filename="kb.json"');
}

// if (isset($data[0]['?'])) {  // max co-ordinates
//   $m_cols = $data[0]['?'][0];
//   $m_rows = $data[0]['?'][1];
// }

?>
