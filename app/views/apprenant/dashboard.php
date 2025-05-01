<div class="dashboard-container">
    <h2>Tableau de bord Apprenant</h2>
    <div class="welcome-message">
        Bienvenue, <?= $user['login'] ?> !
    </div>
    
    <div class="dashboard-menu">
        <div class="menu-item">
            <h3>Mes informations</h3>
            <ul>
                <li><a href="index.php?route=apprenant_profile">Mon profil</a></li>
                <li><a href="index.php?route=apprenant_presences">Mes présences</a></li>
            </ul>
        </div>
    </div>
</div>