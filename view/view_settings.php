<?php
    echo "</br>";

    if (isset($_SESSION['alertType']) && isset($_SESSION['alertText'])) {
      echo '<div class="alert alert-' . $_SESSION['alertType'] . '">
        ' . $_SESSION['alertText'] . '
      </div>';
      $_SESSION['alertType'] = null;
      $_SESSION['alertText'] = null;
    }


     ?>
    <h1 class ="text" style="font-size: 30px;">Beállítások</h1>
    </br>

    <p class="text" style="font-size: 20px;">Adatmódosítás</label>


    <?php echo $form ?>



  </div>
