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
const userMenu = document.getElementById('user-menu');

if (menuBtn) {
   menuBtn.addEventListener('click', (e) => {
      // On desktop, toggle user dropdown; on mobile, toggle nav
      const isMobile = window.matchMedia('(max-width: 992px)').matches;
      if (isMobile) {
         if (mainNav) mainNav.classList.toggle('active');
      } else {
             if (userMenu) {
                  const open = userMenu.classList.toggle('active');
                  menuBtn.classList.toggle('active', open);
                  menuBtn.setAttribute('aria-expanded', String(open));
                  userMenu.setAttribute('aria-hidden', String(!open));
             }
      }
      e.stopPropagation();
   });

    // Keyboard support
    menuBtn.addEventListener('keydown', (e) => {
       if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          menuBtn.click();
       }
    });
}

window.addEventListener('scroll', () => {
    if (search) search.classList.remove('active');
    if (mainNav) mainNav.classList.remove('active');
      if (userMenu) {
         userMenu.classList.remove('active');
         if (menuBtn) { menuBtn.classList.remove('active'); menuBtn.setAttribute('aria-expanded','false'); userMenu.setAttribute('aria-hidden','true'); }
      }
});

// Close dropdown on outside click
document.addEventListener('click', (e) => {
   if (userMenu && !userMenu.contains(e.target) && e.target !== menuBtn) {
   userMenu.classList.remove('active');
   if (menuBtn) { menuBtn.classList.remove('active'); menuBtn.setAttribute('aria-expanded','false'); userMenu.setAttribute('aria-hidden','true'); }
   }
});

// Filters sidebar is always visible now; no JS toggling needed.