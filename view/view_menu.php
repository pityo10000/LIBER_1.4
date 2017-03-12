<nav class="navbar navbar-default">
  <div class="container-fluid">

    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
    </div>

    <div id="navbar" class="navbar-collapse collapse">
      <form method="GET" action="index.php" class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" name="keywords" class="form-control" placeholder="Keresés">
          <input type="hidden" name="nav" value="search">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"><span></button>
      </form>
      <ul class="nav navbar-nav navbar-right">

      <?php
          if (isset($_SESSION['login'])) {
            if ($_SESSION['login']->getPermission()->getVenues() == 1) {
              echo '<li><a href="index.php?nav=venues" class="btn btn-default menubtn">Helyszíneim</a></li>';
            }
            if ($_SESSION['login']->getPermission()->getServices() == 1) {
              echo '<li><a href="index.php?nav=services" class="btn btn-default menubtn">Szolgáltatásaim</a></li>';
            }
            if ($_SESSION['login']->getPermission()->getEquipments() == 1) {
              echo '<li><a href="index.php?nav=equipments" class="btn btn-default menubtn">Felszereléseim</a></li>';
            }
            if ($_SESSION['login']->getPermission()->getMessages() == 1) {
              echo '<li><a href="index.php?nav=messages" class="btn btn-default menubtn">Üzenetek</a></li>';
            }
            if ($_SESSION['login']->getPermission()->getSettings() == 1) {
              echo '<li><a href="index.php?nav=settings" class="btn btn-default menubtn">Beállítások</a></li>';
            }
          }

          //TODO if megtörés elhagyása, böngészés megjelenítése normálisan
          echo '<li><a href="index.php?nav=browse" class="btn btn-default menubtn">Böngészés</a></li>';

          if (isset($_SESSION['login'])) {
            if ($_SESSION['login']->getPermission()->getFavorites() == 1) {
              echo '<li><a href="index.php?nav=favorites" class="btn btn-default menubtn">Kedvencek</a></li>';
            }
            if ($_SESSION['login']->getPermission()->getEvents() == 1) {
              echo '<li><a href="index.php?nav=events" class="btn btn-default menubtn">Rendezvényeim</a></li>';
            }
            echo '<li><a href="index.php?action=logout" class="btn btn-default menubtn">Kijelentkezés</a></li>';
          } else {
            echo '
            <li><a href="index.php?nav=registration" class="btn btn-default menubtn">Regisztráció</a></li>
            <li class="dropdown">
              <button type="button" class="dropdown-toggle btn btn-default menubtn col-xs-12" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Bejelentkezés<span class="caret"></span></button>
              <ul id="loginDropdown" class="dropdown-menu">
                <form name="loginData" method="POST" class="navbar-form">
                  <li><label>Email cím:</label></li>
                  <li><input name="loginEmail" id="email" class="form-control" type="text" required></input></li>
                  <li><label>Jelszó:</label></li>
                  <li><input name="loginPassword" id="password" class="form-control" type="password" required></input></li>
                  <li><input type="submit" class="btn btn-default" value="Bejelentkezés"></input></li>
                  <input name="action" value="loginSubmit" type="hidden"></input>
                </form>
              </ul>
            </li>
            ';
          }
      ?>
      </ul>
    </div>
  </div>
</nav>
