<?php
if (!isset($_SESSION['login'])) {
  $title = "Regisztráció";

  $script = "
  ";

  $style = '
    .customer {
      position: static;
      visibility:  visible;
    }

    .company {
      position: fixed;
      visibility:  hidden;
    }

    .error {
      color: red;
    }
  ';
} else {
  $notFound = true;
}
?>
