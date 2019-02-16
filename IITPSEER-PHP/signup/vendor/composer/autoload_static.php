<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbbbf3420df4ac693984f8be2a3c6021f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbbbf3420df4ac693984f8be2a3c6021f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbbbf3420df4ac693984f8be2a3c6021f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
