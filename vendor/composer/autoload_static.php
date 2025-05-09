<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc4b6f91e4b0d4242a5bc2eca0b662ad1
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc4b6f91e4b0d4242a5bc2eca0b662ad1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc4b6f91e4b0d4242a5bc2eca0b662ad1::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc4b6f91e4b0d4242a5bc2eca0b662ad1::$classMap;

        }, null, ClassLoader::class);
    }
}
