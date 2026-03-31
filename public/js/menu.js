/**
 * La fonction displayMenu gère l'affichage et l'interaction du menu Burger et de son sous-menu.
 * Elle sélectionne les éléments HTML nécessaires et ajoute des écouteurs d'événements 
 * pour permettre l'interaction de l'utilisateur avec le menu Burger et le sous-menu.
 */
const displayMenu = () => {
  /**
 * Sélectionne l'élément HTML racine du header.
 * @returns {Element} L'élément avec la classe .header
 */
  const getHeader = document.querySelector(".header");

  /**
   * Sélectionne le bouton du menu Burger.
   * @returns {Element} L'élément avec la classe .menuBurger
   */
  const btnMenuBurger = document.querySelector(".menuBurger");

  /**
   * @returns {Element} L'élément avec la classe .menuOpen
   */
  const displayMenuBurger = document.querySelector(".menuOpen");

  /**
   * @returns {Element} L'élément avec la classe .underMenu
   */
  const hideMenu = document.querySelector(".underMenu");
  // Clic sur le bouton Burger
  if (btnMenuBurger && getHeader) {
    btnMenuBurger.addEventListener("click", () => {
      getHeader.classList.toggle("active");
    });
  }
  // Clic sur le bouton sous-menu
  if (displayMenuBurger && hideMenu) {
    displayMenuBurger.addEventListener("click", (e) => {
      e.preventDefault();
      hideMenu.classList.toggle("open");
    });
  }

}

displayMenu();