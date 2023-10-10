<main>
  <h1>Produits</h1>
  <?= $this->session->flashdata('message'); ?>
  <div class="product-list">
    <table>
      <thead>
        <tr>
          <th>N° Lot</th>
          <th>Bateau</th>
          <th>Espèce</th>
          <th>Enchère</th>
          <th>Statut</th>
          <th>Prix/KG de départ</th>
          <th>Poids</th>
          <th>Taille</th>
          <th>Présentation</th>
          <th>Qualité</th>
          <th>Gagnant</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($produits as $produit) {
          $idCompteARebours = uniqid();
          $dateActuelle = new DateTime();
          if (!is_null($produit['dateDebutEnchere']) && !is_null($produit['dateFinEnchere'])) {
            $dateDebutEnchere = new DateTime($produit['dateDebutEnchere']);
            $dateFinEnchere = new DateTime($produit['dateFinEnchere']);
            if ($dateDebutEnchere > $dateActuelle) {
              // L'enchère n'a pas encore commencé
              $diff = $dateDebutEnchere->diff($dateActuelle);
              $countdownMessage = "L'enchère débute dans ";
              $countdownTime = $diff->format('%aj %hh %im %ss');
            } else if ($dateFinEnchere > $dateActuelle) {
              // L'enchère est en cours
              $diff = $dateFinEnchere->diff($dateActuelle);
              $countdownMessage = 'L\'enchère se termine dans ';
              $countdownTime = $diff->format('%aj %hh %im %ss');
            } else {
              // L'enchère est terminée
              $countdownMessage = "Enchère terminée";
              $countdownTime = '';
            }
          }
          ?>
          <form action="<?= base_url('encherir'); ?>" method="POST">
            <input type="hidden" name="id" value="<?= $produit['id']; ?>">
            <input type="hidden" name="idBateau" value="<?= $produit['idBateau']; ?>">
            <input type="hidden" name="idDatePeche" value="<?= $produit['idDatePeche']; ?>">
            <tr>
              <td>
                <?= $produit['id'] . '-' . date('d-m-Y', strtotime($produit['idDatePeche'])) . '-' . $produit['idBateau']; ?>
              </td>
              <td>
                <?= $produit['nomBateau']; ?>
              </td>
              <td>
                <?= $produit['nomEspece']; ?>
              </td>
              <td>
                <?= $produit['prixEnchere'] == '00.00' || $produit['prixEnchere'] == '' ? 'Soyez le premier à enchérir' : $produit['prixEnchere'] . '€'; ?>
                <input class="submit" name="encherirForm" type="submit" value="Enchérir">
              </td>
              <td id="<?= $idCompteARebours; ?>"><?= $countdownMessage . $countdownTime; ?></td>
              <td>
                <?= $produit['prixDepart']; ?>€
              </td>
              <td>
                <?= $produit['poidsBrutLot']; ?>kg
              </td>
              <td>
                <?= $produit['taille']; ?>
              </td>
              <td>
                <?= $produit['presentation']; ?>
              </td>
              <td>
                <?= $produit['qualite']; ?>
              </td>
              <td>
                <?= $produit['acheteur'] == '' ? 'N/A' : $produit['acheteur']; ?>
              </td>
            </tr>
          </form>
          <?php
          if ($dateDebutEnchere > $dateActuelle) { // Si l'enchère n'a pas commencé
            ?>
            <script>
              (function () {
                const dateMySQL = "<?= $produit['dateDebutEnchere']; ?>";

                // Convertir la date en format JavaScript
                const date = new Date(dateMySQL);

                // Récupérer l'élément HTML pour afficher le compte à rebours
                const countdown = document.getElementById("<?= $idCompteARebours; ?>");

                // Mettre à jour le compte à rebours toutes les secondes
                const timer = setInterval(function () {
                  // Récupérer la date et l'heure actuelle
                  const now = new Date().getTime();

                  // Calculer la différence entre la date d'entrée et la date actuelle
                  const diff = date - now;

                  // Calculer les jours, heures, minutes et secondes restantes
                  const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                  const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                  const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                  const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                  // Afficher le compte à rebours dans l'élément HTML
                  countdown.innerHTML = "L'enchère débute dans " + days + "j " + hours + "h " + minutes + "m " + seconds + "s";

                  // Si la date d'entrée est dépassée, arrêter le compte à rebours
                  if (diff < 0) {
                    clearInterval(timer);
                    countdown.innerHTML = "L'enchère a commencé";
                  }
                }, 1000);
              })();
            </script>
          <?php } else if ($dateFinEnchere > $dateActuelle) { // Si l'enchère est en cours
            ?>
              <script>
                (function () {
                  const dateMySQL = "<?= $produit['dateFinEnchere']; ?>";

                  // Convertir la date en format JavaScript
                  const date = new Date(dateMySQL);

                  // Récupérer l'élément HTML pour afficher le compte à rebours
                  const countdown = document.getElementById("<?= $idCompteARebours; ?>");

                  // Mettre à jour le compte à rebours toutes les secondes
                  const timer = setInterval(function () {
                    // Récupérer la date et l'heure actuelle
                    const now = new Date().getTime();

                    // Calculer la différence entre la date d'entrée et la date actuelle
                    const diff = date - now;

                    // Calculer les jours, heures, minutes et secondes restantes
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    // Afficher le compte à rebours dans l'élément HTML
                    countdown.innerHTML = "L'enchère se termine dans " + days + "j " + hours + "h " + minutes + "m " + seconds + "s";

                    // Si la date d'entrée est dépassée, arrêter le compte à rebours
                    if (diff < 0) {
                      clearInterval(timer);
                      countdown.innerHTML = "Enchère terminée";
                    }
                  }, 1000);
                })();
              </script>
            <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</main>