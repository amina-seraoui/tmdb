const play = document.querySelector('.play-btn')
const modal = document.getElementById('teaser')
const iframe = document.querySelector('#teaser iframe')

if (play && modal && iframe) {
    play.addEventListener('click', e => {
        modal.classList.add('active')
        iframe.src=`https://www.youtube.com/embed/${modal.dataset.src}`
    })

    modal.addEventListener('click', e => {
        modal.classList.remove('active')
        iframe.src=''
    })

    window.addEventListener('keydown', e => {
        e.key === 'Escape' ? modal.click() : null
    })
}
