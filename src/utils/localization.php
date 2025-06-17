<?php
function translate($text, $targetLanguage) {
    $texts = [
        'en' => [
            'welcome' => 'Welcome to Know AI',
            'login' => 'Please log in to your account',
            'email' => 'Email',
            'password' => 'Password',
            'remember' => 'Remember me',
            'dont_have_account' => 'Don\'t have an account?',
            'login_button' => 'Log In'
        ],
        'tr' => [
            'welcome' => 'Know AI\'a Hoşgeldiniz',
            'login' => 'Lütfen hesabınıza giriş yapın',
            'email' => 'E-posta',
            'password' => 'Şifre',
            'remember' => 'Beni hatırla',
            'dont_have_account' => 'Hesabınız yok mu?',
            'login_button' => 'Giriş Yap'
        ]
    ];
    if (isset($texts[$targetLanguage][$text])) {
        return $texts[$targetLanguage][$text];
    }

    return $text;
}
?>