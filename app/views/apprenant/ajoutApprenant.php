
<?php
    require_once __DIR__ . '/../daguite/aside.php';
    require_once __DIR__ . '/../daguite/header.php';
    require_once __DIR__ . '/../daguite/nouveaupromo.php';
?>

<style>
    /* Styles pour le formulaire d'ajout d'apprenant */
    .apprenant-container {
        width: 100%;
        max-width: 1100px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 0 auto;
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
        margin: 0 -10px;
    }
    
    .form-group {
        flex: 1 0 40%;
        margin-bottom: 15px;
        padding: 0 10px;
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
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        font-size: 14px;
    }
    
    .date-picker {
        position: relative;
    }
    
    .calendar-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #f8a100;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        cursor: pointer;
    }
    
    .upload-section {
        border: 2px dashed #2a9d8f;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 200px;
        height: 120px;
        margin-left: auto;
    }
    
    .upload-icon {
        color: #2a9d8f;
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .upload-btn {
        background-color: white;
        color: #2a9d8f;
        border: 1px solid #2a9d8f;
        border-radius: 20px;
        padding: 8px 15px;
        font-size: 12px;
        cursor: pointer;
    }
    
    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
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
<div class="dashboard-container">
    <!-- Sidebar -->
    <?= $sidebar ?>

    <main class="main-content">
        <!-- Header -->
        <?= $header ?>
        <div class="apprenant-container">
        <h1 class="apprenant-titre">Ajout apprenant</h1>
        
        <div class="section">
            <div class="section-header">
                <h2 class="section-title">Informations de l'apprenant</h2>
                <svg class="edit-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="prenom">Prénom(s)</label>
                    <input type="text" id="prenom" name="prenom" placeholder="Prénom de l'apprenant">
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" placeholder="Nom de l'apprenant">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="date-naissance">Date de naissance</label>
                    <div class="date-picker">
                        <input type="text" id="date-naissance" name="date_naissance" placeholder="JJ/MM/AAAA">
                        <div class="calendar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lieu-naissance">Lieu de naissance</label>
                    <input type="text" id="lieu-naissance" name="lieu_naissance" placeholder="Lieu de naissance">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input type="text" id="adresse" name="adresse" placeholder="Adresse complète">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email de l'apprenant">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" placeholder="Numéro de téléphone">
                </div>
                <div class="form-group">
                    <div class="upload-section">
                        <div class="upload-icon">📄</div>
                        <button class="upload-btn">Ajouter des document</button>
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
                    <label for="prenom-tuteur">Prénom(s) & nom</label>
                    <input type="text" id="prenom-tuteur" name="nom_tuteur" placeholder="Prénom et nom du tuteur">
                </div>
                <div class="form-group">
                    <label for="lien-parente">Lien de parenté</label>
                    <input type="text" id="lien-parente" name="lien_parente" placeholder="Lien de parenté">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="adresse-tuteur">Adresse</label>
                    <input type="text" id="adresse-tuteur" name="adresse_tuteur" placeholder="Adresse du tuteur">
                </div>
                <div class="form-group">
                    <label for="telephone-tuteur">Téléphone</label>
                    <input type="tel" id="telephone-tuteur" name="telephone_tuteur" placeholder="Téléphone du tuteur">
                </div>
            </div>
        </div>
        
        <div class="actions">
            <button class="btn btn-cancel">Annuler</button>
            <button class="btn btn-submit">Enregistrer</button>
        </div>
    </div>

</main>
</div>
