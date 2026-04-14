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
 * Gère l'état actif des liens de navigation en comparant les paramètres d'URL.
 * Identifie le paramètre 'action' de la page actuelle et le compare à celui de chaque lien
 * (Header et Footer) pour appliquer la classe 'active' de manière précise.
 */
const addClassActive = () => {
 
    /* Récupére le paramètre action de l'URL actuelle */
    const currentParams = new URLSearchParams(window.location.search);
    const currentAction = currentParams.get('action');

    /* Sélection des liens de navigation du header et du footer */
    const navLinks = document.querySelectorAll('.navMenu a, .footer-link');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');

        // Ignore le lien s'il est vide ou s'il s'agit d'une ancre (#)
        if (!href || href === "#") return;

        /* Récupération du paramètre action dans l'attribut href du lien */
        const linkParams = new URLSearchParams(href.split('?')[1]);
        const linkAction = linkParams.get('action');

        /* Comparaison entre l'action de la page et celle du lien */
        if (currentAction === linkAction) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}

addClassActive();