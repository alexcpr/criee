<main>
  <h1>Mon compte</h1>
  <?= $this->session->flashdata('message'); ?>
  <div class="options">
    <ul>
      <li><a href="<?= base_url('account/general'); ?>">Modifier mon mot de passe</a></li>
      <li><a href="<?= base_url('account/history'); ?>">Historique de vos enchères</a></li>
    </ul>
  </div>
</main>