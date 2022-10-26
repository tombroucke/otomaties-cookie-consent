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

        // test if google cookies are present
        $googleCookies = [];
        foreach ($cookiesCategories as $categoryKey => $category) {
            foreach ($category['cookies'] as $cookie) {
                if (strpos($cookie['name'], '_ga') !== false) {
                    $googleCookies[] = $cookie;
                }
            }
        }

        $linkGooglePrivacyTerms = count($googleCookies) > 0;
        ob_start();
        include __DIR__ . '/../views/cookie-table.php';
        return ob_get_clean();
    }
}
