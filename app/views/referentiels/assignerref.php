<?php

require_once __DIR__ . '/../daguite/aside.php';
require_once __DIR__ . '/../daguite/header.php';
require_once __DIR__ . '/../daguite/nouveaupromo.php';
?>
  
  <div class="dashboard-container">
    <?= $sidebar ?>
      <main class="main-content">
        <?= $header ?>
        <h1>Affecter des Référentiels à une Promotion</h1>
      
      <style>
          * {
              box-sizing: border-box;
              margin: 0;
              padding: 0;
              font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          }

          body {
              background-color: #f5f5f5;
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
          }

          .modal {
              background-color: white;
              width: 550px;
              border-radius: 8px;
              box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
              padding: 20px;
              position: relative;
          }

          .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
          }

          .modal-title {
              font-size: 22px;
              font-weight: 600;
              color: #333;
          }

          .close-btn {
              font-size: 24px;
              cursor: pointer;
              color: #999;
              background: none;
              border: none;
          }

          .form-group {
              margin-bottom: 20px;
          }

          .form-label {
              display: block;
              font-size: 16px;
              color: #444;
              margin-bottom: 8px;
          }

          .form-input {
              width: 100%;
              padding: 12px 15px;
              border: 1px solid #ddd;
              border-radius: 6px;
              font-size: 16px;
              background-color: #f8f8f8;
          }

          .tags-container {
              border: 1px dashed #ccc;
              border-radius: 6px;
              padding: 15px;
              margin-top: 10px;
              min-height: 60px;
              display: flex;
              flex-wrap: wrap;
              gap: 10px;
          }

          .tag {
              display: inline-flex;
              align-items: center;
              padding: 6px 12px;
              border-radius: 4px;
              font-size: 14px;
              font-weight: 500;
              color: white;
              margin-right: 5px;
          }

          .tag-close {
              margin-left: 8px;
              cursor: pointer;
              font-weight: bold;
          }

          .tag-web {
              background-color: #4CAF50;
          }

          .tag-dig {
              background-color: #2196F3;
          }

          .tag-data {
              background-color: #9C27B0;
          }

          .tag-aws {
              background-color: #FF9800;
          }

          .tag-hack {
              background-color: #E91E63;
          }
          .defaut{
            background-color: #ccc;
          }

          .submit-btn {
              background-color: #0d947a;
              color: white;
              border: none;
              padding: 12px 24px;
              border-radius: 6px;
              font-size: 16px;
              cursor: pointer;
              float: right;
              transition: background-color 0.3s;
          }

          .submit-btn:hover {
              background-color: #0a7d67;
          }
          .affecter{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
          }
          .container{
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
          }

          .tag-close input[type="checkbox"] {
              display: none; /* Cache la case par défaut */
            }
            .custom-check {
              display: inline-block;
              cursor: pointer;
              color: red;
              font-weight: bold;
              margin-left: 5px;
            }

            input[type="checkbox"]:checked + .custom-check {
              color: #fff; /* Change la couleur si coché */
            }
            input[type="checkbox"] {
              display: none;
            }

      </style>
      <div class="affecter">

        <div class="container">
        <div class="modal-header">
            <h2 class="modal-title">Ajouter une référentiel</h2>
            <button class="close-btn">×</button>
        </div>

        <form action="index.php?route=modifier_promo" method="POST">
            <div class="form-group">
              <label class="form-label">Libellé référentiel</label>
              <input type="text" class="form-input" list="referentiels" name="a_affecter" value="">
              
              <datalist id="referentiels">
                <?php foreach ($referentielsNonAffecte as $keys => $referentiel) : ?>
                  <option value=<?= htmlspecialchars($referentiel['nom']) ?>>
                  <!-- <option value="Développement Web">
                  <option value="Big Data & IA">
                  <option value="DevOps">
                  <option value="Sécurité Réseaux"> -->
                <?php endforeach  ?>
              </datalist>
            </div>
            
            <div class="form-group">
                <label class="form-label">Promotion active</label>
                <div class="tags-container">
                <?php foreach ($referentielsEncour as $keys => $referentiel) : ?>
                  <span 
                  <?php
                      $refName = strtolower($referentiel['nom']);
                      $badgeClass = match ($refName) {
                        'aws' => 'tag-aws',
                        'dev_web_mobile' => 'tag-web',
                        'ref_dig' => 'tag-dig',
                        'dev_data' => 'tag-data',
                        'hackeuse' => 'tag-hack',
                        default => 'defaut',
                      };
                    ?>
                  
                  class="tag <?= $badgeClass ?>">
                    <?= htmlspecialchars($referentiel['nom'])?>
                    <label class="tag-close">
                      <input type="checkbox" name="a_desaffecter[]" value="<?= htmlspecialchars($referentiel['nom']) ?>" checked>
                      <span class="custom-check">×</span>
                    </label>
                  </span>
                <?php endforeach  ?>

                    <span class="tag tag-dig">REF DIG <span class="tag-close"><input  type="checkbox"value="<?= htmlspecialchars($referentiel['nom'])?>" checked></span></span>
                    <span class="tag tag-data">DEV DATA <span class="tag-close"><input  type="checkbox" value="<?= htmlspecialchars($referentiel['nom'])?>"checked></span></span>
                    <span class="tag tag-aws">AWS <span class="tag-close"><input  type="checkbox"  value="<?= htmlspecialchars($referentiel['nom'])?>" checked></span></span>
                    <span class="tag tag-hack">HACKEUSE <span class="tag-close"><input  type="checkbox" value="" checked></span></span>
                </div>
            </div>
            
            <button type="submit" class="submit-btn">Terminer</button>
        </form>
        
        </div>
      </main>
  </div>







<!-- 
    <form action="index.php?route=modifier_promo" method="POST">
        <h1>Affecter des Référentiels à une Promotion</h1>

        <div>
          <label  for="promotion">Sélectionner les Référentiels :</label><br>
            <div class="referentiels">
                <?php foreach ($referentielsNonAffecte as $keys => $referentiel) : ?>
                  <input type="checkbox" name= "nom" value=<?= htmlspecialchars($referentiel['nom']) ?> >
                  <label><?= ($referentiel['nom'])?></label>
                <?php endforeach  ?>
            </div>
        </div>

        <div>
            <label>Promotion en cours :</label>
            <div class="referentiels">
                <?php foreach ($referentielsEncour as $referentiel) : ?>

                  <input  type="checkbox" name="nom" value="<?= htmlspecialchars($referentiel['nom'])?>">
                  <label><?= ($referentiel['nom'])?></label>
                <?php endforeach  ?>
            </div>
        </div><br>
        <button type="submit" style="height: 50px; width:100px;"> Terminer </button>
    </form> -->

                    <?php
                      $refName = strtolower($referentiel['nom']);
                      $badgeClass = match ($refName) {
                        'aws' => 'tag-aws',
                        'dev_web_mobile' => 'green',
                        'ref_dig' => 'tag-dig',
                        'dev_data' => 'tag-data',
                        'hackeuse' => 'tag-hack',
                        default => 'gray',
                      };
                    ?>
                  
                  class="tag <?= $badgeClass ?>">