<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/assets/css/index.css">
        <link rel="shortcut icon" href="/assets/img/logo.svg" type="image/svg">
        <title>Allociné</title>
    </head>
    <body>

        <header>
            <a href="/" class="logo"><img src="/assets/img/logo.svg" alt="Logo" width="40" height="40"></a>
            <nav>
                <ul>
                    <li<?= $route_name === 'movie' ? ' class="active"' : '' ?>><a href="/movies">Films</a></li>
                    <li<?= $route_name === 'show' ? ' class="active"' : '' ?>><a href="/shows">Séries</a></li>
                    <li<?= $route_name === 'search' ? ' class="active"' : '' ?>><a href="/search">Recherche</a></li>
                </ul>
            </nav>
        </header>

        <?= $content ?>

        <script src="/assets/js/index.js" type="module"></script>
    </body>
</html>
