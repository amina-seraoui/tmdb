const toggles = document.querySelectorAll('.toggle-genres')
const aside = document.querySelector('aside')

toggles && toggles.forEach(toggle => {
    toggle.addEventListener('click', e => {
        aside.classList.toggle('active')
    })
})