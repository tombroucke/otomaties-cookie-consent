<?php
namespace Otomaties\CookieConsent;

class Shortcodes
{
    public function cookieTable($atts)
    {
        $a = shortcode_atts(array(
            'show' => 'what,table,google-privacy-terms',
        ), $atts);

        $showSections = explode(',', $a['show']);

        $cookiesCategories = [];
        foreach (Settings::categories() as $categoryKey => $category) {
            $cookiesCategories[$categoryKey] = [
                'name' => $category['label'],
                'cookies' => (new Category($category))->cookieTable(),
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
