<div id="form-container">
    <div class="logo-container">
        <a href="#"><img src="/assets/images/logo-odc-sonatel.png" alt="logo" /></a>
    </div>
    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>
    
        <?php if (!empty($_SESSION['errorMessage'])): ?>
            <div  class="error message">
                <?php print_r($_SESSION['errorMessage']) ;?>
                <?php unset($_SESSION['errorMessage']); ?>
            </div>
        <?php endif;?>    

    <form action="index.php?route=changerpassword"  method="post">
        <h1>Se connecter</h1>

        <div class="form-group">
            <label for="login">Login</label>
            <input id="login" type="text" name="login" placeholder="Votre login"/>
            <span class="invalid"></span>
        </div>

        <div class="form-group">
            <label for="newpassword">Nouveau password</label>
            <input id="newpassword" type="text" name="newpassword" placeholder="Nouveau password"/>
            <span class="invalid"></span>
        </div>

        <div class="form-group">
            <label for="confirmernewpassword">Confirnmer Password</label>
            <input type="password" id="confirmernewpassword" name="confirmernewpassword" placeholder="Confirnmer Password"/>
            <span class="invalid"></span>
        </div>
        <a href="index.php?route=login" class="forget-password">Se connecter</a>

        <button type="submit" class="login-btn" name="auth">Creer</button>
    </form>
</div>


