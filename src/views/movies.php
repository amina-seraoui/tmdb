<main id="genres" data-media_type="movie">
    <aside>
        <h3>Genres</h3>
        <ul>
            <?php foreach ($genres as $genre): ?>
                <li <?= $genre->id === (int)$actual->id ? 'class="active"' : null ?> data-id="<?= $genre->id ?>"><?= $genre->name ?><i></i></li>
            <?php endforeach; ?>
        </ul>
    </aside>
    <section>
        <h2>Films</h2>
        <div class="category">
            <h3 class="cat-names"><?= $actual->name ?></h3>
            <div class="row">
                <?php foreach ($movies as $movie): ?>
                    <a href="/movie/<?= $movie->id ?>" class="poster">
                        <img src="https://image.tmdb.org/t/p/w500<?= $movie->poster_path ?>" alt="<?= $movie->title ?>" width="150" height="200">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
