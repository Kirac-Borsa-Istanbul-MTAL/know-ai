<?php

$translations = [
    'welcome' => [
        'tr' => 'Hoşgeldiniz,',
        'en' => 'Welcome,',
    ],
    'login' => [
        'tr' => 'Lütfen hesabınıza giriş yapın',
        'en' => 'Please log in to your account',
    ],
    'register' => [
        'tr' => 'Lütfen hesabınızı oluşturun',
        'en' => 'Please create your account',
    ],
    'name' => [
        'tr' => 'Adınız',
        'en' => 'Your Name',
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
    'already_have_account' => [
        'tr' => 'Zaten hesabınız var mı?',
        'en' => 'Already have an account?',
    ],
    'login_button' => [
        'tr' => 'Giriş Yap',
        'en' => 'Log In',
    ],
    'register_button' => [
        'tr' => 'Kayıt Ol',
        'en' => 'Register',
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
    'home' => [
        'tr' => 'Ana Sayfa',
        'en' => 'Home',
    ],
    'statistics' => [
        'tr' => 'İstatistikler',
        'en' => 'Statistics',
    ],
    'about_us' => [
        'tr' => 'Hakkımızda',
        'en' => 'About Us',
    ],
    'profile' => [
        'tr' => 'Profil',
        'en' => 'Profile',
    ],
    'language' => [
        'tr' => 'Dil',
        'en' => 'Language',
    ],
    'theme' => [
        'tr' => 'Tema',
        'en' => 'Theme',
    ],
    'dark_mode' => [
        'tr' => 'Karanlık Mod',
        'en' => 'Dark Mode',
    ],
    'light_mode' => [
        'tr' => 'Aydınlık Mod',
        'en' => 'Light Mode',
    ],
    'settings' => [
        'tr' => 'Ayarlar',
        'en' => 'Settings',
    ],
    'logout' => [
        'tr' => 'Çıkış Yap',
        'en' => 'Logout',
    ],
    'theme_toggle' => [
        'tr' => 'Tema Değiştir',
        'en' => 'Toggle Theme',
    ],
    'search' => [
        'tr' => 'Ara...',
        'en' => 'Search...',
    ],
    'change_to_your_own_style' => [
        'tr' => 'Kendi Tarzına Değiştir',
        'en' => 'Change To Your Own Style',
    ],
    'search_settings' => [
        'tr' => 'Arama Ayarları',
        'en' => 'Search Settings',
    ],
    'search_filter_type' => [
        'tr' => 'Türe göre filtrele',
        'en' => 'Filter by type',
    ],
    'search_sort_order' => [
        'tr' => 'Sıralama düzeni',
        'en' => 'Sort order',
    ],
    'search_advanced_options' => [
        'tr' => 'Gelişmiş seçenekler',
        'en' => 'Advanced options',
    ],
    'new_question' => [
        'tr' => 'Yeni Soru',
        'en' => 'New Question',
    ],
    'ask_anything' => [
        'tr' => 'Herhangi bir şey sorabilirsiniz',
        'en' => 'You can ask anything',
    ],
    'ask' => [
        'tr' => 'Sor',
        'en' => 'Ask',
    ],
    'search_level' => [
        'tr' => 'Arama Seviyesi',
        'en' => 'Search Level',
    ],
    'beginner' => [
        'tr' => 'Başlangıç',
        'en' => 'Beginner',
    ],
    'intermediate' => [
        'tr' => 'Orta',
        'en' => 'Intermediate',
    ],
    'advanced' => [
        'tr' => 'İleri',
        'en' => 'Advanced',
    ],
    'expert' => [
        'tr' => 'Uzman',
        'en' => 'Expert',
    ],
    'professional' => [
        'tr' => 'Profesyonel',
        'en' => 'Professional',
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

?>