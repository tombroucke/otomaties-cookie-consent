<?php
namespace Otomaties\CookieConsent;

use StoutLogic\AcfBuilder\FieldsBuilder;

/**
 * Add ACF options pages
 */
class OptionsPage
{

    /**
     * Create pages
     */
    public function addOptionsPage() : void
    {
        acf_add_options_page(
            array(
                'page_title'    => __('Cookie consent', 'otomaties-cookie-consent'),
                'menu_title'    => __('Cookie consent', 'otomaties-cookie-consent'),
                'menu_slug'     => 'cookie-consent-settings',
                'icon_url'      => Assets::find('images/cookie.png'),
                'capability'    => apply_filters('otomaties_cookie_consent_settings_capability', 'manage_options'),
                'redirect'      => false,
            )
        );
    }

    /**
     * Add options fields
     *
     * @return void
     */
    public function addOptionsFields() : void
    {
        $navMenus = [];
        foreach (wp_get_nav_menus() as $navMenu) {
            $navMenus['term_id_' . (string)$navMenu->term_id] = $navMenu->name;
        }
        // General settings
        $cookieConsentSettings = new FieldsBuilder('cookie-consent-settings', [
            'title' => __('Cookie consent settings', 'otomaties-cookie-consent'),
            'menu_order' => -1
        ]);
        $cookieConsentSettings
            ->addTab('occ_consent_modal', [
                'label' => __('Consent modal', 'otomaties-cookie-consent')
            ])
                ->addText('occ_consent_modal_title', [
                    'label' => __('Title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_title'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addTextarea('occ_consent_modal_description', [
                    'label' => __('Description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_description'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_consent_modal_settings_button_label', [
                    'label' => __('Settings button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_settings_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_consent_modal_accept_button_label', [
                    'label' => __('Accept button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_accept_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_consent_modal_reject_button_label', [
                    'label' => __('Reject button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_reject_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_consent_modal_manage_button_label', [
                    'label' => __('Manage settings button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_manage_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addSelect('occ_consent_modal_trigger_in_menu', [
                    'label' => __('Add cookie settings to menu', 'otomaties-cookie-consent'),
                    'choices' => $navMenus,
                    'allow_null' => true,
                    'wpml_cf_preferences' => 2,
                ])
                ->addSelect('occ_consent_modal_layout', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'cloud' => __('Cloud', 'otomaties-cookie-consent'),
                        'box' => __('Box', 'otomaties-cookie-consent'),
                        'bar' => __('Bar', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'cloud',
                    'wpml_cf_preferences' => 1,
                ])
                ->addSelect('occ_consent_modal_position', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'top left' => __('Top left', 'otomaties-cookie-consent'),
                        'middle left' => __('Middle left', 'otomaties-cookie-consent'),
                        'bottom left' => __('Bottom left', 'otomaties-cookie-consent'),
                        'top center' => __('Top center', 'otomaties-cookie-consent'),
                        'middle center' => __('Middle center', 'otomaties-cookie-consent'),
                        'bottom center' => __('Bottom center', 'otomaties-cookie-consent'),
                        'top right' => __('Top right', 'otomaties-cookie-consent'),
                        'middle right' => __('Middle right', 'otomaties-cookie-consent'),
                        'bottom right' => __('Bottom right', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'bottom center',
                    'wpml_cf_preferences' => 1,
                ])
                ->addTrueFalse('occ_consent_modal_swap_buttons', [
                    'label' => __('Swap buttons', 'otomaties-cookie-consent'),
                    'message' => __('Swap reject/accept buttons', 'otomaties-cookie-consent'),
                    'wpml_cf_preferences' => 1,
                ])
            ->addTab('occ_settings_modal', [
                'label' => __('Settings modal', 'otomaties-cookie-consent')
            ])
                ->addText('occ_settings_modal_title', [
                    'label' => __('Title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_title'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_cookie_usage_title', [
                    'label' => __('Cookie usage title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_cookie_usage_title'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addTextarea('occ_settings_modal_cookie_usage_description', [
                    'label' => __('Cookie usage description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_cookie_usage_description'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_more_information_title', [
                    'label' => __('More information title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_more_information_title'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addPostObject('occ_settings_modal_contact_page', [
                    'label' => __('Contact page', 'otomaties-cookie-consent'),
                    'post_type' => 'page',
                    'return_format' => 'ID',
                    'allow_null' => true,
                    'wpml_cf_preferences' => 2,
                ])
                ->addTextarea('occ_settings_modal_more_information_description', [
                    'label' => __('More information description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_more_information_description'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_save_settings_button_label', [
                    'label' => __('Save settings button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_save_settings_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_accept_all_button_label', [
                    'label' => __('Accept all button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_accept_all_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_reject_all_button_label', [
                    'label' => __('Reject all button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_reject_all_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_settings_modal_close_button_label', [
                    'label' => __('Close button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_close_button_label'),
                    'wpml_cf_preferences' => 2,
                ])
                ->addSelect('occ_settings_modal_layout', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'box' => __('Box', 'otomaties-cookie-consent'),
                        'bar' => __('Bar', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'box',
                    'wpml_cf_preferences' => 1,
                ])
                ->addSelect('occ_settings_modal_position', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'left' => __('Left', 'otomaties-cookie-consent'),
                        'right' => __('Right', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'right',
                    'wpml_cf_preferences' => 1,
                ])
            ->addTab('general', [
                'label' => __('General', 'otomaties-cookie-consent')
            ])
                ->addTrueFalse('occ_gtm_consent_mode', [
                    'label' => __('Google Tag Manager consent mode', 'otomaties-cookie-consent'),
                    'instructions' => __('If you use Google Tag Manager, you can enable consent mode. This will prevent GTM from loading until the user has given consent.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                    'message' => __('Enable GTM consent mode', 'otomaties-cookie-consent'),
                    'wpml_cf_preferences' => 1,
                ])
                ->addTrueFalse('occ_gtm_url_passthrough', [
                    'label' => __('Google Tag Manager URL passthrough', 'otomaties-cookie-consent'),
                    'instructions' => __('When a user lands on your website after clicking an ad, information about the ad may be appended to your landing page URLs as a query parameter. In order to improve conversion accuracy, this information is usually stored in first-party cookies on your domain.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                    'message' => __('Enable URL passthrough', 'otomaties-cookie-consent'),
                ])
                ->addTrueFalse('occ_show_all_categories', [
                    'label' => __('Show all cookie categories', 'otomaties-cookie-consent'),
                    'instructions' => __('If enabled, all categories will be shown in the settings modal. If disabled, only categories with cookies will be shown.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                    'message' => __('Show all categories', 'otomaties-cookie-consent'),
                    'wpml_cf_preferences' => 1,
                ])
                ->addNumber('occ_revision', [
                    'label' => __('Revision', 'otomaties-cookie-consent'),
                    'instructions' => __('Increment this number to reset the cookie consent modal for all users.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                    'wpml_cf_preferences' => 1,
                ])
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentSettings->build());

        // Category settings
        $cookieConsentCategorieSettings = new FieldsBuilder('cookie-consent-category-settings', [
            'title' => __('Cookie categories', 'otomaties-cookie-consent')
        ]);
        $categories = [
            'necessary' => [
                'name' => __('Necessary', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_necessary_title'),
                'defaultDescription' => DefaultStrings::get('occ_necessary_description'),
                'commonScripts' => [
                    [
                        'name' => 'cc_cookie',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d days', 'otomaties-cookie-consent'), 182),
                        'description' => __('Tracks your cookie consent', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => 'wc_cart_created',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Necessary for the shopping cart functionality on the website.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => 'woocommerce_cart_hash',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Necessary for the shopping cart functionality on the website to remember the chosen products - This also allows the website to promote related products to the visitor, based on the content of the shopping cart.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => 'woocommerce_items_in_cart',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Contains information about the cart as a whole and help WooCommerce know when the cart data changes.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => 'wc_fragments_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => '',
                        'regex' => true,
                    ],
                    [
                        'name' => 'wp_woocommerce_session_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d days', 'otomaties-cookie-consent'), 2),
                        'description' => __('Contains a unique code for each customer so that it knows where to find the cart data in the database for each customer.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('Stores your authentication details. Its use is limited to the admin area.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_logged_in_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('This cookie indicates when you’re logged in, and who you are, for most interface use.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_settings-*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('WordPress also sets a few wp-settings-{time}-[UID] cookies. The number on the end is your individual user ID from the user’s database table. This is used to customize your view of admin interface, and possibly also the main site interface.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => 'wp-wpml_current_language',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Stores the current language.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                ],
            ],
            'analytics' => [
                'name' => __('Analytics', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_analytics_title'),
                'defaultDescription' => DefaultStrings::get('occ_analytics_description'),
                'commonScripts' => [
                    [
                        'name' => '_ga',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '2 ' . __('years', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to distinguish users.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_gid',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '24 ' . __('hours', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to distinguish users.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_ga_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '2 ' . __('years', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to persist session state.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => '_gac_gb_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '90 ' . __('days', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Contains campaign related information', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => '_gat',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '1 ' . __('minute', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to distinguish users.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => '_gac_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '90 ' . __('days', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Contains campaign related information', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => '_gat_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '1 ' . __('minute', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Read and filter requests from bots.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => true,
                    ],
                    [
                        'name' => '_utma',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '2 ' . __('years', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to distinguish users and sessions.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_utmb',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '30 ' . __('minutes', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to determine new sessions/visits.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_utmc',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Operates in conjunction with the _utmb cookie to determine whether the user was in a new session/visit.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_utmt',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '10 ' . __('minutes', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Used to throttle request rate.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                    [
                        'name' => '_utmz',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '6 ' . __('months', 'otomaties-cookie-consent'),
                        'description' => __('Google Analytics: Stores the traffic source or campaign that explains how the user reached your site.', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                        'regex' => false,
                    ],
                ],
            ],
            'advertising' => [
                'name' => __('Advertising', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_advertising_title'),
                'defaultDescription' => DefaultStrings::get('occ_advertising_description'),
                'commonScripts' => [],
            ],
            'personalization' => [
                'name' => __('Personalization', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_personalization_title'),
                'defaultDescription' => DefaultStrings::get('occ_personalization_description'),
                'commonScripts' => [],
            ],
            'security' => [
                'name' => __('Security', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_security_title'),
                'defaultDescription' => DefaultStrings::get('occ_security_description'),
                'commonScripts' => [],
            ]
        ];
        foreach ($categories as $categoryKey => $category) {
            $cookieConsentCategorieSettings
                ->addTab($categoryKey, [
                    'label' => $category['name']
                ])
                ->addText('occ_' . $categoryKey . '_title', [
                    'label' => __('Title', 'otomaties-cookie-consent'),
                    'default_value' => $category['defaultTitle'],
                    'wpml_cf_preferences' => 2,
                ])
                ->addText('occ_' . $categoryKey . '_description', [
                    'label' => __('Description', 'otomaties-cookie-consent'),
                    'default_value' => $category['defaultDescription'],
                    'wpml_cf_preferences' => 2,
                ]);
            $currentLanguage = apply_filters('wpml_current_language', 'en');
            $defaultLanguage = apply_filters('wpml_default_language', 'en');
            if ($currentLanguage === $defaultLanguage) {
                $cookieConsentCategorieSettings->addRepeater('occ_' . $categoryKey . '_cookie_table', [
                        'label' => __('Cookie table', 'otomaties-cookie-consent'),
                        'button_label' => __('Add cookie', 'otomaties-cookie-consent'),
                        'wpml_cf_preferences' => 1,
                    ])
                        ->addText('name', [
                            'label' => __('Name', 'otomaties-cookie-consent'),
                            'wpml_cf_preferences' => 1,
                        ])
                        ->addText('domain', [
                            'label' => __('Domain', 'otomaties-cookie-consent'),
                            'wpml_cf_preferences' => 1,
                        ])
                        ->addText('expiration', [
                            'label' => __('Expiration', 'otomaties-cookie-consent'),
                            'wpml_cf_preferences' => 1,
                        ])
                        ->addText('description', [
                            'label' => __('Description', 'otomaties-cookie-consent'),
                            'wpml_cf_preferences' => 1,
                        ])
                        ->addTrueFalse('regex', [
                            'label' => __('Regex', 'otomaties-cookie-consent'),
                            'wpml_cf_preferences' => 1,
                        ])
                    ->endRepeater()
                    ->addMessage(
                        'occ_' . $categoryKey . '_common_scripts',
                        $this->cookiearrayToTable($category['commonScripts'], $categoryKey),
                        ['label' => sprintf(__('Common %s scripts', 'otomaties-cookie-consent'), $categoryKey)]
                    );
                
                $cookieConsentCategorieSettings->addRepeater('occ_' . $categoryKey . '_block_scripts', [
                    'label' => __('Block scripts'),
                    'instructions' => __('This plugin can automatically add the correct cookie categorie for scripts enqueued through <code>wp_enqueue_script()</code>. You can find the ID in the page source or the first parameter of <code>wp_enqueue_script()</code>', 'otomaties-cookie-consent'), // phpcs:ignore Generic.Files.LineLength
                    'button_label' => __('Add cookie', 'otomaties-cookie-consent'),
                    'wpml_cf_preferences' => 1,
                ])
                    ->addText('script_id', [
                        'label' => __('Script ID', 'otomaties-cookie-consent'),
                        'wpml_cf_preferences' => 1,
                    ])
                ->endRepeater()
                ->addMessage(
                    'occ_adding_' . $categoryKey . '_scripts_manually',
                    sprintf(__('Add <code>type="text/plain" category="%s"</code> to your script tag.', 'otomaties-cookie-consent'), $categoryKey), // phpcs:ignore Generic.Files.LineLength
                    ['label' => sprintf(__('Adding %s scripts manually', 'otomaties-cookie-consent'), $categoryKey)]
                );
            } else {
                $cookieConsentCategorieSettings->addMessage(
                    'occ_' . $categoryKey . '_table_in_default_language_message',
                    sprintf(__('The cookie table is only available in the default language (%s).', 'otomaties-cookie-consent'), $defaultLanguage), // phpcs:ignore Generic.Files.LineLength
                    ['label' => __('Cookie table', 'otomaties-cookie-consent')]
                );
            }
        }
        $cookieConsentCategorieSettings
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentCategorieSettings->build());

        // Extra information
        $cookieConsentExtraInformation = new FieldsBuilder('cookie-consent-extra-information', [
            'title' => __('Extra information', 'otomaties-cookie-consent'),
            'menu_order' => -1,
            'position' => 'side'
        ]);
        $extraInformation = '<ul>';
        $extraInformation .= '<li>';
        $extraInformation .=  __('Add <code>c_darkmode</code> to <code>&lt;body&gt;</code> in order to enable darkmode.', 'otomaties-cookie-consent'); // phpcs:ignore Generic.Files.LineLength
        $extraInformation .= '</li>';
        $extraInformation .= '<li>';
        $extraInformation .= sprintf(__('%s is automatically added to %s', 'otomaties-cookie-consent'), '<code>type="text/plain" category="analytics"</code>', '<strong><a target="_blank" href="https://wordpress.org/plugins/duracelltomi-google-tag-manager/">Google Tag Manager for WordPress</a> ' . __('by', 'otomaties-cookie-consent') . ' Thomas Geiger</strong>'); // phpcs:ignore Generic.Files.LineLength
        $extraInformation .= '</li>';
        $extraInformation .= '<li>';
        $extraInformation .= sprintf('<a href="%s" target="_blank">%s</a>', 'https://orestbida.com/demo-projects/cookieconsent/', __('Documentation', 'otomaties-cookie-consent')); // phpcs:ignore Generic.Files.LineLength
        $extraInformation .= '</li>';
        $extraInformation .= '</ul>';
        $cookieConsentExtraInformation
            ->addMessage('occ_extra_information', $extraInformation, [
                'label' => __('Extra information', 'otomaties-cookie-consent')
            ])
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentExtraInformation->build());
    }

    public function cookiearrayToTable(array $array, string $category) : string
    {
        ob_start();
        ?>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e('Name', 'otomaties-cookie-consent'); ?></th>
                        <th><?php _e('Domain', 'otomaties-cookie-consent'); ?></th>
                        <th><?php _e('Expiration', 'otomaties-cookie-consent'); ?></th>
                        <th><?php _e('Description', 'otomaties-cookie-consent'); ?></th>
                        <th><?php _e('Regex', 'otomaties-cookie-consent'); ?></th>
                        <th><?php _e('Actions', 'otomaties-cookie-consent'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($array)) : ?>
                        <?php foreach ($array as $key => $cookie) : ?>
                            <tr class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>">
                                <td class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>--name">
                                    <?php echo $cookie['name']; ?>
                                </td>
                                <td class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>--domain">
                                    <?php echo $cookie['domain']; ?>
                                </td>
                                <td class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>--expiration">
                                    <?php echo $cookie['expiration']; ?>
                                </td>
                                <td class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>--description">
                                    <?php echo $cookie['description']; ?>
                                </td>
                                <td class="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>--regex" data-regex="<?php echo $cookie['regex']; ?>"><?php  // phpcs:ignore Generic.Files.LineLength ?>
                                    <?php echo $cookie['regex'] ? '<span class="dashicons dashicons-yes-alt"></span>' : '<span class="dashicons dashicons-no-alt"></span>'; // phpcs:ignore Generic.Files.LineLength ?>
                                </td>
                                <td>
                                    <button class="button" data-category="<?php echo $category; ?>" data-common-cookie="common-cookie-<?php echo $category; ?>-<?php echo $key; ?>"><?php _e('Insert', 'otomaties-cookie-consent'); ?></button><?php  // phpcs:ignore Generic.Files.LineLength ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5"><?php _e('No common cookies'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php
        return ob_get_clean();
    }
}
