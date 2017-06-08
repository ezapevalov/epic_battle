<?php

spl_autoload_register(function ($class) {
    $class_path = __DIR__ . '/classes/' . preg_replace('/_([A-Z])/', '/$1', $class) . '.php';

    if ( file_exists($class_path) ) {
        require_once $class_path;
    } else {
        throw new Exception('class [' . $class . '] not found');
    }
});

try {
    $map = new Map(1800, 900);
} catch ( Exception $e ) {
    echo $e->getMessage();
    exit;
}

include __DIR__ . '/view.php';