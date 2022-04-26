<?php
namespace Otomaties\CookieConsent;

class Settings
{
    public function category($key)
    {
        return new Category($key);
    }

    public function consentModal()
    {
        $description = DefaultStrings::value('occ_consent_modal_description');
        $description .= ' ' . sprintf('<button type="button" data-cc="c-settings" class="cc-link">%s</button>', DefaultStrings::value('occ_consent_modal_settings_button_label'));
        return [
            'title' => DefaultStrings::value('occ_consent_modal_title'),
            'description' => $description,
            'accept' => DefaultStrings::value('occ_consent_modal_accept_button_label'),
            'reject' => DefaultStrings::value('occ_consent_modal_reject_button_label'),
        ];
    }

    public function settingsModal()
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

    public function usage()
    {
        $usage = [
            'title' => DefaultStrings::value('occ_settings_modal_cookie_usage_title'),
            'description' => DefaultStrings::value('occ_settings_modal_cookie_usage_description'),
        ];
        if (get_privacy_policy_url()) {
            $usage['description'] = $usage['description'] . ' ' . sprintf(__('For more details relative to cookies and other sensitive data, please read the full <a href="%s" class="cc-link">privacy policy</a>.', 'otomaties-cookie-consent'), get_privacy_policy_url());
        }
        return $usage;
    }

    public function moreInformation()
    {
        $description = DefaultStrings::value('occ_settings_modal_more_information_description');

        $contactPage = get_field('occ_settings_modal_contact_page', 'option');
        $moreInformation = [
            'title' => DefaultStrings::value('occ_settings_modal_more_information_title'),
            'description' => $description,
        ];

        if ($contactPage) {
            $replaceLink = get_field('occ_settings_modal_contact_page', 'option') && get_post_status(get_field('occ_settings_modal_contact_page', 'option')) ? get_permalink(get_field('occ_settings_modal_contact_page', 'option')) : '#';
            $moreInformation['description'] = str_replace('[contact_link]', sprintf('<a class="cc-link" href="%s">%s</a>', $replaceLink, __('contact us', 'otomaties-cookie-consent')), $description);
        }
        
        return $moreInformation;
    }

    public function blocks()
    {
        $blocks = [
            'usage' => $this->usage(),
            'necessary' => $this->category('necessary')->information(),
            'analytics' => $this->category('analytics')->information(),
            'targeting' => $this->category('targeting')->information(),
        ];

        if ($this->moreInformation()) {
            $blocks['moreInformation'] = $this->moreInformation();
        }

        return $blocks;
    }

    public function guiOptions()
    {
        return[
            'consentModal' => [
                'layout' => get_field('occ_consent_modal_layout', 'option') ?: 'cloud',
                'position' => get_field('occ_consent_modal_position', 'option') ?: 'bottom center',
                'transition' => get_field('occ_consent_modal_transition', 'option') ?: 'slide',
                'swapButtons' => get_field('occ_consent_modal_swap_buttons', 'option') ?: false
            ],
            'settingsModal' => [
                'layout' => get_field('occ_settings_modal_layout', 'option') ?: 'box',
                'position' => get_field('occ_settings_modal_position', 'option') ?: 'left',
                'transition' => get_field('occ_settings_modal_transition', 'option') ?: 'slide'
            ]
        ];
    }
    
    public function scriptVariables()
    {
        $variables = [
            'locale' => get_locale(),
            'guiOptions' => $this->guiOptions(),
            'strings' => [
                'consentModal' => $this->consentModal(),
                'settingsModal' => $this->settingsModal(),
                'blocks' => $this->blocks(),
            ]
        ];
        return apply_filters('otomaties_cookie_consent_script_variables', $variables);
    }
}
