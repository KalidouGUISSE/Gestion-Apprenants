<div class="dashboard-container">
    <h2>Tableau de bord Vigile</h2>
    <div class="welcome-message">
        Bienvenue, <?= $user['login'] ?> !
    </div>
    
    <div class="dashboard-menu">
        <div class="menu-item">
            <h3>Gestion des Présences</h3>
            <ul>
                <li><a href="index.php?route=presences_add">Enregistrer une présence</a></li>
                <li><a href="index.php?route=presences_list">Liste des présences</a></li>
            </ul>
        </div>
    </div>
</div>