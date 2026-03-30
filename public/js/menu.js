/**
 * Sélectionne l'élément HTML racine du header.
* @returns {Element} L'élément avec la classe .header
 */
const header = () => {
    return document.querySelector('.header');
};

/**
 * Sélectionne le bouton du menu Burger.
 * @returns {Element} L'élément avec la classe .menuBurger
 */
const btn = () => {
    return document.querySelector('.menuBurger');
};

/**
 * Au clic, on ajoute ou retire la classe 'active' sur le header,
 * ce qui déclenche l'affichage du menu via le CSS .
 */
btn().addEventListener('click', () => {
    header().classList.toggle('active');
});

