</body>

<!-- jquery cdn -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
  $(document).ready(function() {

    // afficher le compteur du panier
    function updateCartCount() {
      $.ajax({
        type: "GET",
        url: "recuperer_panier.php",
        success: function(response) {
          var cartData = JSON.parse(response);
          var totalQuantity = 0;
          for (var i = 0; i < cartData.length; i++) {
            totalQuantity += cartData[i].quantite;
          }
          $('#nombre-produits-panier').text(totalQuantity);
        }
      });
    }

    // mettre à jour le compteur
    updateCartCount();

    // écoute du clic sur ajout au panier
    $('.ajouter-panier').click(function() {
      updateCartCount();
    });

    // écoute du clic sur panier
    $('#afficher-panier').click(function() {
      document.getElementById("popup").style.display = "block";
      $.ajax({
        type: "GET",
        url: "afficher_panier.php",
        success: function(response) {
          $('#contenu-panier').html(response);
        }
      });
    })

    // écoute du clic sur fermer
    $('#fermer-popup').click(function() {
      document.getElementById("popup").style.display = "none";
    })

    // écoute du clic sur vider
    $('#vider-panier').click(function() {
      $.ajax({
        type: "POST",
        url: "vider_panier.php",
        success: function(response) {
          updateCartCount();
          $('#contenu-panier').empty();
        }
      });
    })

    // écoute du clic sur valider
    $('#valider-panier').click(function() {

    })

  });
</script>

</html>