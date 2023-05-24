<?php

session_start();

if (isset($_SESSION['panier'])) {
    $cartData = $_SESSION['panier'];

    if (!empty($cartData)) {
        // colonne gauche
        echo "<div class='col-6'>";
        echo "<h2>Contenu du panier :</h2>";
        echo "<div class='col-12'>";
        $totalAmount = 0; // Variable pour stocker le montant total

        foreach ($cartData as $key => $product) {
            echo "<div class='row'>";
            echo "<div class='col-5'>";
            echo "<p>".$product['nom_prod']." - Prix : ".$product['prix_prod']."</p>";
            echo "</div>";
            echo "<div class='col-2'>";
            echo "<button class='btn-modifier-quantite' data-key='$key' data-action='add'>+</button>";
            echo "</div>";
            echo "<div class='col-2 quantite-produit' data-key='$key'>";
            echo $product['quantite'];
            echo "</div>";
            echo "<div class='col-2'>";
            echo "<button class='btn-modifier-quantite' data-key='$key' data-action='remove'>-</button>";
            echo "</div>";
            echo "<div class='col-1'>";
            echo "<hr class='vertical-line'>";
            echo "</div>";
            echo "<div class='col-2'>";
            
            echo "</div>";
            echo "</div>";

            // Ajouter le prix total du produit au montant total
            $totalAmount += $product['prix_total'];
        }

        echo "</div>";
        echo "</div>";
        // colonne droite
        echo "<div id='colonne-droite' class='col-6 pt-5'>";
        foreach ($cartData as $key => $product){
            echo "<div class='prix-produit' data-key='$key'>";
            echo $product['prix_total'];
            echo "</div>";
        }
        echo "</div>";
        echo "<hr>";
        echo "<p class='montant-total'>Montant total: ".$totalAmount."</p>"; // Afficher le montant total
        echo "<hr>";
    }
     else {
        echo "Le panier est vide.";
    }
} else {
    echo "Le panier est vide.";
}

