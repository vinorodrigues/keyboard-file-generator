<?php

// @include 'engine.php';

/**
 * @see: https://fontawesome.com/v5/search?o=r&m=free
 */

ob_start();
?>
[{c:"#777777",a:0},"0,0\n\n\n\n\n\n\n\n\n\nEsc\n0",{x:0.5,c:"#aaaaaa"},"0,1\n\n\n\n1","0,2\n\n\n\n2","0,3\n\n\n\n3","0,4\n\n\n\n4",{x:0.25},"0,5\n\n\n\n5","0,6\n\n\n\n6","0,7\n\n\n\n7","0,8\n\n\n\n8",{x:0.25},"0,9\n\n\n\n9","0,10\n\n\n\n10","0,11\n\n\n\n11","0,12\n\n\n\n12",{x:0.25},"0,13\n\n\n\n13","0,14\n\n\n\n14","0,15\n\n\n\n15","0,16\n\n\n\n16",{x:0.25},"0,17\n\n\n\n\n\n\n\n\ne0"],
[{y:0.25,c:"#cccccc"},"1,0\n\n\n\n17","1,1\n\n\n\n18","1,2\n\n\n\n19","1,3\n\n\n\n20","1,4\n\n\n\n21","1,5\n\n\n\n22","1,6\n\n\n\n23","1,7\n\n\n\n24","1,8\n\n\n\n25","1,9\n\n\n\n26","1,10\n\n\n\n27","1,11\n\n\n\n28","1,12\n\n\n\n29",{c:"#aaaaaa",w:2},"1,13\n\n\n\n30",{x:0.5},"1,14\n\n\n\n31",{c:"#cccccc"},"1,15\n\n\n\n32","1,16\n\n\n\n33","1,17\n\n\n\n34"],
[{c:"#aaaaaa",w:1.5},"2,0\n\n\n\n35",{c:"#cccccc"},"2,1\n\n\n\n36","2,2\n\n\n\n37","2,3\n\n\n\n38","2,4\n\n\n\n39","2,5\n\n\n\n40","2,6\n\n\n\n41","2,7\n\n\n\n42","2,8\n\n\n\n43","2,9\n\n\n\n44","2,10\n\n\n\n45","2,11\n\n\n\n46","2,12\n\n\n\n47",{w:1.5},"2,13\n\n\n\n48",{x:0.5},"2,14\n\n\n\n49","2,15\n\n\n\n50","2,16\n\n\n\n51",{h:2},"2,17\n\n\n\n52"],
[{c:"#aaaaaa",w:1.75},"3,0\n\n\n\n53",{c:"#cccccc"},"3,1\n\n\n\n54","3,2\n\n\n\n55","3,3\n\n\n\n56","3,4\n\n\n\n57","3,5\n\n\n\n58","3,6\n\n\n\n59","3,7\n\n\n\n60","3,8\n\n\n\n61","3,9\n\n\n\n62","3,10\n\n\n\n63","3,11\n\n\n\n64",{c:"#777777",w:2.25},"3,13\n\n\n\n65\n\n\n\n\n\nEnter",{x:0.5,c:"#cccccc"},"3,14\n\n\n\n66","3,15\n\n\n\n67","3,16\n\n\n\n68"],
[{c:"#aaaaaa",w:2.25},"4,0\n\n\n\n69",{c:"#cccccc"},"4,2\n\n\n\n70","4,3\n\n\n\n71","4,4\n\n\n\n72","4,5\n\n\n\n73","4,6\n\n\n\n74","4,7\n\n\n\n75","4,8\n\n\n\n76","4,9\n\n\n\n77","4,10\n\n\n\n78","4,11\n\n\n\n79",{c:"#aaaaaa",w:1.75},"4,12\n\n\n\n80",{x:1.5,c:"#cccccc"},"4,14\n\n\n\n82","4,15\n\n\n\n83","4,16\n\n\n\n84",{c:"#777777",h:2},"4,17\n\n\n\n85"],
[{y:-0.75,x:14.25},"4,13\n\n\n\n81\n\n\n\n\n\n⇧"],
[{y:-0.25,c:"#aaaaaa",w:1.25},"5,0\n\n\n\n86",{w:1.25},"5,1\n\n\n\n87",{w:1.25},"5,2\n\n\n\n88",{c:"#cccccc",w:6.25},"5,6\n\n\n\n89",{c:"#aaaaaa"},"5,9\n\n\n\n90","5,10\n\n\n\n91","5,11\n\n\n\n92",{x:3.5,c:"#cccccc"},"5,15\n\n\n\n96","5,16\n\n\n\n97"],
[{y:-0.75,x:13.25,c:"#777777"},"5,12\n\n\n\n93\n\n\n\n\n\n⇦","5,13\n\n\n\n94\n\n\n\n\n\n⇩","5,14\n\n\n\n95\n\n\n\n\n\n⇨"]
<?php
$default = ob_get_contents();
ob_end_clean();
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

    <title>Keyboard File Generator</title>

    <style>
      .svg-wrapper {
        padding: 1rem;
      }
      .the-svg {
        max-width: 100% !important;
        height: auto !important;
      }
    </style>

  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#"><i class="far fa-keyboard"></i> Keyboard File Generator</a>
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

    <div class="container-fluid">

      <form method="get">
        <div class="form-group">
          <label for="raw">Keyboard Layout Editor Raw data:</label>
          <textarea class="form-control text-monospace" id="raw" name="raw" rows="10"><?php
          if (isset($_REQUEST["raw"])) {
            echo $_REQUEST["raw"];
          } else {
            echo $default;
          }
          ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Generate File Parts</button>
      </form>

      <hr>

      <?php
        /* ╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋ */
        include 'engine.php';
        /* ╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋╋ */

        // $serial = serialize($data);
        // $getter = urlencode($serial);

        if (isset($_REQUEST['raw'])) {
          include 'svg.php';

          // echo '<hr>';

          // echo '<pre>'; var_dump($data); echo '</pre>';
        }

        // echo "<p>";

        // var_dump($data);

      ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
