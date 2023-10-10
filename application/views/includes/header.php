<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Criée</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('app/css/app.css?v=' . time()); ?>">
    <link async rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <meta name="format-detection" content="telephone=no">
</head>

<body>
    <header>
        <h1>La Criée
            <?= isset($_SESSION['admin']) ? ' - ADMIN' : ''; ?>
        </h1>
    </header>
    <nav>
        <h1>La Criée
            <?= isset($_SESSION['admin']) ? ' - ADMIN' : ''; ?>
        </h1>
        <div class="menu-icon">&#9776;</div>
        <div class="nav-container">
            <a href="<?= base_url(); ?>">Accueil</a>
            <a href="<?= base_url('products'); ?>">Produits</a>
            <?= isset($_SESSION['admin']) ? '<a href="' . base_url('VmkOcB8uM3vitpE2MIojw8PZr08BfvKU') . '">Admin</a>' : ''; ?>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <a href="<?= base_url('account'); ?>">Mon compte</a>
                <a href="<?= base_url('cart'); ?>">Panier (<?= $panier['countPanier']; ?>)</a>
                <a href="<?= base_url('logout'); ?>">Déconnexion</a>
            <?php } else { ?>
                <a href="<?= base_url('login'); ?>">Se connecter</a>
                <a href="<?= base_url('register'); ?>">S'inscrire</a>
            <?php } ?>
        </div>
    </nav>