<?php

session_start();

if (isset($_POST['key']) && isset($_POST['action'])) {
    $key = $_POST['key'];
    $action = $_POST['action'];

    if (isset($_SESSION['panier'][$key])) {
        $product = $_SESSION['panier'][$key];

        if ($action === 'add') {
            // Increase the quantity by 1
            $product['quantite'] += 1;
        } elseif ($action === 'remove') {
            // Decrease the quantity by 1, ensuring it doesn't go below 0
            $product['quantite'] -= 1;
            if ($product['quantite'] < 0) {
                $product['quantite'] = 0;
            }
        }

        // Update the total price based on the modified quantity
        $product['prix_total'] = $product['prix_prod'] * $product['quantite'];

        // Update the product in the cart
        $_SESSION['panier'][$key] = $product;

        $response = [
            'quantite' => $product['quantite'],
            'prix_total' => $product['prix_total']
        ];
        echo json_encode($response);

    } else {
        echo "Produit introuvable dans le panier.";
    }
} else {
    echo "Paramètres manquants.";
}

?>
