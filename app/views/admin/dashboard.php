<?php
  require_once __DIR__ . '/../daguite/aside.php';
  require_once __DIR__ . '/../daguite/header.php';
  require_once __DIR__ . '/../daguite/nouveaupromo.php';
  require_once __DIR__ . '/../../models/model.php';
  use function App\Models\getStatistiques;

  $stats = getStatistiques(__DIR__ . '/../../../data/data.json');

  // Nombre d'éléments par page
  $parPage = 6;

  // Page actuelle (par défaut 1 si non spécifiée)
  $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;

  // Récupérer la valeur sélectionnée
  $filterType = $_GET['filter'] ?? ''; // 'filter' correspond au nom de la <select>

  // Récupérer la recherche si applicable
  $search = $_GET['search'] ?? '';

  // Filtrer les promotions en fonction de la sélection
  $filteredPromotions = array_filter($promotions, function ($promotion) use ($filterType, $search) {
      if ($filterType === 'Nom') {
          // Filtrer par nom
          return stripos($promotion['idnom'], $search) !== false;
      } elseif ($filterType === 'Referentiel') {
          // Filtrer par référentiel
          return in_array(strtolower($search), array_map('strtolower', array_column($promotion['referentiels'], 'nom')));
      }
      // Si "Tous" est sélectionné ou aucun filtre, retourner toutes les promotions
      return true;
  });

  // Mettre à jour les données paginées
  $totalPromotions = count($filteredPromotions);
  $totalPages = ceil($totalPromotions / $parPage);
  $offset = ($page - 1) * $parPage;
  $promosPagines = array_slice($filteredPromotions, $offset, $parPage);

  $queryParams = $_GET;
  $queryParams['page'] = $page - 1;
  $prevPageUrl = '?' . http_build_query($queryParams);

  $queryParams['page'] = $page + 1;
  $nextPageUrl = '?' . http_build_query($queryParams);
?>

  <div class="dashboard-container">
    <!-- Sidebar -->
    <?= $sidebar ?>

    <!-- Contenu principal -->
    <main class="main-content">
      <!-- Header -->
      <?= $header ?>

      <!-- Section de contenu -->
      <section class="content">
        <div class="content-container view-grid">
          <div class="content-header">
            <div class="">
              <h1>Promotion</h1>
              <p>Gérer les promotions de l'école.</p>
            </div>
            <input type="checkbox" id="modal-toggle" class="modal-toggle" <?= isset($_SESSION['modal_open']) ? 'checked' : '' ?>>
            <?php unset($_SESSION['modal_open']); ?>

            <?= $nouveaupromo ?>
            <label for="modal-toggle" class="add-promo-btn">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
              >
                <path
                  fill=""
                  d="M13 6a1 1 0 1 0-2 0v5H6a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
                />
              </svg>
              Ajouter une promotion
            </label>
          </div>

          <div class="stat-cards-container">
            <div class="stat-card">
            <div class="stat-info">
                <h1><?= $stats['totalApprenants'] ?></h1>
                <p>Apprenants</p>
            </div>
              <div class="stat-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M10 4a4 4 0 1 0 0 8a4 4 0 0 0 0-8M4 8a6 6 0 1 1 12 0A6 6 0 0 1 4 8m12.828-4.243a1 1 0 0 1 1.415 0a6 6 0 0 1 0 8.486a1 1 0 1 1-1.415-1.415a4 4 0 0 0 0-5.656a1 1 0 0 1 0-1.415m.702 13a1 1 0 0 1 1.212-.727c1.328.332 2.169 1.18 2.652 2.148c.468.935.606 1.98.606 2.822a1 1 0 1 1-2 0c0-.657-.112-1.363-.394-1.928c-.267-.533-.677-.934-1.349-1.102a1 1 0 0 1-.727-1.212zM6.5 18C5.24 18 4 19.213 4 21a1 1 0 1 1-2 0c0-2.632 1.893-5 4.5-5h7c2.607 0 4.5 2.368 4.5 5a1 1 0 1 1-2 0c0-1.787-1.24-3-2.5-3z"
                  />
                </svg>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-info">
                <h1>5</h1>
                <p>Référentiels</p>
              </div>
              <div class="stat-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M3 18.5V5a3 3 0 0 1 3-3h14a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A3.5 3.5 0 0 1 3 18.5M19 20v-3H6.5a1.5 1.5 0 0 0 0 3zM5 15.337A3.5 3.5 0 0 1 6.5 15H19V4H6a1 1 0 0 0-1 1z"
                  />
                </svg>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-info">
                <h1>1</h1>
                <p>Promotions actives</p>
              </div>
              <div class="stat-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill=""
                    d="M9 16.2L4.8 12l-1.4 1.4L9 19L21 7l-1.4-1.4z"
                  />
                </svg>
              </div>
            </div>

            <div class="stat-card">
      
            <div class="stat-info">
                <h1><?= $stats['totalPromotions'] ?></h1>
                <p>Total promotions</p>
            </div>
              <div class="stat-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 16 16"
                >
                  <path
                    fill=""
                    d="M0 2.75C0 1.784.784 1 1.75 1H5c.55 0 1.07.26 1.4.7l.9 1.2a.25.25 0 0 0 .2.1h6.75c.966 0 1.75.784 1.75 1.75v8.5A1.75 1.75 0 0 1 14.25 15H1.75A1.75 1.75 0 0 1 0 13.25Zm1.75-.25a.25.25 0 0 0-.25.25v10.5c0 .138.112.25.25.25h12.5a.25.25 0 0 0 .25-.25v-8.5a.25.25 0 0 0-.25-.25H7.5c-.55 0-1.07-.26-1.4-.7l-.9-1.2a.25.25 0 0 0-.2-.1Z"
                  />
                </svg>
              </div>
            </div>
          </div>

          <div class="contents-cards-bar">
            <div class="search-box">
              <span>
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                >
                  <g class="search-outline">
                    <g
                      fill=""
                      fill-rule="evenodd"
                      class="Vector"
                      clip-rule="evenodd"
                    >
                      <path
                        d="M11 17a6 6 0 1 0 0-12a6 6 0 0 0 0 12m0 2a8 8 0 1 0 0-16a8 8 0 0 0 0 16"
                      />
                      <path
                        d="M15.32 15.29a1 1 0 0 1 1.414.005l3.975 4a1 1 0 0 1-1.418 1.41l-3.975-4a1 1 0 0 1 .004-1.414Z"
                      />
                    </g>
                  </g>
                </svg>
              </span>
              <input type="text" placeholder="Rechercher..." />
            </div>
            <div class="select-box">
              <select name="filter">
                <option value="">Tous</option>
                <option value="Nom">Nom</option>
                <option value="Referentiel">Referentiel</option>
              </select>
            </div>
            <div class="option-view-box">
              <div class="view grill active">
                <a href="#">Grille</a>
              </div>
              <div class="view list">
                <!-- <a href="index.php?route=liste-promotions">Liste</a> -->
                <a href="index.php?route=promotions">Liste</a>
              </div>
            </div>
          </div>
          <?php
            usort($promosPagines, function($a, $b) {
                return ($a['statut'] === 'actif' ? -1 : 1);
            });
          ?>
          <div class="promotions-cards-container">
            <?php foreach ($promosPagines as $promotion): ?>
              <div class="promo-card">
                <div class="promo-header">
                  <div class="status">
                    <?php if ($promotion['statut'] === 'actif'): ?>
                      <a href="#"style="color:black;" class="status-icon status-text text-green-800 font-semibold">
                        <?= ucfirst($promotion['statut']) ?>
                      </a>
                    <?php else: ?>
                      <span class="status-text text-gray-600">
                        <?= ucfirst($promotion['statut']) ?>
                      </span>
                    <?php endif; ?>
                    <form action="index.php?route=changer_statut" method="POST">
                        <?php if ($promotion['statut'] === 'inactif'): ?>
                            <input type="hidden" name="action" value="activer">
                            <input type="hidden" name="promo" value="<?= $promotion['idnom'] ?>">
                            <a href="" class="status-icon">
                            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        fill="#4CAF50"
                                        d="M8.205 4.843a1 1 0 0 1 .844 1.813A6.997 6.997 0 0 0 12 20a6.998 6.998 0 0 0 2.965-13.337a1 1 0 0 1 .848-1.811A9 9 0 0 1 21 13.003C21 17.972 16.97 22 12 22s-9-4.028-9-8.997a9 9 0 0 1 5.205-8.16M12 2a1 1 0 0 1 .993.883L13 3v7a1 1 0 0 1-1.993.117L11 10V3a1 1 0 0 1 1-1"
                                    />
                                </svg>
                            </button></a>
                        <?php endif; ?>
                    </form>

                  </div>
                </div>
                <div class="promo-body">
                  <img src="<?= $promotion['image'] ?>" class="promo-img" alt="Promo <?= $promotion['idnom'] ?>">
                  <div class="promo-info">
                    <h3 class="promo-title"><?= $promotion['idnom'] ?></h3>
                    <p class="promo-dates"><?= $promotion['debutAnnee'] ?> - <?= $promotion['finAnnnee'] ?></p>
                  </div>
                  <div class="promo-stats">
                    <span><?= count($promotion['apprenants']) ?> apprenant<?= count($promotion['apprenants']) > 1 ? 's' : '' ?></span>
                  </div>
                </div>
                <div class="promo-footer">
                  <a href="#" class="promo-link">Voir détails</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="pagination">
            <div class="page-info">
              Page <?= $page ?> sur <?= $totalPages ?> (<?= $totalPromotions ?> promotions)
            </div>
            <div class="page-nav">
              <?php if ($page > 1): ?>
                <?php $queryParams['page'] = $page - 1; ?>
                <a class="page-btn" href="?<?= http_build_query($queryParams) ?>"><</a>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php $queryParams['page'] = $i; ?>
                <a class="page-btn <?= $i === $page ? 'active' : '' ?>" href="?<?= http_build_query($queryParams) ?>"><?= $i ?></a>
              <?php endfor; ?>
              <?php if ($page < $totalPages): ?>
                <?php $queryParams['page'] = $page + 1; ?>
                <a class="page-btn" href="?<?= http_build_query($queryParams) ?>">></a>
              <?php endif; ?>
            </div>
          </div>

          </div>
        </div>
      </section>
    </main>
  </div>
  <!-- Checkbox pour ouvrir/fermer -->
  <input type="checkbox" id="modal-toggle" />

    <!-- Modal overlay -->
