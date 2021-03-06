<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a6d89c1b62de5fd19cdffa19bd6551f
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'Overtrue\\Pinyin\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Overtrue\\Pinyin\\' => 
        array (
            0 => __DIR__ . '/..' . '/overtrue/pinyin/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2a6d89c1b62de5fd19cdffa19bd6551f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2a6d89c1b62de5fd19cdffa19bd6551f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
