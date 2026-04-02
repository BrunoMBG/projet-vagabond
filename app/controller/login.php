<?php require RACINE . '/app/class/form.php'; ?>
<?php require RACINE . '/app/model/user.php'; ?>

<?php
/**
 * Gère la connexion des utilisateurs.
 * Récupère l'utilisateur en base de données via son email.
 * Comparer le mot de passe saisi avec le mot de passe hash dans la base de données
 * * @global PDO $db Connexion à la base de données.
 * * @return void
 */
function login()
{
    global $db;
    $error = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = htmlspecialchars($_POST['email'] ?? '');
        $passwordValue = $_POST['password'] ?? '';
        if (!empty($email) && !empty($passwordValue)) {

            // Récupération des informations saisies par l'utilisateur depuis le modèle
            $user = getUserByEmail($db, $email);

            if ($user) {
                // Comparaison du    mot de passe saisi avec le mot de passe hash dans la base de données
                if (password_verify($passwordValue, $user['password'])) {
                    // Stockage des informations de l'utilisateur en session 
                    $_SESSION['user'] = [
                        'id'     => $user['id_utilisateur'],
                        'nom'    => $user['nom'],
                        'prenom' => $user['prenom'],
                        'email'  => $user['email'],
                        'role'   => $user['id_role']
                    ];

                    // Stockage des informations utilisateur
                    $_SESSION['user_id'] = $user['id_utilisateur'];
                    $_SESSION['user_role'] = $user['id_role'];

                    // Redirection vers la page d'accueil après connexion réussie
                    header("Location: index.php?action=default");
                    exit;
                } else {
                    $error = "Identifiants invalides.";
                }
            } else {
                $error = "Identifiants invalides.";
            }
        } else {
            $error = "Veuillez remplir tous les champs.";
        }
    }
    // Création du formulaire
    $form = new Form("index.php?action=login", "post");

    $form->setInput("email", "Email :", "email");
    $form->setInput("password", "Mot de passe :", "password");
    // Message d'erreur
    $form->setError($error);

    $form->setSubmit("Se connecter");
    // Ajout des liens utilitaires
    $form->setLink("index.php?action=forgotten", "Mot de passe oublié ?", "");
    $form->setText("Pas encore de compte ? ", "");
    $form->setLink("index.php?action=register", "Créer un compte", "");
    // Affichage du formulaire
    $formLogin = $form->getForm();
    require RACINE . "/app/view/login.php";
}


?>


