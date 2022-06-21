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
                    <li><a href="#">Films</a></li>
                    <li><a href="#">Séries</a></li>
                    <li><a href="#">Acteurs</a></li>
                </ul>

                <form action="#" method="POST">
                    <input type="search" id="search" name="search"/>
                    <label for="search" class="search-btn"><img src="/assets/img/search.svg" alt="Loupe"></label>
                </form>
            </nav>
        </header>

        <?= $content ?>

        <footer>
            <p>Copyright © 2022 - Amina Seraoui. Tous droits réservés.</p>
        </footer>
    </body>
</html>
