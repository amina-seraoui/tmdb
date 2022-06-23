<main id="home">
    <section style="background-image: url('https://image.tmdb.org/t/p/original<?= $trends[0]->backdrop_path ?>')">
        <div class="container">
            <h1><a href="<?= $trends[0]->media_type . '/' . $trends[0]->id ?>"><?= $trends[0]->original_title ?></a></h1>
            <button class="play-btn">Bande-annonce</button>
        </div>
    </section>

    <section>
        <aside>
            <h3>Genres</h3>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li><a href="/movies/<?= $category->id ?>"><?= $category->name ?></a></li>
                <?php endforeach; ?>
            </ul>
        </aside>
        <div class="trends">
            <h3>Populaires</h3>
            <div class="slider">
                <?php for($i = 1; $i < count($trends); $i++): ?>
                    <a href="<?= $trends[$i]->media_type . '/' . $trends[$i]->id ?>" class="poster">
                        <img src="https://image.tmdb.org/t/p/w500/<?= $trends[$i]->poster_path ?>" alt="<?= $trends[$i]->original_title ?>" width="200" height="275">
                    </a>
                <?php endfor; ?>
            </div>
        </div>
        <a href="/">Voir plus <img src="assets/img/arrow-right.svg" alt="Fléche droite"></a>
    </section>

</main>