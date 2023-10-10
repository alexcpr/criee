<main>
  <div id="connecting">
    <div class="info-msg">
      <i class="fa-solid fa-circle-info"></i> Chargement...
      <br>
      La connexion au serveur d'enchère est en cours.
    </div>
  </div>
  <div id="enchere" style="display: none;">

    <h1>Enchère lot N°
      <?= $_POST['id'] . '-' . date('d-m-Y', strtotime($_POST['idDatePeche'])) . '-' . $_POST['idBateau']; ?>
    </h1>

    <div id="msg"></div>

    <h2 id="dernierEncheri">
      <?= $enchere['dernierEncheri'] === NULL ? '' : 'Dernier enchérisseur : ' . $enchere['dernierEncheri']; ?>
    </h2>

    <h2 id="enchereActuelle">
      <?= ($enchere['prixEnchere'] === NULL || $enchere['prixEnchere'] == '00.00') ? 'Vous êtes le premier à enchérir!' : 'Enchère actuelle : ' . $enchere['prixEnchere'] . '€'; ?>
    </h2>

    <h2 id="tempsRestant"></h2>

    <div class="form-container">
      <form action="" method="post">

        <label for="enchereUser">Votre enchère</label>
        <input step=".01"
          min="<?= $enchere['prixEnchere'] ? max($enchere['prixEnchere'], $enchere['prixPlancher']) : $enchere['prixPlancher']; ?>"
          type="number" id="enchereUser" name="enchereUser" required>

        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key'); ?>"></div>

        <input class="submit" name="encherir" type="submit" value="Enchérir">
      </form>
    </div>
  </div>
  <script>

    const message = document.querySelector('#msg');
    let msgFadeOutTimeOut;
    let msgResetTimeOut;

    const enchereId = <?= $_POST['id']; ?>;
    const idBateau = <?= $_POST['idBateau']; ?>;
    const idDatePeche = '<?= $_POST['idDatePeche']; ?>';

    const userId = <?= $_SESSION['user_id']; ?>;
    const token = '<?= hash('sha256', $_SESSION['user_id']); ?>';

    const conn = new WebSocket(`ws://192.168.1.80:8282?id=${enchereId}&idBateau=${idBateau}&idDatePeche=${idDatePeche}&userId=${userId}&token=${token}`);

    const connectingElement = document.querySelector('#connecting');
    const enchereElement = document.querySelector('#enchere');

    const enchereActuelle = document.querySelector('#enchereActuelle');
    const dernierEncheri = document.querySelector('#dernierEncheri');

    const displayConnecting = (message) => {
      connectingElement.style.display = 'block';
      connectingElement.innerHTML = message;
      enchereElement.style.display = 'none';
    };

    const displayEnchere = () => {
      connectingElement.style.display = 'none';
      enchereElement.style.display = 'block';
    };

    const fadeOutElement = (element) => {
      element.classList.add('fade-out');
      setTimeout(() => {
        element.innerHTML = '';
        element.classList.remove('fade-out');
      }, 1000);
    };

    conn.addEventListener('open', () => {
      displayEnchere();
    });

    conn.addEventListener('message', (event) => {
      const data = JSON.parse(event.data);

      if (!data.error) {
        enchereActuelle.innerHTML = `Enchère actuelle : ${data.newEnchere}€`;
        dernierEncheri.innerHTML = `Dernier enchérisseur : ${data.dernierEncheri}`;
        document.querySelector('#enchereUser').value = '';
      }

      msg.innerHTML = data.result;
      msgFadeOutTimeOut = setTimeout(() => {
        msg.classList.add('fade-out');
        msgResetTimeOut = setTimeout(() => {
          msg.innerHTML = '';
          msg.classList.remove('fade-out');
        }, 1000);
      }, 2000);

    });

    conn.addEventListener('error', (event) => {
      console.log(`Error: ${event.data}`);
      displayConnecting('<div class="error-msg"> <i class="fa-solid fa-x"></i> Erreur!<br>La connexion au serveur de vente aux enchères a échoué.<br>Veuillez réessayer ultérieurement.</div>');
    });

    conn.addEventListener('close', (event) => {
      console.log(`Error: ${event.data}`);
      displayConnecting('<div class="error-msg"> <i class="fa-solid fa-x"></i> Erreur!<br>La connexion au serveur de vente aux enchères a échoué.<br>Veuillez réessayer ultérieurement.</div>');
    });

    document.querySelector('form').addEventListener('submit', (event) => {
      event.preventDefault();

      clearTimeout(msgFadeOutTimeOut);
      clearTimeout(msgResetTimeOut);
      msg.innerHTML = '';
      msg.classList.remove('fade-out');

      const captcha = grecaptcha.getResponse(); // Utilisez la fonction fournie par la bibliothèque de captcha pour obtenir la réponse du captcha

      // Vérifiez si le captcha est valide
      if (captcha === '') {
        // Le captcha n'a pas été résolu
        msg.innerHTML = "<div class=\"warning-msg\"><i class=\"fa-solid fa-triangle-exclamation\"></i> Veuillez résoudre le captcha.</div>";
        msgFadeOutTimeOut = setTimeout(() => {
          msg.classList.add('fade-out');
          msgResetTimeOut = setTimeout(() => {
            msg.innerHTML = '';
            msg.classList.remove('fade-out');
          }, 1000);
        }, 2000);
        return;
      }

      const bidAmount = document.querySelector('#enchereUser').value;
      const data = {
        id: '<?= $_POST['id']; ?>',
        idBateau: '<?= $_POST['idBateau']; ?>',
        idDatePeche: '<?= $_POST['idDatePeche']; ?>',
        bidAmount: bidAmount,
        captcha: captcha
      };

      conn.send(JSON.stringify(data));
      grecaptcha.reset();
    });

    (function () {
      const dateMySQL = "<?= $enchere['dateFinEnchere']; ?>";

      // Convertir la date en format JavaScript
      const date = new Date(dateMySQL);

      // Récupérer l'élément HTML pour afficher le compte à rebours
      const countdown = document.getElementById("tempsRestant");

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
        countdown.innerHTML = "Fin de l'enchère : " + days + "j " + hours + "h " + minutes + "m " + seconds + "s";

        // Si la date d'entrée est dépassée, arrêter le compte à rebours
        if (diff < 0) {
          clearInterval(timer);
          countdown.innerHTML = "L'enchère s'est terminée.";
        }
      }, 1000);
    })();
  </script>
</main>