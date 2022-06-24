<main id="actor">
    <div class="container">
        <div class="left">
            <img src="https://image.tmdb.org/t/p/original<?= $actor->profile_path ?>" alt="<?= $actor->name ?>">
            <div class="details">
                <h3>Biographie</h3>
                <p><?= empty($actor->biography) ? 'Aucune biographie disponible.' : $actor->biography ?></p>
            </div>
        </div>
        <div class="right">
            <h1><?= $actor->name ?></h1>
            <ul class="general">
                <li>
                    <h3>Apparitions connues</h3>
                    <p><?= count($movies) ?></p>
                </li>
                <li>
                    <h3>Date de naissance</h3>
                    <p><?= $actor->birthday->format('d/m/Y') .  ' (' . $actor->age . ' ans)' ?></p>
                </li>
                <li>
                    <h3>Genre</h3>
                    <p><?= $actor->gender === 1 ? 'Femme' : 'Homme' ?></p>
                </li>
                <li>
                    <h3>Lieu de naissance</h3>
                    <p><?= $actor->place_of_birth ?></p>
                </li>
            </ul>
            <div class="movies">
                <h2>Filmographie</h2>
                <div class="populars">
                    <h3>Populaires</h3>
                    <div class="slider">
                        <?php for ($i = 0; $i < min(5, count($populars)); $i++): ?>
                            <a href="/<?= $populars[$i]->media_type . '/' . $populars[$i]->id ?>">
                                <img src="https://image.tmdb.org/t/p/w500<?= $populars[$i]->poster_path ?>" alt="<?= $populars[$i]->title ?? $populars[$i]->name ?>" width="125" height="175">
                            </a>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="chronos">
                    <h3>Chronologiquement</h3>
                    <ul>
                        <?php foreach ($movies as $movie): ?>
                            <li><a href="/<?= $movie->media_type . '/' . $movie->id ?>">
                                <?= $movie->release_date->format('Y') ?> • <?= $movie->name ?? $movie->title ?> (<?= $movie->character ?>)
                            </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>