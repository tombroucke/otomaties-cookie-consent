<?php

namespace Otomaties\CookieConsent;

class DefaultStrings
{
    public static function get(string $key)
    {
        $strings = [
            'occ_consent_modal_title' => __('We use cookies 🍪', 'otomaties-cookie-consent'),
            'occ_consent_modal_description' => __('Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_consent_modal_settings_button_label' => __('Let me choose', 'otomaties-cookie-consent'),
            'occ_consent_modal_accept_button_label' => __('Accept all', 'otomaties-cookie-consent'),
            'occ_consent_modal_reject_button_label' => __('Reject all', 'otomaties-cookie-consent'),
            'occ_settings_modal_title' => __('Cookie preferences', 'otomaties-cookie-consent'),
            'occ_settings_modal_cookie_usage_title' => __('Cookie usage', 'otomaties-cookie-consent'),
            'occ_settings_modal_cookie_usage_description' => __('We use cookies to ensure the basic functionalities of this website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_settings_modal_more_information_title' => __('More information', 'otomaties-cookie-consent'),
            'occ_settings_modal_more_information_description' => sprintf(__('For any queries in relation to our policy on cookies and your choices, please [contact_link].', 'otomaties-cookie-consent'), get_permalink(get_field('occ_settings_modal_contact_page', 'option'))), // phpcs:ignore Generic.Files.LineLength
            'occ_settings_modal_save_settings_button_label' => __('Save settings', 'otomaties-cookie-consent'),
            'occ_settings_modal_accept_all_button_label' => __('Accept all', 'otomaties-cookie-consent'),
            'occ_settings_modal_reject_all_button_label' => __('Reject all', 'otomaties-cookie-consent'),
            'occ_settings_modal_close_button_label' => __('Close', 'otomaties-cookie-consent'),
            'occ_necessary_title' => __('Strictly necessary cookies', 'otomaties-cookie-consent'),
            'occ_necessary_description' => __('These cookies are essential for the proper functioning of this website. Without these cookies, the website would not work properly', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_analytics_title' => __('Analytical cookies', 'otomaties-cookie-consent'),
            'occ_analytics_description' => __('These cookies allow the website to remember the choices you have made in the past', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_advertising_title' => __('Advertisement and targeting cookies', 'otomaties-cookie-consent'),
            'occ_advertising_description' => __('These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_personalization_title' => __('Personalization cookies', 'otomaties-cookie-consent'),
            'occ_personalization_description' => __('These cookies store personalisation e.g. video recommendations', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
            'occ_security_title' => __('Security cookies', 'otomaties-cookie-consent'),
            'occ_security_description' => __('Storage related to security such as authentication functionality, fraud prevention, and other user protection', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
        ];
        return $strings[$key] ?? null;
    }

    public static function value(string $key)
    {
        return get_field($key, 'option') !== null ? get_field($key, 'option') : self::get($key);
    }
}
