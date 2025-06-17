<?php

$translations = [
    'welcome' => [
        'tr' => 'Know AI\'a Hoşgeldiniz',
        'en' => 'Welcome to Know AI',
    ],
    'login' => [
        'tr' => 'Lütfen hesabınıza giriş yapın',
        'en' => 'Please log in to your account',
    ],
    'email' => [
        'tr' => 'E-posta',
        'en' => 'Email',
    ],
    'password' => [
        'tr' => 'Şifre',
        'en' => 'Password',
    ],
    'remember' => [
        'tr' => 'Beni hatırla',
        'en' => 'Remember me',
    ],
    'dont_have_account' => [
        'tr' => 'Hesabınız yok mu?',
        'en' => 'Don\'t have an account?',
    ],
    'login_button' => [
        'tr' => 'Giriş Yap',
        'en' => 'Log In',
    ],
    '404_heading' => [
        'tr' => 'Sayfa Bulunamadı',
        'en' => 'Page Not Found',
    ],
    '404_message' => [
        'tr' => 'Üzgünüz, aradığınız sayfa mevcut değil veya taşınmış olabilir.',
        'en' => 'Sorry, the page you are looking for does not exist or may have been moved.',
    ],
    '404_button' => [
        'tr' => 'Ana Sayfaya Dön',
        'en' => 'Go Back Home',
    ],
];

function translate($key, $lang)
{
    global $translations;

    if (isset($translations[$key][$lang])) {
        return $translations[$key][$lang];
    }
    
    return $key;
}