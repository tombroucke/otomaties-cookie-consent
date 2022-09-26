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
        $cookieTableField = get_field('occ_' . $this->categoryName() . '_cookie_table', 'option');
        if (!$cookieTableField) {
            return [];
        }

        $cookies = [];
        foreach ($cookieTableField as $cookie) {
            $newCookie = [
                'col1' => $cookie['name'],
                'col2' => $cookie['domain'],
                'col3' => $cookie['expiration'],
                'col4' => $cookie['description'],
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
}
