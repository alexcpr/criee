const menuIcon = document.querySelector('.menu-icon');
const navContainer = document.querySelector('.nav-container');

menuIcon.addEventListener('click', () => {
  navContainer.classList.toggle('active');
});
