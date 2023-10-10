<main>
  <h1>Inscription</h1>
  <?= is_null($this->session->flashdata('message')) ? '
  <div class="info-msg">
				<i class="fa-solid fa-circle-info"></i> Vous avez déjà un compte ?
        <br>
        Connectez-vous <a class="msg-link-info" href="' . base_url('login') . '">ici</a>.
	</div>' : $this->session->flashdata('message'); ?>
  <div class="form-container">
    <form action="" method="post">
      <label for="nom">Nom</label>
      <input type="text" id="nom" name="nom" required>

      <label for="prenom">Prénom</label>
      <input type="text" id="prenom" name="prenom" required>

      <label for="email">Adresse e-mail</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>

      <label for="password_confirmation">Confirmer mot de passe</label>
      <input type="password" id="password_confirmation" name="password_confirmation" required>

      <label for="numRue">N° de rue</label>
      <input type="int" id="numRue" name="numRue" required>

      <label for="voie">Rue</label>
      <input type="text" id="voie" name="voie" required>

      <label for="cp">Code postal</label>
      <input type="text" id="cp" name="cp" required>

      <label for="ville">Ville</label>
      <input type="text" id="ville" name="ville" required>

      <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>

      <input class="submit" name="register" type="submit" value="S'inscrire">
    </form>
  </div>
</main>