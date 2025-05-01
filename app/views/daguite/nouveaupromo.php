<?php
ob_start();
?>

<div class="modal">
    <div class="modal-content form-style">
    <div class="form-container">
        <h2>Créer une nouvelle promotion</h2>
        <p class="description">
        Remplissez les informations ci-dessous pour créer une nouvelle promotion.
        </p>

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

        <!-- Bouton de fermeture -->
        <label for="modal-toggle" class="close-btn">✕</label>

        <form method="POST" action="index.php?route=ajouter_promotion" enctype="multipart/form-data">
            <div class="form-group">
                <label for="idnom">Nom de la promotion</label>
                <input type="text" name="idnom" id="nom" placeholder="Ex: Promotion 2025"
                value="<?= htmlspecialchars($_SESSION['old']['idnom'] ?? '') ?>" />
                <!-- <span class="error-input">Le champ nom est requis</span> -->
            </div>

            <div class="date-group" style="display: flex; gap: 1rem">
                <div style="flex: 1">
                    <label for="debutAnnee">Date de début</label>
                    <div class="input-box">
                        <input type="text" name="debutAnnee" id="debutAnnee" placeholder="jj/mm/aaaa"
                            value="<?= htmlspecialchars($_SESSION['old']['debutAnnee'] ?? '') ?>" />
                        <!-- Icone calendrier -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="" d="M8 14q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m4 0q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m4 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5z"/>
                        </svg>
                    </div>
                    <!-- <span class="error-input">Le champ date est requis</span> -->
                </div>
                <div style="flex: 1">
                    <label for="finAnnnee">Date de fin</label>
                    <div class="input-box">
                        <input type="text" name="finAnnnee" id="finAnnnee" placeholder="jj/mm/aaaa"
                            value="<?= htmlspecialchars($_SESSION['old']['finAnnnee'] ?? '') ?>" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="" d="M8 14q-.425 0-.712-.288T7 13t.288-.712T8 12t.713.288T9 13t-.288.713T8 14m4 0q-.425 0-.712-.288T11 13t.288-.712T12 12t.713.288T13 13t-.288.713T12 14m4 0q-.425 0-.712-.288T15 13t.288-.712T16 12t.713.288T17 13t-.288.713T16 14M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v14q0 .825-.587 1.413T19 22zm0-2h14V10H5z"/>
                        </svg>
                    </div>
                    <!-- <span class="error-input">Le champ date est requis</span> -->
                </div>
            </div>

            <div class="form-group">
                <label for="image">Photo de la promotion</label>
                <div class="input-box">
                    <div class="upload-box">
                        <span><strong>Ajouter</strong> ou glisser</span>
                        <input type="file" id="image" name="image" accept="image/png, image/jpeg" />
                    </div>
                    <span>Format JPG, PNG. Taille max 2MB</span>
                </div>
                <!-- <span class="error-input">Le champ photo est requis</span> -->
            </div>

            <div class="form-group">
                <label for="referentiel_nom">Référentiels</label>
                <div class="search-referentiel">
                
                    <select style="height: 40px; width:100%; border:none; color:none;"  name="referentiel_nom" id="referentiel_nom">
                        <option value="">-- référentiel --</option>
                        <option value="dev_web_mobile">DEV WEB/MOBILE</option>
                        <option value="ref_dig">REF DIG</option>
                        <option value="dev_data">DEV DATA</option>
                        <option value="aws">AWS</option>
                        <option value="hackeuse">HACKEUSE</option>
                        <svg xmlns="http://www.w3.org/2000/svg" width="22.5" height="24" viewBox="0 0 15 16">
                            <path fill="" d="M6.5 13.02a5.5 5.5 0 0 1-3.89-1.61C1.57 10.37 1 8.99 1 7.52s.57-2.85 1.61-3.89c2.14-2.14 5.63-2.14 7.78 0C11.43 4.67 12 6.05 12 7.52s-.57 2.85-1.61 3.89a5.5 5.5 0 0 1-3.89 1.61m0-10c-1.15 0-2.3.44-3.18 1.32C2.47 5.19 2 6.32 2 7.52s.47 2.33 1.32 3.18a4.51 4.51 0 0 0 6.36 0C10.53 9.85 11 8.72 11 7.52s-.47-2.33-1.32-3.18A4.48 4.48 0 0 0 6.5 3.02"/>
                            <path fill="" d="M13.5 15a.47.47 0 0 1-.35-.15l-3.38-3.38c-.2-.2-.2-.51 0-.71s.51-.2.71 0l3.38 3.38c.2.2.2.51 0 .71c-.1.1-.23.15-.35.15Z"/>
                        </svg>
                    </select>
                    <!-- <input type="text" name="referentiel_nom" id="referentiel_nom" placeholder="Rechercher un référentiel..." value="<?= htmlspecialchars($_SESSION['old']['referentiel_nom'] ?? '') ?>" /> -->
                </div>
                <span class="error-input"></span>
            </div>

            <div class="actions">
                <label for="modal-toggle" class="cancel">Annuler</label>
                <button type="submit" class="submit">Créer la promotion</button>
            </div>
        </form>
    </div>
    </div>
</div>

<?php
$nouveaupromo = ob_get_clean();
unset($_SESSION['old']);
?>
