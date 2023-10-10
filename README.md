# La Criée - Application Web

La Criée est une application web créée avec le framework CodeIgniter.
Elle permet de gérer les ventes aux enchères en ligne de lots de poissons. 

## Configuration requise

- PHP 
- Serveur web (Apache, NGINX, etc.)
- Base de données MySQL ou MariaDB

## Installation

- Clonez ce dépôt dans votre dossier www : 
```bash
git clone https://github.com/alexcpr/criee.git
```

- Importez le fichier SQL fourni dans le dossier ``sql`` dans votre base de données. Ce script va créer la base de données criee.

- Dans le fichier ``application/config/database.php``, modifiez les paramètres de la base de données selon vos besoins. Par défaut, la connexion utilise le compte root avec le mot de passe root.

- Accédez au site en utilisant l'URL ``http://localhost/criee/public``

## Serveur d'enchères

Le système d'enchère utilise un serveur WebSocket que l'on lance via la commande suivante :
```bash
php index.php websocket index
```

## Compte par défaut

Le script SQL contient un utilisateur par défaut ``John DOE`` (john@doe.com) avec comme mot de passe ``testtest``.

## Panel admin

L'accès au panel admin se fait via le lien ``http://localhost/criee/public/VmkOcB8uM3vitpE2MIojw8PZr08BfvKU`` avec comme mot de passe ``testadmin``.

*PS*: Pour accéder au panel admin, il faut être connecté au compte ``John DOE`` sinon même avec le bon mot de passe la tentative de connexion sera rejetée.

*PS2*: Le choix de choisir ``/VmkOcB8uM3vitpE2MIojw8PZr08BfvKU`` pour l'accès au panel admin et non pas ``/admin`` et pour éviter les bots qui crawl (parcourent) les URIs connues de panel admin.