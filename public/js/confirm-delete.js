/**
 * Intercepte les clics sur les boutons de suppression pour demander une confirmation.
 * Parcourt tous les éléments ayant la classe 'btnDelete',
 * affiche une boîte de dialogue et interrompt l'action
 * de redirection si l'utilisateur choisit d'annuler.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Récupèration de tous les boutons de suppression
    const deleteButtons = document.querySelectorAll('.btnDelete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            // Affiche la boîte de dialogue
            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce récit définitivement ?");

            // Si l'utilisateur clique sur "Annuler", le lien est bloqué 
            if (!confirmation) {
                event.preventDefault();
            }
        });
    });
});