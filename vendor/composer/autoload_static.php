<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2b151ef142ce95bb3b855f62377df3de
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Iframous\\' => 9,
        ),
        'D' => 
        array (
            'DiDom\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Iframous\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Iframous',
        ),
        'DiDom\\' => 
        array (
            0 => __DIR__ . '/..' . '/imangazaliev/didom/src/DiDom',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2b151ef142ce95bb3b855f62377df3de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2b151ef142ce95bb3b855f62377df3de::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit2b151ef142ce95bb3b855f62377df3de::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
