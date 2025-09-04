let toggleBtn = document.getElementById('toggle-btn');
let body = document.body;
let darkMode = localStorage.getItem('dark-mode');

const enableDarkMode = () => {
   if (toggleBtn) toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
};

const disableDarkMode = () => {
   if (toggleBtn) toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
};

if (darkMode === 'enabled') {
   enableDarkMode();
}

if (toggleBtn) {
   toggleBtn.onclick = () => {
      darkMode = localStorage.getItem('dark-mode');
      if (darkMode === 'disabled') {
         enableDarkMode();
      } else {
         disableDarkMode();
      }
   };
}

const search = document.querySelector('.header .flex .search-form');
const mainNav = document.querySelector('.header .flex .main-nav');
const menuBtn = document.querySelector('#menu-btn');

if (menuBtn && mainNav) {
   menuBtn.addEventListener('click', () => {
      mainNav.classList.toggle('active');
   });
}

window.addEventListener('scroll', () => {
    if (search) search.classList.remove('active');
    if (mainNav) mainNav.classList.remove('active');
});