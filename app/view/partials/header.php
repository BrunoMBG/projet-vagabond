 <header class="header">
     <div class="menuIconeLogo">
         <a href="index.php?action=default">VAGABOND</a>

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
             <!-- Ajout d'un menu quand l'utilisateur est connecté -->
             <?php if (isset($_SESSION['user_id'])): ?>
                 <li class="menuConnection">
                     <a href="#" class="menuOpen">
                         Mon Compte <i class="fa-solid fa-chevron-down"></i>
                     </a>
                     <!-- Sous-menu -->
                     <ul class="underMenu">
                         <li><a href="index.php?action=profile"><i class="fa-solid fa-user"></i> Mon Profil</a></li>
                         <li><a href="index.php?action=logout" class="logout-link"><i class="fa-solid fa-power-off"></i> Déconnexion</a></li>
                     </ul>
                 </li>
                 <!-- Si l'utilisateur n'est pas connecté -->
             <?php else: ?>
                 <li><a href="index.php?action=login">Se&nbsp;connecter</a></li>
             <?php endif; ?>
         </ul>
     </nav>
 </header>