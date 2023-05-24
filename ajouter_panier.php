<?php

// Start the session
session_start();

if (isset($_POST['product'])) {
    $product = $_POST['product'];

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = array();
    }

    // Check if the product already exists in the cart
    $productExists = false;
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['nom_prod'] === $product['nom_prod']) {
            // If the product exists, increase its quantity and update the total price
            $item['quantite'] += 1;
            $item['prix_total'] = $item['prix_prod'] * $item['quantite'];
            $productExists = true;
            break;
        }
    }

    // If the product doesn't exist in the cart, add it with a quantity of 1
    if (!$productExists) {
        $product['quantite'] = 0;
        $product['prix_total'] = 0;
        $_SESSION['panier'][] = $product;
    }

    echo "Ajouté au panier!";
} else {
    echo "Erreur d'ajout!";
}

?>
