<div class="dashboard-container">
    <h2>Tableau de bord</h2>
    <div class="welcome-message">
        Bienvenue, <?= $user['login'] ?> !
    </div>
    
    <div class="dashboard-info">
        <p>Vous êtes connecté avec le rôle: <?= $user['role'] ?></p>
    </div>
</div>