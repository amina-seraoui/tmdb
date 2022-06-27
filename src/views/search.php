<main id="research">
    <aside>
        <h3>Filtrer la recherche</h3>
        <ul class="categories">
            <li class="active" data-media_type="movie">Films<i></i></li>
            <li class="active" data-media_type="tv">Séries<i></i></li>
            <li class="active" data-media_type="person">Acteurs<i></i></li>
        </ul>
    </aside>
    <section>
        <div class="title">
            <h2><label for="search">Veuillez indiquer votre recherche</label></h2>
            <div class="search-form">
                <input type="search" id="search" name="search"/>
                <label for="search" class="search-btn"><img src="/assets/img/search.svg" alt="Loupe"></label>
            </div>
        </div>
        <div class="row">
            <h3>Films</h3>
            <div class="slide">
                <div class="slider movies">
                    <?php foreach ($movies as $movie): ?>
                        <a href="/movie/<?= $movie->id ?>" class="poster">
                            <img src="https://image.tmdb.org/t/p/w500<?= $movie->poster_path ?>" alt="<?= $movie->title ?>" width="150" height="200">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <h3>Séries</h3>
            <div class="slide">
                <div class="slider shows">
                    <?php foreach ($shows as $show): ?>
                        <a href="/tv/<?= $show->id ?>" class="poster">
                            <img src="https://image.tmdb.org/t/p/w500<?= $show->poster_path ?>" alt="<?= $show->name ?>" width="150" height="200">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <h3>Personnalités</h3>
            <div class="slide">
                <div class="slider actors">
                    <?php foreach ($actors as $actor): ?>
                        <a href="/actor/<?= $actor->id ?>" class="actor">
                            <img src="https://image.tmdb.org/t/p/w500<?= $actor->profile_path ?>" alt="<?= $actor->name ?>" width="125" height="125">
                            <p><?= $actor->name ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>
