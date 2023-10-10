<main>
  <?php if (is_null($lignesPanier)) { ?>
    <h1>Vous n'avez pas encore remporté d'enchère.</h1>
    <?= $this->session->flashdata('message'); ?>
  <?php } else { ?>
    <h1>Vous avez remporté les enchères suivantes</h1>
    <?= $this->session->flashdata('message'); ?>
    <div class="product-list panier">
      <table>
        <thead>
          <tr>
            <th>N° Lot</th>
            <th>Bateau</th>
            <th>Espèce</th>
            <th>Poids</th>
            <th>Taille</th>
            <th>Présentation</th>
            <th>Qualité</th>
            <th>Prix</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($lignesPanier as $lignePanier) {
            ?>
            <form action="<?= base_url('cart'); ?>" method="POST">
              <tr>
                <td>
                  <?= $lignePanier['id'] . '-' . date('d-m-Y', strtotime($lignePanier['idDatePeche'])) . '-' . $lignePanier['idBateau']; ?>
                </td>
                <td>
                  <?= $lignePanier['nomBateau']; ?>
                </td>
                <td>
                  <?= $lignePanier['nomEspece']; ?>
                </td>
                <td>
                  <?= $lignePanier['poidsBrutLot']; ?>kg
                </td>
                <td>
                  <?= $lignePanier['taille']; ?>
                </td>
                <td>
                  <?= $lignePanier['presentation']; ?>
                </td>
                <td>
                  <?= $lignePanier['qualite']; ?>
                </td>
                <td>
                  <?= $lignePanier['prixEnchere']; ?>
                </td>
                <td><input class="submit" name="desister" type="submit" value="Je me désiste"></td>
              </tr>
            </form>
          <?php } ?>
        </tbody>
      </table>
      <input class="submit" name="buy" type="submit" value="Passer à la caisse">
    </div>
  <?php } ?>
</main>