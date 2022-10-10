<?php

define('GITHUB_URL', 'https://github.com/vinorodrigues/keyboard-file-generator/');
define('GITHUB_FILE', GITHUB_URL . '/blob/main/');
global $err, $data, $meta;

include_once 'lib.php';
include 'engine.php';
include_once 'Parsedown.php';

/**
 * @see: https://fontawesome.com/v5/search?o=r&m=free
 */

function __v($val, $def = null, $echo = false) {
  $ret = null;
  if (isset($_REQUEST[$val])) {
    $ret = $_REQUEST[$val];
  } elseif (!is_null($def)) {
    $ret = $def;
  }
  if ($echo) echo $ret;
  else return $ret;
}

$has_data = (isset($data) && !empty($data));

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/vinorodrigues/bootstrap-dark@0.6.1/dist/bootstrap-dark.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-okaidia.css" media="(prefers-color-scheme: dark)">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism.min.css" media="(prefers-color-scheme: no-preference), (prefers-color-scheme: light)">    

    <title>Keyboard File Generator</title>

    <style>
      .svg {
        max-width: 100% !important;
        height: auto !important;
      }

      .token.comment {
        font-style: italic;
      }

      code[class*="language-"], 
      pre[class*="language-"] {
        max-height: 360px;
        font-size: 0.8rem !important;
        line-height: 1.2;
      }
    </style>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="."><i class="far fa-keyboard"></i> keyboard-file-generator.com</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
        </ul>
        <span class="navbar-text">
          &copy; Vino Rodrigues
        </span>
      </div>
    </nav>

    <div class="container my-3 border-bottom mb-3 pb-3">

      <div class="my-2 p-2 bg-light text-right">
        <a class="btn btn-sm btn-info-outline" data-toggle="collapse" href="#entryForm" role="button" aria-expanded="false"><i class="fab fa-wpforms"></i> Toggle Form</a>
        <a class="btn btn-sm btn-info-outline" data-toggle="collapse" href="#helpPage" role="button" aria-expanded="false"><i class="far fa-question-circle"></i> Toggle Help</a>
        <?php if (!$has_data) : ?>
        <a class="btn btn-sm btn-secondary-outline" href="#" id="sampleDataButton" role="button" aria-expanded="false"><i class="far fa-keyboard"></i> Load Sample data</a>
        <?php endif; ?>
      </div>

      <div class="mb-5 p-3 bg-light card collapse shadow" id="helpPage">
        <?php
          $pd = new Parsedown();
          $help_content = file_get_contents('docs/howto.md');
          $help_content = str_replace(['src="./'], ['src="./docs/'], $help_content);
          echo $pd->text($help_content);
        ?>
      </div>

      <form action="." method="post" enctype="multipart/form-data" accept=".json" autocomplete="off" name="entryForm" id="entryForm" class="collapse <?= ($has_data ? '' : 'show') ?>">

        <div class="form-group row">
          <label for="file" class="col-sm-6 col-form-label">Keyboard Layout Editor exported <code>JSON</code> file:</label>
          <div class="col-sm-6">
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="file" name="file">
              <label class="custom-file-label" for="file" id="file_label">Choose file...</label>
            </div>
          </div>
        </div>

        <p class="form-group">
          <i>&hellip; OR &hellip;</i>
        </p>

        <div class="form-group">
          <label for="raw">Keyboard Layout Editor Raw data:</label>
          <textarea
            class="form-control text-monospace" 
            id="raw" 
            name="raw" 
            rows="10" 
            spellcheck="false"><?= __v('raw') ?></textarea>
        </div>

        <hr>

        <div class="row">
          <div class="col-md-6">

            <div class="form-group">
              <label for="name">Board Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?= __v('name') ?>" placeholder="Board Name" autocomplete="off" data-lpignore="true">
              <small id="name" class="form-text text-muted">This is the board name as displayed on VIA's top right corner.</small>
            </div>

            <div class="form-group">
              <label for="manuf">Manufacturer</label>
              <input type="text" class="form-control" id="manuf" name="manuf" value="<?= __v('manuf') ?>" placeholder="Manufacturer" autocomplete="off" data-lpignore="true">
              <small id="manuf" class="form-text text-muted">English name of the Vendor</small>
            </div>

            <div class="form-group row">
              <label for="vid" class="col-sm-3 col-form-label">Vendor ID</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="vid" name="vid" value="<?= __v('vid') ?>" placeholder="VID" maxlength="4" autocomplete="off" data-lpignore="true">
                <small id="vid" class="form-text text-muted">Use a 4-digit hex code, e.g. <code>FEED</code></small>
              </div>
            </div>

            <div class="form-group row">
              <label for="pid" class="col-sm-3 col-form-label">Product ID</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="pid" name="pid" value="<?= __v('pid') ?>" placeholder="PID" maxlength="4" autocomplete="off" data-lpignore="true">
                <small id="pid" class="form-text text-muted">Use a 4-digit hex code, e.g. <code>0123</code></small>
              </div>
            </div>

            <div class="form-group row">
              <label for="vmaj" class="col-sm-3 col-form-label">Version</label>
              <div class="col-sm-3">
                <input type="number" min="0" max="255" class="form-control" id="vmaj" name="vmaj" value="<?= __v('vmaj') ?>" placeholder="Major">
              </div>
              <div class="col-sm-3">
                <input type="number" min="0" max="255" class="form-control" id="vmin" name="vmin" value="<?= __v('vmin') ?>" placeholder="Minor">
              </div>
              <div class="col-sm-3">
                <input type="number" min="0" max="255" class="form-control" id="vrel" name="vrel" value="<?= __v('vrel') ?>" placeholder="Release">
              </div>
            </div>

          </div>
          <div class="col-md-6">

            <div class="form-group">
              <label for="url">URL</label>
              <input type="url" class="form-control" id="url" name="url" value="<?= __v('url') ?>" placeholder="URL">
              <small id="url" class="form-text text-muted">URL to the board as displayed in the <code>info.json</code> file.</small>
            </div>

            <div class="form-group">
              <label for="author">Maintainer Name</label>
              <input type="text" class="form-control" id="author" name="author" value="<?= __v('author') ?>" placeholder="Maintainer Name">
              <small id="author" class="form-text text-muted">The maintainers English name, not GitHub handle.</small>
            </div>

            <div class="form-group">
              <label for="handle">Maintainer Handle</label>
              <input type="text" class="form-control" id="handle" name="handle" value="<?= __v('handle') ?>" placeholder="Maintainer Handle">
              <small id="handle" class="form-text text-muted">The maintainers GitHub handle / username.</small>
            </div>

          </div>
        </div>

        <div class="my-3 p-3 bg-light">
          <button type="submit" class="btn btn-lg btn-primary"><i class="fas fa-paper-plane"></i> Generate File Parts</button>
          <button type="reset" class="btn btn-lg btn-warning"><i class="fas fa-eraser"></i> Clear</button>
        </div>
      </form>
    </div>


<?php
  if ($has_data) {

    ?><div class="container my-3"><form method="post" autocomplete="off" name="dataload"><div class="row row-col-1"><?php

    ?>
      <input type="hidden" id="data" name="data" value="<?= base64_encode(serialize($data)) ?>">
      <input type="hidden" id="meta" name="meta" value="<?= base64_encode(serialize($meta)) ?>">
    <?php

    function generate_output($title, $filename, $pre = '', $suf = '', $inj = '') {
      ?><div class="col-12 border-bottom mb-3 pb-3"><h2><?= $title ?></h2><?php
      if (!empty($pre)) echo $pre;
      $p = strpos($filename, '?');
      if (false === $p) {
        include( $filename );;
      } else {
        $inc_file = substr($filename, 0, $p);
        $GLOBALS[substr($filename, $p+1)] = true;
        include( $inc_file );
      }
      if (!empty($suf)) echo $suf;
      ?><p class="mt-2"><?php
      if (!empty($inj)) echo $inj;
      ?><button formaction="<?= $filename ?>" class="btn btn-secondary"><i class="fas fa-cloud-download-alt"></i> Download</button>
      </p></div><?php
    }

    function generate_output_code($title, $filename, $lang, $text_id) {
      generate_output(
        $title,
        $filename,
        '<pre class="shadow-sm"><code class="language-' . $lang . '" id="' . $text_id . '">',
        '</code></pre>',
        '<button type="button" class="btn btn-success copy-btn" data-clipboard-target="#' . $text_id . '"><i class="far fa-clipboard"></i> Copy</button> '
      );
    }

    generate_output('SVG', 'svg.php', '<div class="img-thumbnail shadow-sm rounded">', '</div>');
    generate_output_code('QMK <code>info.json</code>',       'info.json.php', 'json', 'info_json');
    generate_output_code('Keyboard <code>kb.c</code></h2>',  'kb.c.php',      'c',    'kb_c');
    generate_output_code('Keymap VIA <code>keymap.c</code>', 'keymap.c.php',  'c',    'keymap_c');  // TODO
    generate_output_code('VIA <code>via.json</code>',         'via.json.php',  'json', 'via_json');
    generate_output_code('Vial <code>vial.json</code>',      'via.json.php?vial',  'json', 'vial_json');

    ?></div></form></div><?php
  }
?>

    <?php 
      function copy_year($from) {
        $ret = $from;
        if ($from != date("Y")) $ret .= '-' . date("Y");
        return $ret;
      }
    ?>
    <!-- * ------
        * Footer
        * ------
    -->
    <footer class="bg-light py-2">
    <div class="container bg-light" id="footer">
      <div class="row">
        <div class="text-muted col">
          <b>Keyboard File Generator</b> (<a href="<?= GITHUB_FILE ?>changelog.md" target="_blank">changelog</a>)<br>
          Copyright &copy; <?= copy_year(2022) ?> &mdash; Vino Rodrigues (<a href="<?= GITHUB_FILE ?>contributors.md" target="_blank">and contributors</a>)<br>
          All rights reserved. (<a href="<?= GITHUB_FILE ?>LICENSE.md" target="_blank">LICENSE</a>)
        </div>
        <div clas="col"><div class="text-right text-muted">
          <a href="<?= GITHUB_FILE ?>README.md" target="_blank"><i class="fas fa-question-circle"></i> Help</a><br>
          <a href="<?= GITHUB_URL ?>issues" target="_blank"><i class="fas fa-bug"></i> Found a bug?</a><br>
          <a href="<?= GITHUB_URL ?>" target="_blank"><i class="fab fa-github-alt"></i> Code hosted on GitHub</a><br>
          <i class="fas fa-server"></i> Site hosted on privately funded servers
        </div></div>
      </div>
    </div>
    </footer>

    <div id="sampleData" style="display:none !important;position:absolute;left:-999px;top:0;width:1px;height:1px"
    hidden>[{c:"#777777"},"0,0\n\n\n\n0\n\n\n\n\n\nEsc",{x:0.5,c:"#aaaaaa"},"0,1\n\n\n\n1\n\n\n\n\n\nF1","0,2\n\n\n\n2\n\n\n\n\n\nF2","0,3\n\n\n\n3\n\n\n\n\n\nF3","0,4\n\n\n\n4\n\n\n\n\n\nF4",{x:0.25},"0,5\n\n\n\n5\n\n\n\n\n\nF5","0,6\n\n\n\n6\n\n\n\n\n\nF6","0,7\n\n\n\n7\n\n\n\n\n\nF7","0,8\n\n\n\n8\n\n\n\n\n\nF8",{x:0.25},"0,9\n\n\n\n9\n\n\n\n\n\nF9","0,10\n\n\n\n10\n\n\n\n\n\nF10","0,11\n\n\n\n11\n\n\n\n\n\nF11","0,12\n\n\n\n12\n\n\n\n\n\nF12",{x:0.25},"0,13\n\n\n\n13\n\n\n\n\n\nDel","0,14\n\n\n\n14\n\n\n\n\n\nEnd","0,15\n\n\n\n15\n\n\n\n\n\nPgUp","0,16\n\n\n\n16\n\n\n\n\n\nPgDn",{x:0.25},"0,17\n\n\n\n\n\nVol-\nVol+\n\ne0\nMute"],
[{y:0.25,c:"#cccccc"},"1,0\n\n\n\n17\n\n\n\n\n\n~`","1,1\n\n\n\n18\n\n\n\n\n\n1!","1,2\n\n\n\n19\n\n\n\n\n\n2@","1,3\n\n\n\n20\n\n\n\n\n\n3#","1,4\n\n\n\n21\n\n\n\n\n\n4$","1,5\n\n\n\n22\n\n\n\n\n\n5%","1,6\n\n\n\n23\n\n\n\n\n\n6^","1,7\n\n\n\n24\n\n\n\n\n\n7&","1,8\n\n\n\n25\n\n\n\n\n\n8*","1,9\n\n\n\n26\n\n\n\n\n\n9(","1,10\n\n\n\n27\n\n\n\n\n\n0)","1,11\n\n\n\n28\n\n\n\n\n\n-_","1,12\n\n\n\n29\n\n\n\n\n\n=+",{c:"#aaaaaa",w:2},"1,13\n\n\n\n30\n\n\n\n\n\nBacksp",{c:"#cccccc",a:7,w:0.5,d:true},"N",{c:"#aaaaaa",a:4},"1,14\n\n\n\n31\n\n\n\n\n\nNum-L",{c:"#cccccc"},"1,15\n\n\n\n32\n\n\n\n\n\n/","1,16\n\n\n\n33\n\n\n\n\n\n*","1,17\n\n\n\n34\n\n\n\n\n\n-"],
[{c:"#aaaaaa",w:1.5},"2,0\n\n\n\n35\n\n\n\n\n\nTab",{c:"#cccccc"},"2,1\n\n\n\n36\n\n\n\n\n\nQ","2,2\n\n\n\n37\n\n\n\n\n\nW","2,3\n\n\n\n38\n\n\n\n\n\nE","2,4\n\n\n\n39\n\n\n\n\n\nR","2,5\n\n\n\n40\n\n\n\n\n\nT","2,6\n\n\n\n41\n\n\n\n\n\nY","2,7\n\n\n\n42\n\n\n\n\n\nU","2,8\n\n\n\n43\n\n\n\n\n\nI","2,9\n\n\n\n44\n\n\n\n\n\nO","2,10\n\n\n\n45\n\n\n\n\n\nP","2,11\n\n\n\n46\n\n\n\n\n\n[{","2,12\n\n\n\n47\n\n\n\n\n\n]}",{w:1.5},"2,13\n\n\n\n48\n\n\n\n\n\n\\|",{a:7,w:0.5,d:true},"S",{a:4},"2,14\n\n\n\n49\n\n\n\n\n\n7","2,15\n\n\n\n50\n\n\n\n\n\n8","2,16\n\n\n\n51\n\n\n\n\n\n9",{h:2},"2,17\n\n\n\n52\n\n\n\n\n\n+"],
[{c:"#aaaaaa",w:1.75},"3,0\n\n\n\n53\n\n\n\n\n\nCaps-L",{c:"#cccccc"},"3,1\n\n\n\n54\n\n\n\n\n\nA","3,2\n\n\n\n55\n\n\n\n\n\nS","3,3\n\n\n\n56\n\n\n\n\n\nD",{n:true},"3,4\n\n\n\n57\n\n\n\n\n\nF","3,5\n\n\n\n58\n\n\n\n\n\nG","3,6\n\n\n\n59\n\n\n\n\n\nH",{n:true},"3,7\n\n\n\n60\n\n\n\n\n\nJ","3,8\n\n\n\n61\n\n\n\n\n\nK","3,9\n\n\n\n62\n\n\n\n\n\nL","3,10\n\n\n\n63\n\n\n\n\n\n;:","3,11\n\n\n\n64\n\n\n\n\n\n'\"",{c:"#777777",w:2.25},"3,13\n\n\n\n65\n\n\n\n\n\nEnter",{c:"#cccccc",a:7,w:0.5,d:true},"C",{a:4},"3,14\n\n\n\n66\n\n\n\n\n\n4",{n:true},"3,15\n\n\n\n67\n\n\n\n\n\n5","3,16\n\n\n\n68\n\n\n\n\n\n6"],
[{c:"#aaaaaa",w:2.25},"4,0\n\n\n\n69\n\n\n\n\n\nShift",{c:"#cccccc"},"4,2\n\n\n\n70\n\n\n\n\n\nZ","4,3\n\n\n\n71\n\n\n\n\n\nX","4,4\n\n\n\n72\n\n\n\n\n\nC","4,5\n\n\n\n73\n\n\n\n\n\nV","4,6\n\n\n\n74\n\n\n\n\n\nB","4,7\n\n\n\n75\n\n\n\n\n\nN","4,8\n\n\n\n76\n\n\n\n\n\nM","4,9\n\n\n\n77\n\n\n\n\n\n,<","4,10\n\n\n\n78\n\n\n\n\n\n.>","4,11\n\n\n\n79\n\n\n\n\n\n/?",{c:"#aaaaaa",w:1.75},"4,12\n\n\n\n80\n\n\n\n\n\nShift",{x:1.5,c:"#cccccc"},"4,14\n\n\n\n82\n\n\n\n\n\n1","4,15\n\n\n\n83\n\n\n\n\n\n2","4,16\n\n\n\n84\n\n\n\n\n\n3",{c:"#777777",h:2},"4,17\n\n\n\n85\n\n\n\n\n\nEnter"],
[{y:-0.75,x:14.25},"4,13\n\n\n\n81\n\n\n\n\n\n⇧"],
[{y:-0.25,c:"#aaaaaa",w:1.25},"5,0\n\n\n\n86\n\n\n\n\n\nCtrl",{w:1.25},"5,1\n\n\n\n87\n\n\n\n\n\nWin",{w:1.25},"5,2\n\n\n\n88\n\n\n\n\n\nAlt",{c:"#cccccc",w:6.25},"5,6\n\n\n\n89\n\n\n\n\n\nSpace",{c:"#aaaaaa"},"5,9\n\n\n\n90\n\n\n\n\n\nAlt","5,10\n\n\n\n91\n\n\n\n\n\nFn","5,11\n\n\n\n92\n\n\n\n\n\nCtrl",{x:3.5,c:"#cccccc"},"5,15\n\n\n\n96\n\n\n\n\n\n0","5,16\n\n\n\n97\n\n\n\n\n\n."],
[{y:-0.75,x:13.25,c:"#777777"},"5,12\n\n\n\n93\n\n\n\n\n\n⇦","5,13\n\n\n\n94\n\n\n\n\n\n⇩","5,14\n\n\n\n95\n\n\n\n\n\n⇨"]</div>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
    <script defer>
      // pure JS stuff
      function onLoad() {
        new ClipboardJS('.copy-btn');
   
        document.getElementById('file').addEventListener("change", function() {
          var file_item = document.getElementById('file');
          var file_label = document.getElementById('file_label');
          file_label.innerHTML = file_item.files[0].name;
        } );
      }

      document.addEventListener("DOMContentLoaded", function() {
        onLoad();
      });      
    </script>
    <?php if (!$has_data) : ?>
    <script defer>
      // jQuery stuff
      $(document).ready(function() {
        $("#sampleDataButton").click(function() {
          $("#raw").val( $("#sampleData").html() );
          $("#name").val( "ID98" );
          $("#manuf").val( "Tecsmith" );
          $("#vid").val( "FEED" );
          $("#pid").val( "123" );
          $("#vmaj").val( "1" );
          $("#vmin").val( "0" );
          $("#vrel").val( "0" );
          $("#url").val( "http://github.com/vinorodrigues" );
          $("#author").val( "Vino Rodrigues" );
          $("#handle").val( "vinorodrigues" );
        });
      });
    </script>
    <?php endif; ?>
  </body>
</html>
