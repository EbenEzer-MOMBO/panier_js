<?php
session_start();

include("db.php");

// Vérifier si les données du formulaire ont été soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];

    // Récupérer les données du panier
    if (isset($_SESSION['panier'])) {
        $cartData = $_SESSION['panier'];

        try {
            // Insérer les données du formulaire dans la table "commande"
            $sql = "INSERT INTO commande (nom, prenom, adresse) VALUES (:nom, :prenom, :adresse)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':adresse', $adresse);
            $stmt->execute();

            $commandeId = $pdo->lastInsertId(); // Récupérer l'ID de la commande nouvellement insérée

            // Insérer les éléments du panier dans la table "commande_details"
            $sql = "INSERT INTO commandes (id_prod, quantite, prix_prod) VALUES (:id_prod, :quantite, :prix_prod)";
            $stmt = $pdo->prepare($sql);

            foreach ($cartData as $key => $product) {
                $nomProduit = $product['nom_prod'];
                $quantite = $product['quantite'];
                $prixTotal = $product['prix_total'];

                // Vérifier si la quantité est supérieure à zéro
                if ($quantite > 0) {
                    $stmt->bindParam(':id_prod', $nomProduit);
                    $stmt->bindParam(':quantite', $quantite);
                    $stmt->bindParam(':prix_prod', $prixTotal);
                    $stmt->execute();
                }
            }

            // Vider le panier après avoir enregistré la commande
            unset($_SESSION['panier']);

            header("Location: index.php");
            exit(0);

            echo "La commande a été enregistrée avec succès !";
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement de la commande : " . $e->getMessage();
        }
    } else {
        echo "Le panier est vide.";
    }
} else {
    echo "Erreur : le formulaire n'a pas été soumis.";
}
