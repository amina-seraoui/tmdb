const toggle = document.getElementById('toggle-menu')
const menu = document.querySelector('header')

toggle.addEventListener('click', e => {
    menu.classList.toggle('active')
})
