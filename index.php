<?php

// base de données
include("db.php");

// récuperer les produits
$stmt = $pdo->prepare("SELECT * FROM produits");
$stmt->execute();
$prodList = $stmt->fetchAll();

// header
include("header.php");

?>

<!--contenu principal-->
<div class="container">
    <div class="row justify-content-center">
        <?php
        // afficher les produits
        if ($prodList) {
            foreach ($prodList as $ligne) {
                echo '<div class="col-2 ajouter-panier">
                        <h3>' . $ligne['nom_prod'] . '</h3>
                        <h3><b>' . $ligne['prix_prod'] . '</b></h3>
                    </div>';
            }
        } else {
            echo "Aucun produit disponible";
        }
        ?>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $.ajax({
                    type: "POST",
                    url: "vider_panier.php",
                    success: function(response) {}
                });
                $('.ajouter-panier').each(function() {
                    var nom = $(this).find('h3:first').text();
                    var prix = $(this).find('h3:last').text();
                    var product = {
                        nom_prod: nom,
                        prix_prod: prix,
                        quantite: 0
                    };
                    // Envoyer l'objet product à votre script de gestion du panier via AJAX
                    $.ajax({
                        type: "POST",
                        url: "ajouter_panier.php",
                        data: {
                            product: product
                        },
                        success: function(response) {
                            // Réponse du serveur après l'ajout au panier
                            console.log(response);
                        }
                    });
                });
            })
        </script>
    </div>
</div>
<!--contenu principal-->

<!--modal-->
<style>
    .popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .popup-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        width: 80%;
        max-width: 400px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .card {
        max-width: 1000px;
        margin: auto;
        border-radius: 20 px;
    }

    p {
        margin: 0px;
    }

    .container .h8 {
        font-size: 30px;
        font-weight: 800;
        text-align: center;
    }

    .btn.btn-primary {
        width: 100%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
        background-image: linear-gradient(to right, #77A1D3 0%, #79CBCA 51%, #77A1D3 100%);
        border: none;
        transition: 0.5s;
        background-size: 200% auto;

    }


    .btn.btn.btn-primary:hover {
        background-position: right center;
        color: #fff;
        text-decoration: none;
    }



    .btn.btn-primary:hover .fas.fa-arrow-right {
        transform: translate(15px);
        transition: transform 0.2s ease-in;
    }

    .form-control {
        color: white;
        background-color: #223C60;
        border: 2px solid transparent;
        height: 60px;
        padding-left: 20px;
        vertical-align: middle;
    }

    .form-control:focus {
        color: white;
        background-color: #0C4160;
        border: 2px solid #2d4dda;
        box-shadow: none;
    }

    .text {
        font-size: 14px;
        font-weight: 600;
    }

    ::placeholder {
        font-size: 14px;
        font-weight: 600;
    }
</style>
<div id="popup" class="popup">
    <div class="container py-5">
        <div class="card px-4">
            <div class="row" id="contenu-panier"></div>
            <div class="row justify-content-end py-3">
                <div class="col-4">
                    <button id="suivant" class="btn btn-success">valider</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {


        // écoute des clic sur + et -
        $(document).on('click', '.btn-modifier-quantite', function() {

            var key = $(this).data('key');
            var action = $(this).data('action');

            $.ajax({
                type: "POST",
                url: "modifier_quantite.php",
                data: {
                    key: key,
                    action: action
                },
                success: function(response) {
                    console.log(response); // Réponse du serveur après la modification de quantité

                    // Convertir la chaîne de caractères en objet JavaScript
                    var updatedData = JSON.parse(response);

                    // Mettre à jour l'affichage de la quantité
                    var updatedQuantity = parseInt(updatedData.quantite);
                    $('.quantite-produit[data-key="' + key + '"]').text(updatedQuantity);

                    // Mettre à jour l'affichage du prix total
                    var updatedPrice = parseInt(updatedData.prix_total);
                    $('.prix-produit[data-key="' + key + '"]').text(updatedPrice);

                    // Mettre à jour l'affichage du montant total
                    var totalAmount = 0;
                    $('.prix-produit').each(function() {
                        var price = parseInt($(this).text());
                        totalAmount += price;
                    });
                    $('.montant-total').text("Montant total: " + totalAmount);
                }

            });
        });

        // bouton valider
        $(document).on('click', '#suivant', function() {

            // Vérifier le montant total
            var totalAmount = parseInt($('.montant-total').text().split(":")[1].trim());
            if (totalAmount > 0) {
                $('#colonne-droite').empty();
                document.getElementById("suivant").style.display = "none";


                $('#colonne-droite').empty();

                document.getElementById("suivant").style.display = "none";
                var desactive = document.getElementsByClassName("btn-modifier-quantite");
                $(desactive).prop("disabled", true);

                // Affiche le formulaire
                $('#colonne-droite').html(`
                <div class="container">
                    <h2>Formulaire</h2>
                    <form id="formulaire" action="enregistrer.php" method="post">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom" required>
                        </div>
                        <div class="form-group">
                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </form>
                </div>
            `);
            }
        })
    });
</script>
<!--modal-->

<?php

// footer
include("footer.php");

?>