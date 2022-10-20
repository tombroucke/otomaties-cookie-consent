<?php
namespace Otomaties\CookieConsent;

class Settings
{
    public static function categories()
    {
        return [
            'necessary' => __('Strictly necessary cookies', 'otomaties-cookie-consent'),
            'analytics' => __('Analytical cookies', 'otomaties-cookie-consent'),
            'advertising' => __('Advertisement and targeting cookies', 'otomaties-cookie-consent'),
            'personalization' => __('Personalization cookies', 'otomaties-cookie-consent'),
            'security' => __('Security cookies', 'otomaties-cookie-consent'),
        ];
    }

    public function category($key)
    {
        return new Category($key);
    }

    public function consentModal() : array
    {
        $description = DefaultStrings::value('occ_consent_modal_description');
        $description .= ' ' . sprintf(
            '<button type="button" data-cc="c-settings" class="cc-link">%s</button>',
            DefaultStrings::value('occ_consent_modal_settings_button_label')
        );
        return [
            'title' => DefaultStrings::value('occ_consent_modal_title'),
            'description' => $description,
            'accept' => DefaultStrings::value('occ_consent_modal_accept_button_label'),
            'reject' => DefaultStrings::value('occ_consent_modal_reject_button_label'),
        ];
    }

    public function settingsModal() : array
    {
        return [
            'title' =>  DefaultStrings::value('occ_settings_modal_title'),
            'saveSettingsBtn' =>  DefaultStrings::value('occ_settings_modal_save_settings_button_label'),
            'acceptAllBtn' =>  DefaultStrings::value('occ_settings_modal_accept_all_button_label'),
            'rejectAllBtn' =>  DefaultStrings::value('occ_settings_modal_reject_all_button_label'),
            'closeBtnlabel' =>  DefaultStrings::value('occ_settings_modal_close_button_label'),
            'cookieTableHeaders' => [
                'name' => __('Name', 'otomaties-cookie-consent'),
                'domain' => __('Domain', 'otomaties-cookie-consent'),
                'expiration' => __('Expiration', 'otomaties-cookie-consent'),
                'description' => __('Description', 'otomaties-cookie-consent'),
            ]
        ];
    }

    public function usage() : array
    {
        $usage = [
            'title' => DefaultStrings::value('occ_settings_modal_cookie_usage_title'),
            'description' => DefaultStrings::value('occ_settings_modal_cookie_usage_description'),
        ];
        if (get_privacy_policy_url() && get_privacy_policy_url() !== '') {
            $usage['description'] = $usage['description'] . ' ' . sprintf(
                __('For more details relative to cookies and other sensitive data, please read the full <a href="%s" class="cc-link">privacy policy</a>.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                get_privacy_policy_url()
            );
        }
        return $usage;
    }

    public function moreInformation() : ?array
    {

        $contactPage = get_field('occ_settings_modal_contact_page', 'option');

        if (!$contactPage) {
            return null;
        }

        $replaceLink = get_field('occ_settings_modal_contact_page', 'option') && get_post_status(get_field('occ_settings_modal_contact_page', 'option')) ? get_permalink(get_field('occ_settings_modal_contact_page', 'option')) : '#'; // phpcs:ignore Generic.Files.LineLength
        $description = DefaultStrings::value('occ_settings_modal_more_information_description');
        $moreInformation = [
            'title' => DefaultStrings::value('occ_settings_modal_more_information_title'),
            'description' => $description,
        ];
        $moreInformation['description'] = str_replace(
            '[contact_link]',
            sprintf(
                '<a class="cc-link" href="%s">%s</a>',
                $replaceLink,
                __('contact us', 'otomaties-cookie-consent')
            ),
            $description
        );
        
        return $moreInformation;
    }

    public function blocks() : array
    {
        $blocks = [
            'usage' => $this->usage(),
        ];

        foreach (Settings::categories() as $categoryKey => $categoryName) {
            $blocks[$categoryKey] = $this->category($categoryKey)->information();
        }

        if ($this->moreInformation()) {
            $blocks['moreInformation'] = $this->moreInformation();
        }

        return $blocks;
    }

    public function guiOptions() : array
    {
        return[
            'consentModal' => [
                'layout' => $this->generalOptionField('occ_consent_modal_layout') ?: 'cloud',
                'position' => $this->generalOptionField('occ_consent_modal_position') ?: 'bottom center',
                'transition' => $this->generalOptionField('occ_consent_modal_transition') ?: 'slide',
                'swapButtons' => $this->generalOptionField('occ_consent_modal_swap_buttons') ?: false
            ],
            'settingsModal' => [
                'layout' => $this->generalOptionField('occ_settings_modal_layout') ?: 'box',
                'position' => $this->generalOptionField('occ_settings_modal_position') ?: 'left',
                'transition' => $this->generalOptionField('occ_settings_modal_transition') ?: 'slide'
            ]
        ];
    }
    
    public function scriptVariables() : array
    {
        $variables = [
            'locale' => get_locale(),
            'guiOptions' => $this->guiOptions(),
            'strings' => [
                'consentModal' => $this->consentModal(),
                'settingsModal' => $this->settingsModal(),
                'blocks' => $this->blocks(),
            ],
            'gtmConsentMode' => get_field('occ_gtm_consent_mode', 'option'),
            'showAllCategories' => get_field('occ_show_all_categories', 'option'),
        ];
        return apply_filters('otomaties_cookie_consent_script_variables', $variables);
    }

    private function generalOptionField($optionKey)
    {
        add_filter('acf/settings/current_language', '__return_false');
        $value = get_field($optionKey, 'option');
        remove_filter('acf/settings/current_language', '__return_false');
        return $value;
    }
}
