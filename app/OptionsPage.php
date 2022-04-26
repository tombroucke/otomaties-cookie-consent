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
    public function addOptionsPage()
    {
        
        acf_add_options_page(
            array(
                'page_title'    => __('Cookie consent', 'otomaties-cookie-consent'),
                'menu_title'    => __('Cookie consent', 'otomaties-cookie-consent'),
                'menu_slug'     => 'cookie-consent-settings',
                'icon_url'      => Assets::find('images/cookie.png'),
                'capability'    => apply_filters('otomaties_cookie_consent_settings_capability', 'edit_posts'),
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
        $cookieConsentSettings = new FieldsBuilder('cookie-consent-settings', ['title' => __('Cookie consent settings', 'otomaties-cookie-consent'), 'menu_order' => -1]);
        $cookieConsentSettings
            ->addTab('occ_consent_modal', [
                'label' => __('Consent modal', 'otomaties-cookie-consent')
            ])
                ->addText('occ_consent_modal_title', [
                    'label' => __('Title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_title'),
                ])
                ->addTextarea('occ_consent_modal_description', [
                    'label' => __('Description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_description'),
                ])
                ->addText('occ_consent_modal_settings_button_label', [
                    'label' => __('Settings button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_settings_button_label'),
                ])
                ->addText('occ_consent_modal_accept_button_label', [
                    'label' => __('Accept button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_accept_button_label'),
                ])
                ->addText('occ_consent_modal_reject_button_label', [
                    'label' => __('Reject button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_consent_modal_reject_button_label'),
                ])
                ->addSelect('occ_consent_modal_trigger_in_menu', [
                    'label' => __('Add cookie settings to menu', 'otomaties-cookie-consent'),
                    'choices' => $navMenus,
                    'allow_null' => true,
                ])
                ->addSelect('occ_consent_modal_layout', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'cloud' => __('Cloud', 'otomaties-cookie-consent'),
                        'box' => __('Box', 'otomaties-cookie-consent'),
                        'bar' => __('Bar', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'cloud'
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
                    'default_value' => 'bottom center'
                ])
                ->addSelect('occ_consent_modal_transition', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'zoom' => __('Zoom', 'otomaties-cookie-consent'),
                        'slide' => __('Slide', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'slide'
                ])
                ->addTrueFalse('occ_consent_modal_swap_buttons', [
                    'label' => __('Swap buttons', 'otomaties-cookie-consent'),
                    'message' => __('Swap reject/accept buttons', 'otomaties-cookie-consent')
                ])
            ->addTab('occ_settings_modal', [
                'label' => __('Settings modal', 'otomaties-cookie-consent')
            ])
                ->addText('occ_settings_modal_title', [
                    'label' => __('Title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_title'),
                ])
                ->addText('occ_settings_modal_cookie_usage_title', [
                    'label' => __('Cookie usage title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_cookie_usage_title'),
                ])
                ->addTextarea('occ_settings_modal_cookie_usage_description', [
                    'label' => __('Cookie usage description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_cookie_usage_description'),
                ])
                ->addText('occ_settings_modal_more_information_title', [
                    'label' => __('More information title', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_more_information_title'),
                ])
                ->addPostObject('occ_settings_modal_contact_page', [
                    'label' => __('Contact page', 'otomaties-cookie-consent'),
                    'post_type' => 'page',
                    'return_format' => 'ID',
                    'allow_null' => true,
                ])
                ->addTextarea('occ_settings_modal_more_information_description', [
                    'label' => __('More information description', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_more_information_description'),
                ])
                ->addText('occ_settings_modal_save_settings_button_label', [
                    'label' => __('Save settings button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_save_settings_button_label'),
                ])
                ->addText('occ_settings_modal_accept_all_button_label', [
                    'label' => __('Accept all button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_accept_all_button_label'),
                ])
                ->addText('occ_settings_modal_reject_all_button_label', [
                    'label' => __('Reject all button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_reject_all_button_label'),
                ])
                ->addText('occ_settings_modal_close_button_label', [
                    'label' => __('Close button label', 'otomaties-cookie-consent'),
                    'default_value' => DefaultStrings::get('occ_settings_modal_close_button_label'),
                ])
                ->addSelect('occ_settings_modal_layout', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'box' => __('Box', 'otomaties-cookie-consent'),
                        'bar' => __('Bar', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'box'
                ])
                ->addSelect('occ_settings_modal_position', [
                    'label' => __('Layout', 'otomaties-cookie-consent'),
                    'choices' => [
                        'left' => __('Left', 'otomaties-cookie-consent'),
                        'right' => __('Right', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'right'
                ])
                ->addSelect('occ_settings_modal_transition', [
                    'label' => __('Transition', 'otomaties-cookie-consent'),
                    'choices' => [
                        'zoom' => __('Zoom', 'otomaties-cookie-consent'),
                        'slide' => __('Slide', 'otomaties-cookie-consent'),
                    ],
                    'default_value' => 'slide'
                ])
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentSettings->build());

        // Category settings
        $cookieConsentCategorieSettings = new FieldsBuilder('cookie-consent-category-settings', ['title' => __('Cookie categories', 'otomaties-cookie-consent')]);
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
                        'description' => __('Necessary for the shopping cart functionality on the website.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => 'woocommerce_cart_hash',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Necessary for the shopping cart functionality on the website to remember the chosen products - This also allows the website to promote related products to the visitor, based on the content of the shopping cart.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => 'woocommerce_items_in_cart',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => __('session', 'otomaties-cookie-consent'),
                        'description' => __('Contains information about the cart as a whole and help WooCommerce know when the cart data changes.', 'otomaties-cookie-consent'),
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
                        'description' => __('Contains a unique code for each customer so that it knows where to find the cart data in the database for each customer.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('Stores your authentication details. Its use is limited to the admin area.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_logged_in_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('This cookie indicates when you’re logged in, and who you are, for most interface use.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => 'wordpress_settings-*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => sprintf(__('%d weeks', 'otomaties-cookie-consent'), 2),
                        'description' => __('WordPress also sets a few wp-settings-{time}-[UID] cookies. The number on the end is your individual user ID from the user’s database table. This is used to customize your view of admin interface, and possibly also the main site interface.', 'otomaties-cookie-consent'),
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
                        'description' => __('Used to distinguish users.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => '_gid',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '24 ' . __('hours', 'otomaties-cookie-consent'),
                        'description' => __('Used to distinguish users.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => '_ga_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '2 ' . __('years', 'otomaties-cookie-consent'),
                        'description' => __('Used to persist session state.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => '_gac_gb_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '90 ' . __('days', 'otomaties-cookie-consent'),
                        'description' => __('Contains campaign related information', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => '_gat',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '1 ' . __('minute', 'otomaties-cookie-consent'),
                        'description' => __('Used to distinguish users.', 'otomaties-cookie-consent'),
                        'regex' => false,
                    ],
                    [
                        'name' => '_gac_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '90 ' . __('days', 'otomaties-cookie-consent'),
                        'description' => __('Contains campaign related information', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                    [
                        'name' => '_gat_*',
                        'domain' => $_SERVER['SERVER_NAME'] ?? '/',
                        'expiration' => '1 ' . __('minute', 'otomaties-cookie-consent'),
                        'description' => __('Read and filter requests from bots.', 'otomaties-cookie-consent'),
                        'regex' => true,
                    ],
                ],
            ],
            'targeting' => [
                'name' => __('Targeting', 'otomaties-cookie-consent'),
                'defaultTitle' => DefaultStrings::get('occ_targeting_title'),
                'defaultDescription' => DefaultStrings::get('occ_targeting_description'),
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
                ])
                ->addText('occ_' . $categoryKey . '_description', [
                    'label' => __('Description', 'otomaties-cookie-consent'),
                    'default_value' => $category['defaultDescription'],
                ])
                ->addRepeater('occ_' . $categoryKey . '_cookie_table', [
                    'label' => __('Cookie table', 'otomaties-cookie-consent'),
                    'button_label' => __('Add cookie', 'otomaties-cookie-consent'),
                ])
                    ->addText('name', [
                        'label' => __('Name', 'otomaties-cookie-consent')
                    ])
                    ->addText('domain', [
                        'label' => __('Domain', 'otomaties-cookie-consent')
                    ])
                    ->addText('expiration', [
                        'label' => __('Expiration', 'otomaties-cookie-consent')
                    ])
                    ->addText('description', [
                        'label' => __('Description', 'otomaties-cookie-consent')
                    ])
                    ->addTrueFalse('regex', [
                        'label' => __('Regex', 'otomaties-cookie-consent')
                    ])
                ->endRepeater()
                ->addMessage('occ_' . $categoryKey . '_common_scripts', $this->cookiearrayToTable($category['commonScripts']), [
                    'label' => sprintf(__('Common %s scripts', 'otomaties-cookie-consent'), $categoryKey)
                ])
                ->addRepeater('occ_' . $categoryKey . '_block_scripts', [
                    'label' => __('Block scripts'),
                    'instructions' => __('This plugin can automatically add the correct cookie categorie for scripts enqueued through <code>wp_enqueue_script()</code>. You can find the ID in the page source or the first parameter of <code>wp_enqueue_script()</code>', 'otomaties-cookie-consent'),
                    'button_label' => __('Add cookie', 'otomaties-cookie-consent'),
                ])
                    ->addText('script_id', [
                        'label' => __('Script ID', 'otomaties-cookie-consent')
                    ])
                ->endRepeater()
                ->addMessage('occ_adding_' . $categoryKey . '_scripts_manually', sprintf(__('Add <code>type="text/plain" data-cookiecategory="%s"</code> to your script tag.', 'otomaties-cookie-consent'), $categoryKey), [
                    'label' => sprintf(__('Adding %s scripts manually', 'otomaties-cookie-consent'), $categoryKey)
                ]);
        }
        $cookieConsentCategorieSettings
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentCategorieSettings->build());

        // Extra information
        $cookieConsentExtraInformation = new FieldsBuilder('cookie-consent-extra-information', ['title' => __('Extra information', 'otomaties-cookie-consent'), 'menu_order' => -1, 'position' => 'side']);
        $extraInformation = '<ul>';
        $extraInformation .= '<li>';
        $extraInformation .=  __('Add <code>c_darkmode</code> to <code>&lt;body&gt;</code> in order to enable darkmode.', 'otomaties-cookie-consent');
        $extraInformation .= '</li>';
        $extraInformation .= '<li>';
        $extraInformation .= sprintf(__('%s is automatically added to %s', 'otomaties-cookie-consent'), '<code>type="text/plain" data-cookiecategory="analytics"</code>', '<strong><a target="_blank" href="https://wordpress.org/plugins/duracelltomi-google-tag-manager/">Google Tag Manager for WordPress</a> ' . __('by', 'otomaties-cookie-consent') . ' Thomas Geiger</strong>');
        $extraInformation .= '</li>';
        $extraInformation .= '<li>';
        $extraInformation .= sprintf('<a href="%s" target="_blank">%s</a>', 'https://orestbida.com/demo-projects/cookieconsent/', __('Documentation', 'otomaties-cookie-consent'));
        $extraInformation .= '</li>';
        $extraInformation .= '</ul>';
        $cookieConsentExtraInformation
            ->addMessage('occ_extra_information', $extraInformation, [
                'label' => __('Extra information', 'otomaties-cookie-consent')
            ])
            ->setLocation('options_page', '==', 'cookie-consent-settings');
        acf_add_local_field_group($cookieConsentExtraInformation->build());
    }

    public function cookiearrayToTable(array $array)
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
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($array)) : ?>
                        <?php foreach ($array as $cookie) : ?>
                            <tr>
                                <td>
                                    <?php echo $cookie['name']; ?>
                                </td>
                                <td>
                                    <?php echo $cookie['domain']; ?>
                                </td>
                                <td>
                                    <?php echo $cookie['expiration']; ?>
                                </td>
                                <td>
                                    <?php echo $cookie['description']; ?>
                                </td>
                                <td>
                                    <?php echo $cookie['regex'] ? '<span class="dashicons dashicons-yes-alt"></span>' : '<span class="dashicons dashicons-no-alt"></span>'; ?>
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
