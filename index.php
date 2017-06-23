<?php

spl_autoload_register(function ($class) {
    $class_path = __DIR__ . '/classes/' . preg_replace('/_([A-Z])/', '/$1', $class) . '.php';

    if ( file_exists($class_path) ) {
        require_once $class_path;
    } else {
        throw new Exception('class [' . $class . '] not found');
    }
});

session_start();

if ( isset($_SESSION['map']) ) {
    $map = $_SESSION['map'];
} else {
    try {
        $map = new Map(1800, 900);
        $_SESSION['map'] = $map;
    } catch ( Exception $e ) {
        echo $e->getMessage();
        exit;
    }
}

if ( isset($_POST['action']) ) {
    switch ($_POST['action']) {
        case 'click':
            $map->click_event();
            break;
        case 'move':
            $map->move_event();
            break;
    }

    $_SESSION['map'] = $map;

    echo json_encode([
        'map' => $map
    ]);
    exit;
}


include __DIR__ . '/view.php';