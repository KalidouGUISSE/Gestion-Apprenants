<div id="form-container">
    <div class="logo-container">
        <a href="#"><img src="/assets/images/logo-odc-sonatel.png" alt="logo" /></a>
    </div>
    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>
    
        <?php if (!empty($errorMessage)): ?>
            <div  class="error message">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>    
  
    <form action="index.php?route=auth"  method="post">
        <h1>Se connecter</h1>

        <div class="form-group">
            <label for="username">Login</label>
            <input id="username" type="text" name="username" placeholder="Matricule ou email"/>
            <span class="invalid"></span>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" placeholder="Mot de passe"/>
            <span class="invalid"></span>
        </div>

        <a href="index.php?route=forgot_password" class="forget-password">Mot de passe oublié?</a>

        <button type="submit" class="login-btn" name="auth">Se connecter</button>
    </form>
</div>



<!-- <section class="login-section">
    <div class="login-container">
        <h2>Connexion</h2>
        
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message">
                <?= $errorMessage ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php?route=auth" method="post">
            <div class="form-group">
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>

            <div class="mdpOublie">
                <a href="#">Mot de passe oublié ?</a>
            </div>
        </form>
    </div>
</section> -->







