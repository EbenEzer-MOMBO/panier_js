<?php

session_start();

if (isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();

    echo "Le panier a été vidé avec succès.";
} else {
    echo "Le panier est déjà vide.";
}

?>
