<main>
  <h1>Ajouter un lot</h1>
  <?= $this->session->flashdata('message'); ?>
  <div class="form-container">
    <form action="" method="post">
      <label for="idDatePeche">Date de la pêche</label>
      <select name="idDatePeche" id="idDatePeche">
        <option disabled selected>Veuillez choisir une date</option>
        <?php foreach ($optionsIdDatePeche as $option): ?>
          <option value="<?php echo $option['datePeche']; ?>"><?= date('d/m/Y', strtotime($option['datePeche'])); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <label for="idBateau">Bateau</label>
      <select name="idBateau" id="idBateau">
        <option disabled selected>Veuillez choisir un bateau</option>
        <?php foreach ($optionsIdBateau as $option): ?>
          <option value="<?php echo $option['id']; ?>"><?php echo $option['Nom']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="id">ID</label>
      <input type="text" id="id" name="id">

      <label for="espece">Espèce</label>
      <select name="espece" id="espece">
        <option disabled selected>Veuillez choisir une espèce</option>
        <?php foreach ($optionsEspece as $option): ?>
          <option value="<?php echo $option['id']; ?>"><?php echo $option['nom']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="taille">Taille</label>
      <select name="taille" id="taille">
        <option disabled selected>Veuillez choisir une taille</option>
        <?php foreach ($optionsTaille as $option): ?>
          <option value="<?php echo $option['id']; ?>"><?php echo $option['specification']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="presentation">Présentation</label>
      <select name="presentation" id="presentation">
        <option disabled selected>Veuillez choisir une présentation</option>
        <?php foreach ($optionsPresentation as $option): ?>
          <option value="<?php echo $option['id']; ?>"><?php echo $option['libelle']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="qualite">Qualité</label>
      <select name="qualite" id="qualite">
        <option disabled selected>Veuillez choisir une qualité</option>
        <?php foreach ($optionsQualite as $option): ?>
          <option value="<?php echo $option['id']; ?>"><?php echo $option['libelle']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="bac">Bac</label>
      <select name="bac" id="bac">
        <option disabled selected>Veuillez choisir un type de bac</option>
        <?php foreach ($optionsBac as $option): ?>
          <option value="<?php echo $option['id']; ?>">Type <?php echo $option['id']; ?> (Tare <?php echo $option['tare']; ?>)</option>
        <?php endforeach; ?>
      </select>

      <label for="poids">Poids brut (KG)</label>
      <input type="text" id="poids" name="poids">

      <label for="dateDebut">Enchère: date de début</label>
      <input type="datetime-local" id="dateDebut" name="dateDebut" min="<?php echo date('Y-m-d\TH:i'); ?>">

      <label for="dateFin">Enchère: date de fin</label>
      <input type="datetime-local" id="dateFin" name="dateFin" min="<?php echo date('Y-m-d\TH:i'); ?>">

      <label for="prixPlancher">Prix plancher (€)</label>
      <input type="number" step=".01" id="prixPlancher" name="prixPlancher">

      <label for="prixDepart">Prix de départ (€)</label>
      <input type="number" step=".01" id="prixDepart" name="prixDepart">

      <input class="submit" name="addLot" type="submit" value="Ajouter">
    </form>
  </div>
</main>