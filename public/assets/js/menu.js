const toggle = document.getElementById('toggle-menu')
const menu = document.querySelector('header')

toggle && toggle.addEventListener('click', e => {
    menu.classList.toggle('active')
})
