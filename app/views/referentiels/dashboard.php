<?php
// require_once "../../../app/enums/enum.link.php";
// use App\Enums\Includes;
// require_once __DIR__ . Includes::ASIDE->value;
// require_once __DIR__ . Includes::HEADER->value;
// require_once __DIR__ . Includes::ASIDE->value;


require_once __DIR__ . '/../daguite/aside.php';
require_once __DIR__ . '/../daguite/header.php';
require_once __DIR__ . '/../daguite/nouveaupromo.php';
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
          <div class="content-container view-list">
            <div class="content-header">
              <div class="">
                <h1>Référentiel</h1>
                <p>Gérer les référentiels de la promotion.</p>
              </div>
            </div>
            <form action="index.php?route=referentiels" method="post">
              <div class="contents-cards-bar referentiel">

                <div class="search-box">
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <g class="search-outline">
                        <g fill="" fill-rule="evenodd" class="Vector" clip-rule="evenodd" >
                          <path d="M11 17a6 6 0 1 0 0-12a6 6 0 0 0 0 12m0 2a8 8 0 1 0 0-16a8 8 0 0 0 0 16"/>
                          <path d="M15.32 15.29a1 1 0 0 1 1.414.005l3.975 4a1 1 0 0 1-1.418 1.41l-3.975-4a1 1 0 0 1 .004-1.414Z"/>
                        </g>  
                      </g>
                    </svg>
                  </span>
                  <input type="search" name="search" value="" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>"  />
                </div>

              <div class="all-ref-btn">

                <button type="submit" style="background: none;  padding: 0; cursor: pointer;">
                  <a>
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
                    Tous les referentiels
                    <input style="display: none;" type ="text" name="allref"/>
                  </a>
                </button>
              </div>
            </form>

            
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
                
                Creer referentiels
              
              </label>


              <!-- Ton bouton -->
              <a href="index.php?route=assigner_ref">

              <label 
                  style="background-color: rgb(25, 0, 255); color: white; padding: 10px; display: inline-block; cursor: pointer;  height: 48px;" 
                  class="add-promo-btn" 
                  onclick="ouvrirFormulaire()">
                  => Assigner référentiels
              </label>
              </a>


              <form action="" method="post">
                <label for="modal-toggle" class="add-promo-btn" style="display: block; width: 100%; padding: 0;  height: 40px; ">
                  <button type="submit" style="font-size: 20px; border-radius: 10px; color: white; width: 100%; height: 120%; border: none; cursor: pointer; background-color:rgb(0, 0, 0);">
                  Telecharger liste
                  </button>
                </label>
              </form>
            </div>

            <!-- Liste des référentiels -->
            <div class="referentiel-grid">
            <?php if (!empty($referentiels)) : ?>
              <?php foreach ($referentiels as $ref): ?>
                <div class="referentiel-card">
                  <img src="<?= $ref['image'] ?: '../assets/images/default-promo.jpg' ?>" alt="<?= htmlspecialchars($ref['nom']) ?>" class="referentiel-img">
                  <div class="card-body">
                    <h3 class="referentiel-title"><?= htmlspecialchars($ref['nom']) ?></h3>
                    <p class="referentiel-modules"><?= count($ref['modules']) ?> modules</p>
                    <p class="referentiel-desc">
                      <?= isset($ref['modules'][0]['description']) ? htmlspecialchars($ref['modules'][0]['description']) : 'Pas de description disponible.' ?>
                    </p>
                    <div class="referentiel-footer">
                      <span class="apprenants-count">👥 <?= htmlspecialchars($ref['capacite']) ?> apprenants</span>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else : echo 'Aucun referentielle trouve pour '?>

            <?php endif; ?>
              <!-- Card 1
              <div class="referentiel-card">
                <img src="../assets/images/img-ref-dev-web-mobile.jpg" alt="Développement web/mobile" class="referentiel-img">
                <div class="card-body">
                  <h3 class="referentiel-title">Développement web/mobile</h3>
                  <p class="referentiel-modules">1 modules</p>
                  <p class="referentiel-desc">De l’analyse du besoin à la mise en ligne, en passant par...</p>
                  <div class="referentiel-footer">
                    <span class="apprenants-count">👥 0 apprenants</span>
                  </div>
                </div>
              </div>
          
              Card 2
              <div class="referentiel-card">
                <img src="../assets/images/img-ref-dig.jpg" alt="Référent digital" class="referentiel-img">
                <div class="card-body">
                  <h3 class="referentiel-title">Référent digital</h3>
                  <p class="referentiel-modules">0 modules</p>
                  <p class="referentiel-desc">Couteau-suisse du numérique, le référent digital participe...</p>
                  <div class="referentiel-footer">
                    <span class="apprenants-count">👥 0 apprenants</span>
                  </div>
                </div>
              </div>
          
              Card 3
              <div class="referentiel-card">
                <img src="../assets/images/img-ref-dev-data.jpg" alt="Développement data" class="referentiel-img">
                <div class="card-body">
                  <h3 class="referentiel-title">Développement data</h3>
                  <p class="referentiel-modules">0 modules</p>
                  <p class="referentiel-desc">De l’analyse du besoin à la data visualisation, en passant par la...</p>
                  <div class="referentiel-footer">
                    <span class="apprenants-count">👥 0 apprenants</span>
                  </div>
                </div>
              </div>
          
              Card 4
              <div class="referentiel-card">
                <img src="../assets/images/img-ref-hackeuse.jpg" alt="Assistant Digital" class="referentiel-img">
                <div class="card-body">
                  <h3 class="referentiel-title">Assistant Digital (Hackeuse)</h3>
                  <p class="referentiel-modules">0 modules</p>
                  <p class="referentiel-desc">La formation d’assistante digitale réservée uniquement aux...</p>
                  <div class="referentiel-footer">
                    <span class="apprenants-count">👥 0 apprenants</span>
                  </div>
                </div>
              </div>
          
              Card 5
              <div class="referentiel-card">
                <img src="../assets/images/img-ref-aws-devops.jpg" alt="AWS & DevOps" class="referentiel-img">
                <div class="card-body">
                  <h3 class="referentiel-title">AWS & DevOps</h3>
                  <p class="referentiel-modules">0 modules</p>
                  <p class="referentiel-desc">De l’analyse des besoins au monitoring de l’infrastructure, e...</p>
                  <div class="referentiel-footer">
                    <span class="apprenants-count">👥 0 apprenants</span>
                  </div>
                </div>
              </div> -->

            </div>

          </div>
        </section>
      </main>
    </div>

    <!-- Checkbox pour ouvrir/fermer -->
    <input type="checkbox" id="modal-toggle" />

    <!-- Modal overlay -->
    <div class="modal">
      <div class="modal-content form-style">
        <div class="form-container">
            <h2>Ajouter referentiels</h2>
            <p class="description">
            Remplissez les informations ci-dessous pour créer une nouvelle
            promotion.
            </p>

            <!-- Bouton de fermeture -->
            <label for="modal-toggle" class="close-btn">✕</label>

            <h2>Ajouter une Promotion</h2>
        <?php if (!empty($errorMessage)): ?>
            <div class="error message">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>   

        <?php if (!empty($_SESSION['errors'])): ?>
            <div style="color:red" class="error message">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

            <form method="POST" action="index.php?route=ajouter_referentiels" enctype="multipart/form-data">
              <label for="image">l'image :</label>
              <input style="height: 100px; width:100px;" type="file" name="image" placeholder="img-promo-2025.jpg">

              <label for="nom">Non</label>
              <input type="text" name="nom" >

              <label for="description">Description</label>
              <textarea id="description" name="description" rows="5" cols="69 "></textarea>
              
              <div style="width: 100%; display: flex ; flexwrap: nowrap;">
                <label for="capacite" style="width: 60%;">Capacite</label>
                <label for="sessions">Nombre de session</label>
                
              </div>
              <input type="text" name="capacite" style="width: 45%;display: inline; padding-right: 150px;">
              <select style="height: 40px; width:50%; color:none; background: none;"  name="sessions" id="sessions">

                  <option name="sessions" id="sessions" value="Session1">Session 1</option>
                  <option name="sessions" id="sessions" value="Session2">Session 2</option>
                  <svg xmlns="http://www.w3.org/2000/svg" width="22.5" height="24" viewBox="0 0 15 16">
                      <path fill="" d="M6.5 13.02a5.5 5.5 0 0 1-3.89-1.61C1.57 10.37 1 8.99 1 7.52s.57-2.85 1.61-3.89c2.14-2.14 5.63-2.14 7.78 0C11.43 4.67 12 6.05 12 7.52s-.57 2.85-1.61 3.89a5.5 5.5 0 0 1-3.89 1.61m0-10c-1.15 0-2.3.44-3.18 1.32C2.47 5.19 2 6.32 2 7.52s.47 2.33 1.32 3.18a4.51 4.51 0 0 0 6.36 0C10.53 9.85 11 8.72 11 7.52s-.47-2.33-1.32-3.18A4.48 4.48 0 0 0 6.5 3.02"/>
                      <path fill="" d="M13.5 15a.47.47 0 0 1-.35-.15l-3.38-3.38c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.38 3.38c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z"/>
                  </svg>
              </select>

              <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                <button type="button" style="padding: 10px; background-color: gray; color: white; border: none; border-radius: 4px; font-size: 16px;">Annuler</button>
                <button type="submit" style="padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; font-size: 16px;">Créer</button>
              </div>
            </form>

        </div>
      </div>
    </div>


