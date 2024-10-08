<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7ebc4cbd92cb1af96b45b1458e3f4a7f
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
        'A' => 
        array (
            'App\\Models\\' => 11,
            'App\\Controllers\\' => 16,
            'App\\Config\\' => 11,
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/PHP/assets/Models',
        ),
        'App\\Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/PHP/app/Controllers',
        ),
        'App\\Config\\' => 
        array (
            0 => __DIR__ . '/../..' . '/PHP/config',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/PHP/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7ebc4cbd92cb1af96b45b1458e3f4a7f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7ebc4cbd92cb1af96b45b1458e3f4a7f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7ebc4cbd92cb1af96b45b1458e3f4a7f::$classMap;

        }, null, ClassLoader::class);
    }
}
