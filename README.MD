# Projet Allociné

Réaliser une application web utilisant l'API [TMDB](https://www.themoviedb.org/)

## Pré-requis
- Composer
- PHP 8

## Installation

1. Depuis le dossier front :
   - Installer les dépendances : `npm i`
   - Compiler les assets : `npm run build`

2. Depuis la racine du projet :
   - Créer l'autoloader : `composer dump-autoload`
   - Installer les dépendances : `composer install`
   - Ajouter l'API KEY de TMDB dans le fichier [config.php](#configphp)
   - Lancer le serveur de développement : `composer start`

## config.php
```php
<?php

return [
    'API_KEY' => 'ma_cle_secrete'
];

```
