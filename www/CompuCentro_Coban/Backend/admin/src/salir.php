<?php
// No imprimas NADA antes de esto (ni espacios)
session_start();

// Vaciar arreglo de sesión
$_SESSION = [];

// Borrar cookie de sesión (si aplica)
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destruir sesión en el servidor
session_destroy();

// Redirigir al login con un mensajito
header('Location: ../login.php?logout=1');
exit;
?>