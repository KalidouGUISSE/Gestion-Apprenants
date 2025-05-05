
<?php
    require_once __DIR__ . '/../daguite/aside.php';
    require_once __DIR__ . '/../daguite/header.php';
?>

<style>
    * {
        box-sizing: border-box;
    }

    .apprenant-container {
        width: 100%;
        max-width: 1100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 0 auto;
        overflow: hidden;
    }

    .apprenant-titre {
        color: #2a9d8f;
        text-align: center;
        margin-bottom: 30px;
        font-size: 28px;
    }

    .section {
        margin-bottom: 30px;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 20px;
        overflow: hidden;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        color: #264653;
        font-size: 20px;
        font-weight: bold;
        margin-right: 10px;
    }

    .edit-icon {
        width: 20px;
        height: 20px;
        color: #999;
        cursor: pointer;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group {
        flex: 1 1 300px;
        min-width: 250px;
    }

    .apprenant-container label {
        display: block;
        font-size: 14px;
        color: #666;
        margin-bottom: 5px;
    }

    .apprenant-container input, 
    .apprenant-container select {
        width: 95%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        font-size: 14px;
        margin-bottom: 10px;

    }

    .date-picker {
        position: relative;
    }
    .upload-section {
        border: 2px dashed #2a9d8f;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 250px;
        height: 125px;
        margin-top: 10px;
    }

    .upload-icon {
        color: #2a9d8f;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .file-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
        text-align: center;
    }

    .file-upload input[type=file] {
        position: absolute;
        font-size: 100px;
        opacity: 0;
        right: 0;
        top: 0;
        cursor: pointer;
    }

    .upload-btn {
        background-color: white;
        color: #2a9d8f;
        border: 1px solid #2a9d8f;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 12px;
        cursor: pointer;
        display: inline-block;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        border: none;
    }

    .btn-cancel {
        background-color: white;
        border: 1px solid #ccc;
        color: #333;
    }

    .btn-submit {
        background-color: #2a9d8f;
        color: white;
    }

</style>
<div class="apprenant-container">
    <!-- Sidebar -->
    <?= $sidebar ?>
    <h1 class="apprenant-titre">Ajout apprenant</h1>
    <!-- Header -->
    <form id="form-apprenant" action="index.php?route=ajout_apprenant" method="post" enctype="multipart/form-data">


        
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Informations de l'apprenant</h2>
                <svg class="edit-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="prenom"><p style="color:red"><?= $_SESSION['errors']['prenom']?></p></label>
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom de l'apprenant" value="<?= htmlspecialchars($_SESSION['old']['prenom'] ?? '') ?>" >
                </div>
                <div class="form-group">
                    <label for="nom"><p style="color:red"><?= htmlspecialchars($_SESSION['errors']['nom']) ?></p></label>
                    <input type="text" id="nom" name="nom" placeholder="Nom de l'apprenant" value="<?= htmlspecialchars($_SESSION['old']['nom'] ?? '') ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="date-naissance">Date de naissance</label>
                    <div class="date-picker">
                        <input type="text" id="date-naissance" name="date_naissance" placeholder="Date de naissance" value="<?= htmlspecialchars($_SESSION['old']['date_naissance'] ?? '') ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="lieu-naissance">Lieu de naissance</label>
                    <input type="text" id="lieu-naissance" name="lieu_naissance" placeholder="Lieu de naissance" value="<?= htmlspecialchars($_SESSION['old']['lieu_naissance'] ?? '') ?>" >
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="adresse"><p style="color:red"><?= $_SESSION['errors']['adresse']?></p></label>
                    <input type="text" id="adresse" name="adresse" placeholder="Adresse complète" value="<?= htmlspecialchars($_SESSION['old']['adresse'] ?? '') ?>" >
                </div>
                <div class="form-group">
                    <label for="email"><p style="color:red"><?= $_SESSION['errors']['email']?></p></label>
                    <input type="email" id="email" name="email" placeholder="Email de l'apprenant" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" >
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="telephone"><p style="color:red"><?= $_SESSION['errors']['telephone']?></p></label>
                    <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone" value="<?= htmlspecialchars($_SESSION['old']['telephone'] ?? '') ?>" >
                </div>
                <div class="form-group">
                    <div class="upload-section">
                        <div class="upload-icon">📄</div>
                        <div class="file-upload">
                            <input type="file" name="documents[]" multiple>
                            <span class="upload-btn">Ajouter des document</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Informations du tuteur</h2>
                <svg class="edit-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="nom_tuteur">Prénom(s) & nom</label>
                    <input type="text" id="nom_tuteur" name="nom_tuteur" placeholder="Prénom et nom du tuteur" value="<?= htmlspecialchars($_SESSION['old']['nom_tuteur'] ?? '') ?>" >
                </div>
                <div class="form-group">
                    <label for="lien_parente">Lien de parenté</label>
                    <input type="text" id="lien_parente" name="lien_parente" placeholder="Lien de parenté" value="<?= htmlspecialchars($_SESSION['old']['lien_parente'] ?? '') ?>" >
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="adresse_tuteur"></label>
                    <input type="text" id="adresse_tuteur" name="adresse_tuteur" placeholder="Adresse du tuteur" value="<?= htmlspecialchars($_SESSION['old']['adresse_tuteur'] ?? '') ?>" >
                </div>
                <div class="form-group">
                    <label for="telephone-tuteur"><p style="color:red"></p></label>
                    <input type="tel" id="telephone-tuteur" name="telephone_tuteur" placeholder="Téléphone du tuteur" value="<?= htmlspecialchars($_SESSION['old']['telephone_tuteur'] ?? '') ?>" >
                </div>
            </div>
        </div>
        
        <div class="actions">
            <a href="index.php?route=apprenants_attente" class="btn btn-cancel">Annuler</a>
            <button type="submit" class="btn btn-submit">Enregistrer</button>
        </div>
    </form>
</div>

<?php empty($_SESSION['errors']) ?>