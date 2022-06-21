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

            <div class="images">
                <h3>Images</h3>
                <div class="slider">
                    <?php foreach ($show->images->backdrops as $img): ?>
                        <img src="https://image.tmdb.org/t/p/w500<?= $img->file_path ?>" alt="<?= $show->name ?>" width="200" height="125">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="actors">
                <h3>Acteurs</h3>
                <div class="slider">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <a class="actor" href="<?= $actors[$i]->id; ?>">
                            <img src="https://image.tmdb.org/t/p/original<?= $actors[$i]->profile_path; ?>" alt="<?= $actors[$i]->name; ?>" width="64" height="64">
                            <p><?= $actors[$i]->name; ?></p>
                        </a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</main>
