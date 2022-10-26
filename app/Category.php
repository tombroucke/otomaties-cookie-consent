<?php
namespace Otomaties\CookieConsent;

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

    public function cookieTable() : array
    {
        $cookieTableField = Settings::generalOptionField('occ_' . $this->categoryName() . '_cookie_table');
        if (!$cookieTableField) {
            return [];
        }
        $lang = apply_filters('wpml_current_language', null);
        $cookies = [];
        foreach ($cookieTableField as $key => $cookie) {
            $newCookie = [
                'name' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['name'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_name',
                    'options_occ_necessary_cookie_table_' . $key . '_name',
                    $lang
                ),
                'domain' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['domain'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_domain',
                    'options_occ_necessary_cookie_table_' . $key . '_domain',
                    $lang
                ),
                'expiration' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['expiration'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_expiration',
                    'options_occ_necessary_cookie_table_' . $key . '_expiration',
                    $lang
                ),
                'description' => apply_filters(
                    'wpml_translate_single_string',
                    $cookie['description'],
                    'admin_texts_options_occ_necessary_cookie_table_' . $key . '_description',
                    'options_occ_necessary_cookie_table_' . $key . '_description',
                    $lang
                ),
            ];
            if (isset($cookie['regex']) && $cookie['regex'] == true) {
                $newCookie['isRegex'] = true;
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
}
