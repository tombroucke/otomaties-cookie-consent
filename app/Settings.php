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
        $description = get_field('occ_consent_modal_description', 'option') ?: __('Hi, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent.', 'otomaties-cookie-consent');
        $description .= ' ' . sprintf('<button type="button" data-cc="c-settings" class="cc-link">%s</button>', get_field('occ_consent_modal_settings_button_label', 'option') ?: __('Let me choose', 'otomaties-cookie-consent'));
        return [
            'title' => get_field('occ_consent_modal_title', 'option') ?: __('We use cookies 🍪', 'otomaties-cookie-consent'),
            'description' => $description,
            'accept' => get_field('occ_consent_modal_accept_button_label', 'option') ?: __('Accept all', 'otomaties-cookie-consent'),
            'reject' => get_field('occ_consent_modal_reject_button_label', 'option') ?: __('Reject all', 'otomaties-cookie-consent'),
        ];
    }

    public function settingsModal()
    {
        return [
            'title' =>  get_field('occ_settings_modal_title', 'option') ?: __('Cookie preferences', 'otomaties-cookie-consent'),
            'saveSettingsBtn' =>  get_field('occ_settings_modal_save_settings_button_label', 'option') ?: __('Save settings', 'otomaties-cookie-consent'),
            'acceptAllBtn' =>  get_field('occ_settings_modal_accept_all_button_label', 'option') ?: __('Accept all', 'otomaties-cookie-consent'),
            'rejectAllBtn' =>  get_field('occ_settings_modal_reject_all_button_label', 'option') ?: __('Reject all', 'otomaties-cookie-consent'),
            'closeBtnlabel' =>  get_field('occ_settings_modal_close_button_label', 'option') ?: __('Close', 'otomaties-cookie-consent'),
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
            'title' => get_field('occ_settings_modal_cookie_usage_title', 'option') ?: __('Cookie usage', 'otomaties-cookie-consent'),
            'description' => get_field('occ_settings_modal_cookie_usage_description', 'option') ?: __('We use cookies to ensure the basic functionalities of this website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want.', 'otomaties-cookie-consent'),
        ];
        if (get_privacy_policy_url()) {
            $usage['description'] = $usage['description'] . ' ' . sprintf(__('For more details relative to cookies and other sensitive data, please read the full <a href="%s" class="cc-link">privacy policy</a>.', 'otomaties-cookie-consent'), get_privacy_policy_url());
        }
        return $usage;
    }

    public function moreInformation()
    {
        $description = get_field('occ_settings_modal_more_information_description', 'option') ?: __('For any queries in relation to our policy on cookies and your choices, please [contact_link].', 'otomaties-cookie-consent');

        $contactPage = get_field('occ_settings_modal_contact_page', 'option');
        $moreInformation = [
            'title' => get_field('occ_settings_modal_more_information_title', 'option') ?: __('More information', 'otomaties-cookie-consent'),
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
