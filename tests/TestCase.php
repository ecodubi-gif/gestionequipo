<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/*
 * PROTECCIÓN. Los tests con RefreshDatabase BORRAN Y RECREAN todas las tablas.
 * Solo se permiten contra SQLite en memoria; en cualquier otro caso se aborta
 * en cuanto se carga este fichero, antes de tocar ninguna base de datos.
 * (Esta comprobación existe desde que un test se ejecutó contra la base de datos real.)
 */
(function () {
    $conexion = $_ENV['DB_CONNECTION'] ?? $_SERVER['DB_CONNECTION'] ?? getenv('DB_CONNECTION');
    $base = $_ENV['DB_DATABASE'] ?? $_SERVER['DB_DATABASE'] ?? getenv('DB_DATABASE');

    if ($conexion !== 'sqlite' || $base !== ':memory:') {
        throw new \RuntimeException(
            'TESTS ABORTADOS: no usan SQLite en memoria (conexión: ' . var_export($conexion, true)
            . ', base: ' . var_export($base, true) . '). Se habrían ejecutado contra datos reales.'
        );
    }

    // Con la configuración en caché, phpunit.xml se ignora y se usaría la base real.
    if (file_exists(dirname(__DIR__) . '/bootstrap/cache/config.php')) {
        throw new \RuntimeException(
            'TESTS ABORTADOS: la configuración está en caché (bootstrap/cache/config.php). '
            . 'Ejecuta "php artisan config:clear" antes de lanzar los tests.'
        );
    }
})();

abstract class TestCase extends BaseTestCase
{
    //
}
