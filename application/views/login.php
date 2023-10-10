<main>
  <h1>Connexion</h1>
  <?= is_null($this->session->flashdata('message')) ? '
  <div class="info-msg">
				<i class="fa-solid fa-circle-info"></i> Vous n\'avez pas de compte ?
        <br>
        Inscrivez-vous <a class="msg-link-info" href="' . base_url('register') . '">ici</a>.
	</div>' : $this->session->flashdata('message'); ?>
  <div class="form-container">
    <form action="" method="post">
      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>

      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>

      <input class="submit" name="login" type="submit" value="Se connecter">
    </form>
  </div>
</main>