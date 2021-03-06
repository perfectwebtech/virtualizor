<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9c562cd6e921c4bfb76b6e177a682655
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Virtualizor\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Virtualizor\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9c562cd6e921c4bfb76b6e177a682655::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9c562cd6e921c4bfb76b6e177a682655::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
