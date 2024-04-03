<!-- Division pour le sommaire -->
<nav class="menuLeft">
    <ul class="menu-ul">

        <li class="menu-item">
            Visiteur :<br>
            <?php echo $_SESSION['prenom'] . "  " . $_SESSION['nom'] ?>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes
                fiches de frais</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=cumulefrais&action=cumulefrais" title="Consultation de mes cumules">Mes
                cumules de type de frais en fonction des mois</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=idvisiteurType&action=idvisiteurType" title="Consultation de mes cumules">Mes
                cumules de type de frais en fonction de L'idvisiteur</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=MoisLibelle&action=MoisLibelle" title="Consultation de mes cumules">Mes
                cumules de frais des libelles en fonction du mois</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=LibelleId&action=LibelleId" title="Consultation de mes cumules">Mes
                cumules de frais des libelles en fonction de l'id</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=AjouterFrais&action=AjouterFrais" title="Consultation de mes cumules">Ajouter un frais</a>
        </li>

        <br>

        <li class="menu-item">
            <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
        </li>
    </ul>
</nav>
<section class="content">


