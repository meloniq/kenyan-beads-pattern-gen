<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc41bd10d6ac8edebe61eddef5180190f
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitc41bd10d6ac8edebe61eddef5180190f', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc41bd10d6ac8edebe61eddef5180190f', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc41bd10d6ac8edebe61eddef5180190f::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}