const input = document.querySelector('.search-form input[type=search]')
const h2 = document.querySelector('h2')
const rows = document.querySelectorAll('.row')
const movies = document.querySelector('.slider.movies')
const shows = document.querySelector('.slider.shows')
const actors = document.querySelector('.slider.actors')
const categories = document.querySelectorAll('.categories li')

// liste des médias possible
const medias = ['movie', 'tv', 'person']

// tableau des médias à afficher
let medias_active = []

if (input && h2 && rows && movies && shows && actors && categories) {
    // A chaque clic sur une catégorie : on l'active/désactive et on relance la recherche
    categories.forEach(cat => {
        cat.addEventListener('click', e => {
            cat.classList.toggle('active')
            refresh()
        })
    })

    // A chaque modification de la recherche : on la relance
    input.addEventListener('input', e => {
        refresh()
    })

    const refresh = () => {
        init()
        if(medias_active.length) {
            h2.innerText = input.value ? `Résultats de votre recherche “ ${input.value} ”` : 'Tendances'
            medias.forEach(media => {
                medias_active.indexOf(media) !== -1 && fetchResult(input.value, media)
            })
        } else {
            h2.innerText = 'Veuillez séléctionner une catégorie'
        }
    }

    const init = () => {
        movies.innerHTML = ''
        shows.innerHTML = ''
        actors.innerHTML = ''

        // getmedias_active
        medias_active = []
        categories.forEach(cat => {
            if (cat.className === 'active') medias_active.push(cat.dataset.media_type)
        })

        // Afficher les blocs selon les médias activés
        medias.forEach((media, id) => {
            rows[id].style.display = medias_active.indexOf(media) !== -1 ? 'block' : 'none'
        })
    }

    // si la valeur est vide, renvoie les tendances
    const fetchResult = (val, media_type) => {
        const endpoint = val !== '' ?
          'search/' + media_type :
          'trending/' + media_type + '/day'

        fetch(
          'https://api.themoviedb.org/3/' + endpoint + '?' +
          'api_key=3878fff853d2f6476b4bef55a2246bf1' +
          '&language=fr-FR' +
          '&query=' + val
        )
          .then(res => res.json())
          .then(res => {
              // s'il y a des résultats : boucler dessus
              if (res.total_results) {
                  res.results.forEach(r => {
                      switch (media_type) {
                          case 'movie':
                              movies.appendChild(createPoster(r, media_type))
                              break
                          case 'tv':
                              shows.appendChild(createPoster(r, media_type))
                              break
                          case 'person':
                              actors.appendChild(createPerson(r))
                      }
                  })
              } else {
                  switch (media_type) {
                      case 'movie':
                          movies.innerText = 'Aucun résultat dans cette section'
                          break
                      case 'tv':
                          shows.innerText = 'Aucun résultat pour cette section'
                          break
                      case 'person':
                          actors.innerText = 'Aucun résultat pour cette section'
                  }
              }
          })
    }

    const createPoster = (e, media_type) => {
        const a = document.createElement('a')
        const img = document.createElement('img')
        a.className = 'poster'
        a.href = `/${media_type}/${e.id}`
        img.src = `https://image.tmdb.org/t/p/w500${e.poster_path ?? ''}`
        img.alt = e.title ?? e.name
        img.width = '150'
        img.height = '200'
        a.appendChild(img)
        return a
    }

    const createPerson = (e) => {
        const div = document.createElement('div')
        const a = document.createElement('a')
        const img = document.createElement('img')
        const p = document.createElement('p')
        div.className = 'actor'
        a.href = `/actor/${e.id}`
        img.src = `https://image.tmdb.org/t/p/w500${e.profile_path ?? ''}`
        img.alt = e.name
        img.width = '125'
        img.height = '125'
        p.innerText = e.name

        a.appendChild(img)
        div.appendChild(a)
        div.appendChild(p)
        return div
    }
}    
