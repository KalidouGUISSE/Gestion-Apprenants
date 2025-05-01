<?php
namespace App\Services;

function set($key, $value) {
    $_SESSION[$key] = $value;
}

function get($key, $default = null) {
    return $_SESSION[$key] ?? $default;
}

function has($key) {
    return isset($_SESSION[$key]);
}

function remove($key) {
    if (isset($_SESSION[$key])) {
        unset($_SESSION[$key]);
    }
}

function destroy() {
    session_destroy();
}

function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

function getFlash($key, $default = null) {
    $message = $_SESSION['flash'][$key] ?? $default;
    unset($_SESSION['flash'][$key]);
    return $message;
}

function gererErreurs(array $errors, array $oldData): void {
    $_SESSION['errors'] = array_values($errors);
    $_SESSION['old'] = $oldData;
    $_SESSION['modal_open'] = true;
    header("Location: index.php?route=admin_dashboard");
    exit;
}