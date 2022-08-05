const toggleMenu = (menu) => {
  let activeClass = 'active bg-gradient-dark text-white';
  menu.removeClass(activeClass).addClass(activeClass);
};

const initMenu = () => {
  let currentPage = window.location.pathname;
  currentPage = currentPage.split('/');
  currentPage = (currentPage.length > 2 ? currentPage[2] : currentPage[1]);

  let currentMenu = $(`#${currentPage}Menu`);
  toggleMenu(currentMenu);

  //Navbar Init
  $('#navbarTitle').html(currentPage);
  $('#navbarCurrentPage').html(currentPage);

};

