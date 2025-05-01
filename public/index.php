<?php
session_start();
require_once '../app/route/route.web.php';

// Définition de la route par défaut
$route = $_GET['route'] ?? 'login';

// Chargement du contrôleur approprié
\App\Route\loadController($route);