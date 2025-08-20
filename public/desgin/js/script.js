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

let profile = document.querySelector('.header .flex .profile');
let search = document.querySelector('.header .flex .search-form');

const userBtn = document.querySelector('#user-btn');
if (userBtn && profile) {
   userBtn.onclick = () => {
      profile.classList.toggle('active');
      if (search) search.classList.remove('active');
   };
}

const searchBtn = document.querySelector('#search-btn');
if (searchBtn && search) {
   searchBtn.onclick = () => {
      search.classList.toggle('active');
      if (profile) profile.classList.remove('active');
   };
}

let sideBar = document.querySelector('.side-bar');

const menuBtn = document.querySelector('#menu-btn');
if (menuBtn && sideBar) {
   menuBtn.onclick = () => {
      sideBar.classList.toggle('active');
      body.classList.toggle('active');
   };
}

const closeBtn = document.querySelector('#close-btn');
if (closeBtn && sideBar) {
   closeBtn.onclick = () => {
      sideBar.classList.remove('active');
      body.classList.remove('active');
   };
}

window.onscroll = () => {
   if (profile) profile.classList.remove('active');
   if (search) search.classList.remove('active');

   if (window.innerWidth < 1200 && sideBar) {
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }
};