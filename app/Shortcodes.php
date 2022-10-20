<?php
namespace Otomaties\CookieConsent;

class Shortcodes
{
    public function cookieTable()
    {
        $cookiesCategories = [];
        foreach (Settings::categories() as $categoryKey => $categoryName) {
            $category = new Category($categoryKey);
            $cookiesCategories[$categoryKey] = [
                'name' => $categoryName,
                'cookies' => $category->cookieTable(),
            ];
        }
        ob_start();
        include __DIR__ . '/../views/cookie-table.php';
        return ob_get_clean();
    }
}
