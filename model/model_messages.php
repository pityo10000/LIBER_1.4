<?php
if (isset($_SESSION['login']) && $_SESSION['login']->getPermission()->getMessages() == 1) {

  $title = "Üzenetek";
  $style = '
  #messagePanel {
    overflow-y: scroll;
    overflow-x: hidden;
    height:auto;
    max-height: 400px;
  }

  #partners {
    overflow-y: scroll;
    overflow-x: hidden;
    height:auto;
    max-height: 400px;
  }

  .messageMe {
  	background-color: #8ecfe2;
  	margin: 1px;
  	padding: 10px;
  	border-radius: 10px;
  }

  .messagePartner {
  	background-color: #EBEBEB;
  	margin: 1px;
  	padding: 10px;
  	border-radius: 10px;
  }

  .messagePartners {
  	background-color: #8ecfe2;
  	margin: 1px;
  	border-radius: 10px;
  }

  .messagePartners:hover {
  	background-color: #185868;
  	color: white;
  }

  #messageContent {
  	border-radius: 10px;
    resize: none;
  }
  ';

} else {
  $notFound = true;
}
?>
