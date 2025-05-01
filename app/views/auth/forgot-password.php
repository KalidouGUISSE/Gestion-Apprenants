
<div id="form-container">
    <div class="logo-container">
            <a href="#"><img src="/assets/images/logo-odc-sonatel.png" alt="logo" /></a>
    </div>
    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>
    
        <?php if (isset($message)): ?>
            <div  class="error message">
                <?= $message ?>
            </div>
        <?php endif; ?> 

    <form action="index.php?route=reset_password"  method="post">
        <h1>Mot de passe oublié</h1>

        <div class="form-group">
            <label for="password"></label>
            <!-- <input type="password" id="password" name="password" placeholder="Mot de passe"/> -->
            <span class="invalid"></span>
        </div>
        <div class="form-group">
            <label for="login">Entrez votre Login pour recuperer votre mot de passe</label>
            <input type="text" id="login" name="login" placeholder="Email ou identifiant">
            <span class="invalid"></span>
        </div>


        <button type="submit" class="login-btn" name="auth">Récupérer le mot de passe</button>
    </form>
</div>













<!-- <h2>Mot de passe oublié</h2>
<form action="index.php?route=reset_password" method="post">
    <div class="form-group">
        <label for="login">Entrer votre email ou identifiant :</label>
        <input type="text" id="login" name="login" placeholder="Email ou identifiant">
    </div>
    <button type="submit">Récupérer le mot de passe</button>
</form>

<?php if (isset($message)): ?>
    <p style="margin-top: 1rem; color: #333;"><?php echo $message; ?></p>
<?php endif; ?> -->
