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


            $user = getUserByEmail($db, $email);

            if ($user) {

                if (password_verify($passwordValue, $user['password'])) {


                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['user_id'] = $user['id_utilisateur'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_role'] = $user['id_role'];


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

    $form = new Form("index.php?action=login", "post");

    $form->setInput("email", "Email :", "email");
    $form->setInput("password", "Mot de passe :", "password");
    $form->setError($error);
    $form->setSubmit("Se connecter");


    $formLogin = $form->getForm();
    require RACINE . "/app/view/login.php";
}

login()
?>


