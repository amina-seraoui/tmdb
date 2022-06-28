<main id="movie"
    <?php if ($movie->backdrop_path): ?>
        style="background-image: url('https://image.tmdb.org/t/p/original<?= $movie->backdrop_path ?>')"
    <?php endif; ?>
>
    <div class="container">
        <div class="left details">
            <h1><?= $movie->title ?></h1>
            <p>
                <span><?= $movie->vote_average ?> | <?= $movie->vote_count ?></span>
                <span>
                    <?= $movie->runtime ?> •
                    <?= implode(', ', $movie->genres) ?> •
                    <?= $movie->release_date->format('Y') ?>
                </span>
            </p>
            <p><?= $movie->overview ?></p>
            <?php if (!empty($movie->producers)): ?>
                <p>Producteurs : <?= implode(', ', $movie->producers) ?></p>
            <?php endif;
            if (!empty($movie->teasers)): ?>
                <button class="play-btn">Bande-annonce</button>
            <?php endif; ?>
        </div>
        <div class="right">

            <?php if (empty($movie->images->backdrops) && empty($movie->images->posters)): ?>
                <p style="font-style: italic">Aucune image disponible</p>
            <?php else: ?>
                <div class="images">
                    <h3>Images</h3>
                    <div class="slide">
                        <div class="slider">
                            <?php if (empty($movie->images->backdrops)):
                                foreach ($movie->images->posters as $img): ?>
                                    <img src="https://image.tmdb.org/t/p/w500<?= $img->file_path ?>" alt="<?= $movie->title ?>" width="125" height="175">
                                <?php endforeach;
                            else:
                                foreach ($movie->images->backdrops as $img): ?>
                                    <img src="https://image.tmdb.org/t/p/w500<?= $img->file_path ?>" alt="<?= $movie->title ?>" width="200" height="125">
                                <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="actors">
                <h3>Acteurs</h3>
                <?php if (empty($actors)): ?>
                    <p style="font-style: italic">Aucun acteur renseigné</p>
                <?php else: ?>
                    <div class="slide">
                        <div class="slider">
                            <?php for ($i = 0; $i < min(5, count($actors)); $i++): ?>
                                <a class="actor" href="/actor/<?= $actors[$i]->id; ?>">
                                    <img src="https://image.tmdb.org/t/p/original<?= $actors[$i]->profile_path; ?>" alt="<?= $actors[$i]->name; ?>" width="64" height="64">
                                    <p><?= $actors[$i]->name; ?></p>
                                </a>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php if (!empty($movie->teasers)): ?>
    <div id="teaser" data-src="<?= $movie->teasers[0]->key ?>">
        <iframe title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
<?php endif; ?>
