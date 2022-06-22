<main id="movie" style="background-image: url('https://image.tmdb.org/t/p/original<?= $show->backdrop_path ?>')">
    <div class="container">
        <div class="left details">
            <h1><?= $show->name ?></h1>
            <p>
                <span><?= $show->vote_average ?> | <?= $show->vote_count ?></span>
                <span><?= $show->number_of_seasons ?> saisons • <?= implode(', ', $show->genres) ?> • <?= $show->first_air_date->format('Y') ?></span>
            </p>
            <p><?= $show->overview ?></p>
            <p>
                Réalisateur : Guy Hawkins
            </p>
            <button class="play-btn">Bande-annonce</button>
        </div>
        <div class="right">

            <?php if (empty($show->images->backdrops) && empty($show->images->posters)): ?>
                <p style="font-style: italic">Aucune image disponible</p>
            <?php else: ?>
                <div class="images">
                    <h3>Images</h3>
                    <div class="slider">
                        <?php if (empty($show->images->backdrops)):
                            foreach ($show->images->posters as $img): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?= $img->file_path ?>" alt="<?= $show->name ?>" width="125" height="175">
                            <?php endforeach;
                        else:
                            foreach ($show->images->backdrops as $img): ?>
                                <img src="https://image.tmdb.org/t/p/w500<?= $img->file_path ?>" alt="<?= $show->name ?>" width="200" height="125">
                            <?php endforeach;
                        endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="actors">
                <h3>Acteurs</h3>
                <div class="slider">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <a class="actor" href="/actor/<?= $actors[$i]->id; ?>">
                            <img src="https://image.tmdb.org/t/p/original<?= $actors[$i]->profile_path; ?>" alt="<?= $actors[$i]->name; ?>" width="64" height="64">
                            <p><?= $actors[$i]->name; ?></p>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</main>
