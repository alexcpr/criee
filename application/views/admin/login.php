<main>
  <h1>Connexion</h1>
  <?= $this->session->flashdata('message'); ?>
  <div class="form-container">
    <form action="" method="post">

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>

      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>

      <input class="submit" name="login" type="submit" value="Connexion">
    </form>
  </div>
</main>