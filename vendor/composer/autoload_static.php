<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc41bd10d6ac8edebe61eddef5180190f
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Meloniq\\KenyanBeads\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Meloniq\\KenyanBeads\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc41bd10d6ac8edebe61eddef5180190f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc41bd10d6ac8edebe61eddef5180190f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc41bd10d6ac8edebe61eddef5180190f::$classMap;

        }, null, ClassLoader::class);
    }
}