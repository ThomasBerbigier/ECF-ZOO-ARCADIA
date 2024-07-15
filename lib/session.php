<?php
if(getenv('JAWSDB_MARIA_URL') !== false) {
    session_set_cookie_params([
        'lifetime' => 3600,
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);
} else {
    session_set_cookie_params([
        'lifetime' => 3600,
        'path' => '/',
        'httponly' => true
    ]);
}
session_start();

// Génération du token CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}