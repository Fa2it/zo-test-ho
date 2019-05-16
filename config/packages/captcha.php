<?php
/**
 * Created by PhpStorm.
 * User: Mary
 * Date: 16.05.2019
 * Time: 08:46
 */
 if (!class_exists('CaptchaConfiguration')) { return; }

// BotDetect PHP Captcha configuration options

return [
    // Captcha configuration for example page
    'ExampleCaptcha' => [
        'UserInputID' => 'captchaCode',
        'ImageWidth' => 250,
        'ImageHeight' => 50,
    ],

];