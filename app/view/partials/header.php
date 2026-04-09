 <header class="header">
    <!-- Logo et menu burger -->
     <div class="menuIconeLogo">
        <!-- Logo -->
         <a href="index.php?action=default">VAGABOND</a>
        <!-- Menu burger -->
         <button class="menuBurger" aria-label="Ouvrir le menu">
             <i class="fa-solid fa-bars icon-burger"></i>
             <i class="fa-solid fa-xmark icon-close"></i>
         </button>
     </div>
     <!-- ================== Menu ==================-->
     <nav class="navMenu">
         <ul>
             <!-- Menu liens  -->
             <li><a href="index.php?action=default">Accueil</a></li>
             <li><a href="index.php?action=blog">Blog</a></li>
             <li><a href="index.php?action=contact">Contact</a></li>

             <?php // ==================== Ajout d'un menu quand l'utilisateur est connecté ==================== ?>
             <?php if (isset($_SESSION['user_id'])): ?>
                 <li class="menuConnection">
                     <a href="#" class="menuOpen">
                         Mon Compte <i class="fa-solid fa-chevron-down"></i>
                     </a>
                     <!-- Sous-menu -->
                     <ul class="underMenu">

                        <?php // Si l'utilisateur est admin ou rédacteur, affiche le tableau de bord ?>
                          <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 1 || $_SESSION['user_role'] === 2)): ?>
                             <li>
                                 <a href="#" class="menuOpenAdmin">
                                     Tableau de bord<i class="fa-solid fa-chevron-down"></i>
                                 </a>
                                  <ul class="adminMenu">
                                    <li><a href="index.php?action=articleAdd">Ajouter un article</a></li>
                                    <li><a href="index.php?action=articleEdit">Gestion articles</a></li>
                                    
                                    <?php // Si c'est l'administrateur, affiche la gestion des utilisateurs ?>
                                    <?php if ($_SESSION['user_role'] === 1): ?>
                                        <li><a href="index.php?action=user_list"> Gestion des utilisateurs</a></li>
                                    <?php endif; ?>
                                </ul>
                             </li>
                         <?php endif; ?>

                         <!-- Liens utilisateur connecté -->
                         <li><a href="index.php?action=profile"><i class="fa-solid fa-user"></i> Informations personnelles </a></li>
                         <li><a href="index.php?action=profile_edit"><i class="fa-solid fa-user"></i> Modifier le profil</a></li>
                         <li><a href="index.php?action=logout" class="logout-link"><i class="fa-solid fa-power-off"></i> Déconnexion</a></li>
                     </ul>
                 </li>

              <?php // ==================== Si l'utilisateur n'est pas connecté ==================== ?>                 
             <?php else: ?>
                 <li><a href="index.php?action=login">Se&nbsp;connecter</a></li>
             <?php endif; ?>
         </ul>
     </nav>
 </header>
