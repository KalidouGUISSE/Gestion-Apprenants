<?php
$dataPath = __DIR__ . '/data/data.json';
$data = json_decode(file_get_contents($dataPath), true);

function hashPasswords(&$users) {
    foreach ($users as &$user) {
        if (isset($user['password'])) {
            // Évite de re-hacher un mot de passe déjà sécurisé
            if (!password_get_info($user['password'])['algo']) {
                $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            }
        }
    }
}

// Appliquer aux différents rôles
if (isset($data['admins'])) hashPasswords($data['admins']);
if (isset($data['vigiles'])) hashPasswords($data['vigiles']);
if (isset($data['apprenants'])) hashPasswords($data['apprenants']);

file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
echo "✅ Tous les mots de passe valides ont été hachés.\n";
