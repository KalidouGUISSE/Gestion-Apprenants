<?php
    require_once __DIR__ . '/../daguite/aside.php';
    require_once __DIR__ . '/../daguite/header.php';
    require_once __DIR__ . '/../daguite/nouveaupromo.php';
//   require_once __DIR__ . '/../../models/model.php';
//   require_once __DIR__ . '/../../controllers/admin.controller.php';


    // Récupérer la pagination
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $totalPromotions = $total ?? 0;
    $totalPages = $pages ?? 1;

    // Construire les URL pour la pagination en préservant les filtres
    $queryParams = $_GET;
    unset($queryParams['page']); // Supprimer la page existante

    // Pour la page précédente
    $prevPage = max(1, $page - 1);
    $prevPageUrl = '?' . http_build_query(array_merge($queryParams, ['page' => $prevPage]));

    // Pour la page suivante
    $nextPage = min($totalPages, $page + 1);
    $nextPageUrl = '?' . http_build_query(array_merge($queryParams, ['page' => $nextPage]));
?>
<style>
.dropdown-container {
    position: relative;
    display: inline-block;
}

.dropdown-btn {
    background-color: black;
    height: 55px;

    color: white;
    padding: 10px 15px;
    cursor: pointer;
    border: none;
    font-weight: bold;
    border-radius: 5px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background: none;
    min-width: 160px;
    box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
    z-index: 1;
    border-radius: 5px;
    overflow: hidden;
}

.dropdown-content a {
    color: black;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    transition: background 0.3s;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown-container:hover .dropdown-content {
    display: block;

}
.importer{
    background-color: #0d947a;
}
</style>
<div class="dashboard-container">
    <!-- Sidebar -->
    <?= $sidebar ?>

    <main class="main-content">
        <!-- Header -->
        <?= $header ?>

        <section class="content view-list">
        <div class="content-container view-list">

            <div class="content-header">
                <div class="title">
                <h1>Apprenants</h1>
                <p><?= $nbApprenants ?? 0 ?> apprenant<?= ($nbApprenants ?? 0) !== 1 ? 's' : '' ?></p>
                </div>
            </div>
                
            <div class="promo-content-list-bar">
            <form method="GET" action="index.php">
                <input type="hidden" name="route" value="promotions" />

                <div class="search-filter-bar">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Rechercher par nom..." value="<?= htmlspecialchars($search) ?>" />
                </div>

                <select name="referentiel">
                    <option value="">Filtrer par classe</option>
                    <option value="dev_web_mobile" <?= $referentiel === 'Dev Web/Mobile' ? 'selected' : '' ?>>Dev Web/Mobile</option>
                    <option value="ref_dig" <?= $referentiel === 'Ref Dig' ? 'selected' : '' ?>>Ref Dig</option>
                    <option value="aws" <?= $referentiel === 'AWS' ? 'selected' : '' ?>>AWS</option>
                    <option value="dev_data" <?= $referentiel === 'Dev Data' ? 'selected' : '' ?>>Dev Data</option>
                    <option value="Hackeuse" <?= $referentiel === 'Hackeuse' ? 'selected' : '' ?>>Hackeuse</option>
                </select>

                <select name="statut">
                    <option value="">Filtrer par statut</option>
                    <option value="actif" <?= $statut === 'actif' ? 'selected' : '' ?>>Actif</option>
                    <option value="inactif" <?= $statut === 'inactif' ? 'selected' : '' ?>>Remplace</option>
                </select>

                <button style="width:150px; font-size:17px" type="submit" class="filter-btn">Filtrer</button>
                <!-- <a href="index.php?route=promotions" class="reset-btn">Réinitialiser</a> -->
                </div>
            </form>
            
            <div class="dropdown-container">
                <button class="dropdown-btn importer">Importer liste</button>
                <div class="dropdown-content">
                <form action="index.php?route=importerExcel" method="POST" enctype="multipart/form-data">
                    <input type="file" name="excel_file" accept=".xlsx,.xls" required>
                    <button class="dropdown-btn importer" type="submit">Importer</button>
                    <!-- <a href="index.php?route=importerExcel" style="color:green; background-color:rgb(255, 255, 255);"  >Excel</a> -->

                </form>

                </div>
            </div>
            <div class="dropdown-container">
                <button class="dropdown-btn">Télécharger la liste</button>
                <div class="dropdown-content">
                    <a href="index.php?route=telechargerExcel" style="color:green; background-color:rgb(255, 255, 255);"  >Excel</a>
                    <a href="index.php?route=telechargerPDF" style="color:red; background-color:rgb(255, 255, 255);">PDF</a>
                </div>
            </div>
            <label for="modal-toggle" class="add-promo-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
                <path fill="" d="M678.3 642.4c24.2-13 51.9-20.4 81.4-20.4h.1c3 0 4.4-3.6 2.2-5.6a371.7 371.7 0 0 0-103.7-65.8c-.4-.2-.8-.3-1.2-.5C719.2 505 759.6 431.7 759.6 349c0-137-110.8-248-247.5-248S264.7 212 264.7 349c0 82.7 40.4 156 102.6 201.1c-.4.2-.8.3-1.2.5c-44.7 18.9-84.8 46-119.3 80.6a373.4 373.4 0 0 0-80.4 119.5A373.6 373.6 0 0 0 137 888.8a8 8 0 0 0 8 8.2h59.9c4.3 0 7.9-3.5 8-7.8c2-77.2 32.9-149.5 87.6-204.3C357 628.2 432.2 597 512.2 597c56.7 0 111.1 15.7 158 45.1a8.1 8.1 0 0 0 8.1.3M512.2 521c-45.8 0-88.9-17.9-121.4-50.4A171.2 171.2 0 0 1 340.5 349c0-45.9 17.9-89.1 50.3-121.6S466.3 177 512.2 177s88.9 17.9 121.4 50.4A171.2 171.2 0 0 1 683.9 349c0 45.9-17.9 89.1-50.3 121.6C601.1 503.1 558 521 512.2 521M880 759h-84v-84c0-4.4-3.6-8-8-8h-56c-4.4 0-8 3.6-8 8v84h-84c-4.4 0-8 3.6-8 8v56c0 4.4 3.6 8 8 8h84v84c0 4.4 3.6 8 8 8h56c4.4 0 8-3.6 8-8v-84h84c4.4 0 8-3.6 8-8v-56c0-4.4-3.6-8-8-8" />
                </svg>
                Ajouter apprenant
            </label>
            </div>

            <div class="stat-cards-container view-list">
        
            </div>

            <!-- Table -->
            <div class="table-container" style="width: 90rem;">
            <table class="promo-table">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Matricule</th>
                    <th>NonComplet</th>
                    <th>Adresse</th>
                    <th>Telephone</th>
                    <th>Referentiel</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                        <?php
                        usort($promosPagines, function($a, $b) {
                            return ($a['statut'] === 'actif' ? -1 : 1);
                        });
                        ?>
                        <?php if (!empty($promosPagines)): ?>
                            <?php foreach ($promosPagines as $promotion): ?>
                            <tr>
                                <td>
                                    <img src="<?= $promotion['image'] ?: '../assets/images/default-promo.jpg' ?>" class="promo-img" alt="Promo">
                                </td>
                                <td><?= htmlspecialchars($promotion['matricule'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($promotion['prenom'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($promotion['adresse'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($promotion['telephone'] ?? '-') ?>
                                </td>
                                <td>
                                    <?php
                                        $statut = strtolower($promotion['statut'] ?? 'inactif');
                                        $statutClass = $statut === 'actif' ? 'active' : 'inactive';
                                    ?>
                                    <span class="status <?= $statutClass ?>">
                                        <?= ucfirst($statut) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($promotion['Statut'] ?? 'N/A') ?></td>

                                <td>
                                    <div class="action-dropdown">
                                        <span class="action">⋯</span>
                                        <div class="dropdown-content">
                                        <!-- <a href="index.php?route=edit_promotion&id=<?= $promotion['idnom'] ?? '' ?>">Modifier</a> -->
                                        <!-- <a href="index.php?route=changer_statut&action=<?= $statut === 'actif' ? 'desactiver' : 'activer' ?>&promo=<?= $promotion['idnom'] ?? '' ?>">
                                            <?= $statut === 'actif' ? 'Désactiver' : 'Activer' ?>
                                        </a> -->
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                    <tr>
                    <td colspan="7">Aucune promotion trouvée.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                <div class="page-info">
                Page <?= $page ?> sur <?= $totalPages ?> (<?= $totalPromotions ?> promotions)
                </div>
                <div class="page-nav">
                <?php if ($page > 1): ?>
                    <a class="page-btn" href="<?= $prevPageUrl ?>"><</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php
                    $pageUrl = '?' . http_build_query(array_merge($queryParams, ['page' => $i]));
                    ?>
                    <a class="page-btn <?= $i === $page ? 'active' : '' ?>" href="<?= $pageUrl ?>"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $totalPages): ?>
                    <a class="page-btn" href="<?= $nextPageUrl ?>">></a>
                <?php endif; ?>
                </div>
            </div>
            </div>
        </div>
        </section>
    </main>
</div>

<?= $nouveaupromo ?>