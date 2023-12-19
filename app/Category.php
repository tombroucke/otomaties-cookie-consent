<?php
namespace Otomaties\CookieConsent;

use Otomaties\CookieConsent\Contracts\Cookie;

class Category
{
    private $categoryName;

    public function __construct($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    protected function categoryName() : string
    {
        return $this->categoryName;
    }

    public function cookies() : array
    {
        return Settings::generalOptionField('occ_' . $this->categoryName() . '_cookie_table') ?: [];
    }

    public function cookieTable() : array
    {
        $cookieTableField = $this->cookies();
        $lang = apply_filters('wpml_current_language', null);
        $cookies = [];
        foreach ($cookieTableField as $key => $cookie) {
            $newCookie = [
                'col1' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['name'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_name',
                    'options_occ_necessary_cookie_table_' . $key . '_name',
                    $lang
                ),
                'col2' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['domain'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_domain',
                    'options_occ_necessary_cookie_table_' . $key . '_domain',
                    $lang
                ),
                'col3' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['expiration'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_expiration',
                    'options_occ_necessary_cookie_table_' . $key . '_expiration',
                    $lang
                ),
                'col4' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['description'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_description',
                    'options_occ_necessary_cookie_table_' . $key . '_description',
                    $lang
                ),
            ];
            if (isset($cookie['regex']) && $cookie['regex'] == true) {
                $newCookie['is_regex'] = true;
            }
            $cookies[] = $newCookie;
        }
        return $cookies;
    }

    public function information() : array
    {
        $information = [
            'title' => DefaultStrings::value('occ_' . $this->categoryName() . '_title'),
            'description' => DefaultStrings::value('occ_' . $this->categoryName() . '_description'),
            'cookieTable' => $this->cookieTable(),
        ];
        return $information;
    }

    public function addCookie(Cookie $cookie)
    {
        add_row('occ_' . $this->categoryName() . '_cookie_table', [
            'name' => $cookie->name(),
            'domain' => $cookie->domain(),
            'expiration' => $cookie->expiration(),
            'description' => $cookie->description(),
            'regex' => $cookie->regex(),
        ], 'option');
    }
}
