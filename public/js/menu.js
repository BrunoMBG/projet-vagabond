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
   // 3. Si l'URL contient le href du lien, on ajoute la classe
        // On vérifie que le href n'est pas juste "#"
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

  // Clic sur le  Burger
  if (btnMenuBurger && getHeader) {
    btnMenuBurger.addEventListener("click", () => {
      getHeader.classList.toggle("active");
    });
  }

  // Clic sur le sous-menu mon compte
  if (displayMenuBurger && hideMenu) {
    displayMenuBurger.addEventListener("click", (e) => {
      e.preventDefault();
      hideMenu.classList.toggle("open");
    });
  }

 /**
   * @returns {Element} L'élément avec la classe .menuOpenAdmin
   */
  const displayAdmin = document.querySelector(".menuOpenAdmin");

   /**
   * @returns {Element} L'élément avec la classe .adminMenu
   */
  const displayMenuAdmin = document.querySelector(".adminMenu");

 // Clic sur le sous-menu admin
  if (displayAdmin && displayMenuAdmin) {
    displayAdmin.addEventListener("click", (e) => {
      e.preventDefault();
      displayMenuAdmin.classList.toggle("open");
    });
  }
}

displayMenu();

/**
 * Gère l'état actif des liens de navigation (Header et Footer).
 * Parcourt les liens du menu et du footer pour comparer leur 'href' avec l'URL actuelle.
 * Ajoute la classe 'active' au lien correspondant pour permettre un retour visuel à l'utilisateur.
 */
const addClassActive = () => {
  // Récupère l'URL complète affichée dans la barre d'adresse
    const currentUrl = window.location.href;
    
  // Sélectionne tous les liens à l'intérieur du menu de navigation
    const navLinks = document.querySelectorAll('.navMenu a, .footer-link');

    // Vérifie si l'URL actuelle contient le chemin du lien
    // Et s'assure que le lien n'est pas vide
    navLinks.forEach(link => {
        if (currentUrl.includes(link.getAttribute('href')) && link.getAttribute('href') !== "#") {
            link.classList.add('active');
        }
    });
}

addClassActive()