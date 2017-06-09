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
            $map->remove_active_from_units();
            $detected_unit = &$map->detect_unit($_POST['x'], $_POST['y']);

            if ( $detected_unit ) {
                if ( $detected_unit == $map->active_unit ) {
                    $map->active_unit = null;
                } else {
                    $map->active_unit = $detected_unit;
                    $detected_unit->active = 1;
                }
            } else if ( !$detected_unit && $map->active_unit ) {
                $map->active_unit->move_to($_POST['x'], $_POST['y']);
                $map->active_unit->active = 0;
                $map->active_unit = null;
            }
    }

    $_SESSION['map'] = $map;

    echo json_encode([
        'map' => $map
    ]);
    exit;
}


include __DIR__ . '/view.php';