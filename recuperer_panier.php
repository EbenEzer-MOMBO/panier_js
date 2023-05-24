<?php

session_start();

if (isset($_SESSION['panier'])) {
  $cartData = $_SESSION['panier'];

  echo json_encode($cartData);
} else {
  echo json_encode([]);
}
