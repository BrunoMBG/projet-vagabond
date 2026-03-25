<!--  ==================== Head ==================== -->
<?php require RACINE . '/app/view/partials/head.php'; ?>

<body>
    <form action="" method="POST">
        <input type="text" name="nom" placeholder="Votre nom" required>
        <input type="text" name="prenom" placeholder="Votre prénom" required>
        <input type="email" name="email" placeholder="Votre email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">S'inscrire</button>
    </form>
</body>

</html>