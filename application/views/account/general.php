<main>
  <h1>Changer de mot de passe</h1>
  <?= $this->session->flashdata('message'); ?>
  <div class="form-container">
    <form action="" method="post">

      <label for="nom">Nom</label>
      <input type="text" id="nom" value="<?= $_SESSION['user_nom']; ?>" disabled required>

      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" value="<?= $_SESSION['user_prenom']; ?>" disabled required>

      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" value="<?= $_SESSION['user_email']; ?>" disabled required>

      <label for="currentPassword">Mot de passe actuel</label>
      <input type="password" id="currentPassword" name="currentPassword" required>

      <label for="newPassword">Nouveau mot de passe</label>
      <input type="password" id="newPassword" name="newPassword" required>

      <label for="confirmNewPassword">Confirmer nouveau mot de passe</label>
      <input type="password" id="confirmNewPassword" name="confirmNewPassword" required>

      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>

      <input class="submit" name="changePassword" type="submit" value="Mettre à jour">
    </form>
  </div>
</main>