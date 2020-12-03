const Menu = () => {
  const openMenu = document.querySelector('.hamburger.open-menu');
  const closeMenu = document.querySelector('.hamburger.close-menu');

  openMenu.addEventListener('click', () => {
    openMenu.style.display = 'none';
    closeMenu.style.display = 'flex';
  })
  closeMenu.addEventListener('click', () => {
    closeMenu.style.display = 'none';
    openMenu.style.display = 'flex';
  })
}
export default Menu;
