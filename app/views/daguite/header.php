<!-- Header -->

<?php
ob_start();
?>
<header class="header view-grid">
    <div class="header-left">
    <button class="menu-toggle">
        <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 20 20"
        >
        <path
            fill=""
            d="M3.497 15.602a.7.7 0 1 1 0 1.398H.7a.7.7 0 1 1 0-1.398zm15.803 0a.7.7 0 1 1 0 1.398H5.529a.7.7 0 1 1 0-1.398zM3.497 9.334a.7.7 0 1 1 0 1.399H.7a.7.7 0 1 1 0-1.399zm15.803 0a.7.7 0 1 1 0 1.399H5.528a.7.7 0 1 1 0-1.399zM3.497 3a.7.7 0 1 1 0 1.398H.7A.7.7 0 1 1 .7 3zM19.3 3a.7.7 0 1 1 0 1.398H5.528a.7.7 0 1 1 0-1.398z"
        />
        </svg>
    </button>
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
    </div>
    <div class="header-right">
    <div class="notifications">
        <svg
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        viewBox="0 0 24 24"
        >
        <path
            fill=""
            d="M12 1c3.681 0 7 2.565 7 6v4.539c0 .642.189 1.269.545 1.803l2.2 3.298A1.517 1.517 0 0 1 20.482 19H15.5a3.5 3.5 0 1 1-7 0H3.519a1.518 1.518 0 0 1-1.265-2.359l2.2-3.299A3.25 3.25 0 0 0 5 11.539V7c0-3.435 3.318-6 7-6M6.5 7v4.539a4.75 4.75 0 0 1-.797 2.635l-2.2 3.298l-.003.01l.001.007l.004.006l.006.004l.007.001h16.964l.007-.001l.006-.004l.004-.006l.001-.006l-.003-.01l-2.199-3.299a4.75 4.75 0 0 1-.798-2.635V7c0-2.364-2.383-4.5-5.5-4.5S6.5 4.636 6.5 7M14 19h-4a2 2 0 1 0 4 0"
        />
        </svg>
    </div>
    <div class="user-profile">
        <div class="picture">
        <img src="assets/images/img-promo-2025.jpg" alt="" />
        </div>
            <?php if (\App\Services\has('user')): ?>
                <a href="#">
                    <h4>Connecté en tant que:<span><?= \App\Services\get('user')['login'] ?>@gmail.com</span></h4>
                </a>
                    <!-- Connecté en tant que: <?= \App\Services\get('user')['login'] ?>
                    <a href="index.php?route=logout">Déconnexion</a>
                    -->
            <?php endif; ?>
    </div>
    </div>
</header>


<?php
$header = ob_get_clean();
?>