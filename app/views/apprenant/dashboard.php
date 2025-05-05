<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Sonatel</title>
    <link rel="stylesheet" href="assets/css/style.apprenant.css" />
</head>
<body>
    <header>
        <div class="container header-content">
            <img src="https://cdnjs.cloudflare.com/ajax/libs/simple-icons/6.0.0/simpleicons.svg" alt="Sonatel Logo" class="logo">
            <div class="user-profile">
                <span>Kalidou</span>
                <img src="/api/placeholder/40/40" alt="Profile" class="profile-pic">
            </div>
        </div>
    </header>

    <main class="container">
        <div class="dashboard-title">
            Tableau de Bord
        </div>

        <div class="dashboard-grid">
            <div class="card card-full">
                <div class="profile-card">
                    <img src="/api/placeholder/100/100" alt="Kalidou GUISSE" class="profile-image">
                    <div class="profile-details">
                        <h2>Kalidou GUISSE</h2>
                        <p>DevWeb</p>
                        <div class="profile-info">
                            <div class="profile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722z"/>
                                </svg>
                            </div>
                            <span>kalidouguisse16@gmail.com</span>
                        </div>
                        <div class="profile-info">
                            <div class="profile-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            </div>
                            <span>#DW25041</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card presence-card">
                <h3>
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                    </div>
                    Présences
                </h3>
                <div class="presence-stats">
                    <div class="stat-box present">
                        <div class="number">40</div>
                        <div class="label">Présent</div>
                    </div>
                    <div class="stat-box retard">
                        <div class="number">2</div>
                        <div class="label">Retard</div>
                    </div>
                    <div class="stat-box absent">
                        <div class="number">1</div>
                        <div class="label">Absent</div>
                    </div>
                </div>
            </div>

            <div class="card repartition-card">
                <h3>
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                        </svg>
                    </div>
                    Répartition
                </h3>
                <div class="donut-chart">
                    <svg width="150" height="150" viewBox="0 0 150 150">
                        <circle cx="75" cy="75" r="60" stroke="#00c853" stroke-width="30" fill="transparent" stroke-dasharray="330 377" stroke-dashoffset="0" />
                        <circle cx="75" cy="75" r="60" stroke="#ffa000" stroke-width="30" fill="transparent" stroke-dasharray="25 377" stroke-dashoffset="-330" />
                        <circle cx="75" cy="75" r="60" stroke="#f44336" stroke-width="30" fill="transparent" stroke-dasharray="22 377" stroke-dashoffset="-355" />
                        <circle cx="75" cy="75" r="45" fill="white" />
                    </svg>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color present"></div>
                        <span>Présents</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color retard"></div>
                        <span>Retards</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color absent"></div>
                        <span>Absents</span>
                    </div>
                </div>
            </div>

            <div class="card qr-card">
                <h3 class="qr-title">Scanner pour la présence</h3>
                <img src="/api/placeholder/150/150" alt="QR Code" class="qr-code">
                <div class="qr-text">Code de présence personnel</div>
                <div class="qr-id">DW25041</div>
            </div>
            
            <a href="index.php?route=creerLogin">
                <div class="dashboard-title">
                    Changer de password
                </div>
            </a>
        </div>
        <?php
        $qrData = sprintf(
            "%s %s %s %s ",
            'were',
            'ert',
            'wer',
            'wer',
            // $apprenant['nom'] ?? '',
            // $apprenant['prenom'] ?? '',
            // $apprenant['email'] ?? '',
            // $apprenant['telephone'] ?? '',
        );
        // Générer l'URL du QR code
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($qrData) . "&size=200x200";
        ?>
        <div class="qr-code">
            <img src="<?= $qrCodeUrl ?>" alt="QR Code">
        </div>
    </main>
</body>
</html>