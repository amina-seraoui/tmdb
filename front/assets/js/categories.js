const main = document.querySelector('#genres')
const categories = document.querySelectorAll('#genres aside ul li')
const h3 = document.querySelector('.cat-names')
const row = document.querySelector('.row')

if (main && categories && row) {
    const media_type = main.dataset.media_type
    let page = 2
    let last_fetch = 1
    let total_pages = parseInt(main.dataset.total_pages ?? 0)
    let ids = []

    // On ajoute un listener au click sur chaque li catégorie
    categories.forEach(cat => {
        cat.addEventListener('click', e => {
            init()
            cat.classList.toggle('active')
            getMovies()
        })
    })

    // Réinitialise les variables
    const init = () => {
        page = 1
        last_fetch = 0
        row.innerHTML = ''
    }
    
    // On récupère les films des catégories sur lesquels on a cliqué
    const getMovies = () => {
        ids = []
        const catNames = []
        categories.forEach(cat => {
            if (cat.classList.contains('active')) {
                ids.push(cat.dataset.id)
                catNames.push(cat.innerText)
            }
        })
    
        h3.innerText = catNames.join(', ')
        callApi()
    }
    
    // On appelle l'api pour récupérer les résultats selon les catégories sélectionnées
    const callApi = () => {
        if (last_fetch !== page) {
            last_fetch = page
            fetch(
                'https://api.themoviedb.org/3/discover/' + media_type + '/?'+
                'api_key=3878fff853d2f6476b4bef55a2246bf1'+
                '&language=fr-FR'+
                '&with_genres=' + ids.join() +
                '&page=' + page
            )
            .then(res => res.json())
            .then(res => {
                total_pages = res.total_pages
                page++
                res.results?.forEach(movie => {
                    const a = document.createElement('a')
                    const img = document.createElement('img')
                    a.href = `/${media_type}/${movie.id}`
                    a.className = 'poster'
                    img.src = `https://image.tmdb.org/t/p/w500/${movie.poster_path}`
                    img.alt = media_type === 'movie' ? movie.title : movie.name
                    img.width = '150'
                    img.height = 200
                    a.appendChild(img)
                    row.appendChild(a)
                })
            })
        }
    }
    
    // On charge la page suivante lorsqu'on arrive en bas de page
    row.addEventListener('wheel', e => {
        if (row.scrollTop + row.offsetHeight >= row.scrollHeight) {
            if (page <= total_pages) callApi()
        }
    })
}
