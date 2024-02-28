<?php

namespace Otomaties\CookieConsent;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @subpackage CookieConsent/public
 */

class Frontend
{

    /**
     * The ID of this plugin.
     *
     * @var      string    $pluginName    The ID of this plugin.
     */
    private $pluginName;

    /**
     * Initialize the class and set its properties.
     *
     * @param      string    $pluginName       The name of the plugin.
     */
    public function __construct($pluginName)
    {

        $this->pluginName = $pluginName;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     */
    public function enqueueStyles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->pluginName, Assets::find('css/main.css'), [], null);
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     */
    public function enqueueScripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->pluginName, Assets::find('js/main.js'), [], null, true);
        $settings = new Settings();
        wp_localize_script($this->pluginName, 'otomatiesCookieConsent', $settings->scriptVariables());
    }

    public function deferScript($tag, $handle)
    {
        if ($handle !== $this->pluginName) {
            return $tag;
        }
         
        return str_replace(' src=', ' defer src=', $tag);
    }
    
    public function addCookieCategoryToScripts($tag, $handle)
    {
        foreach (Settings::categories() as $categoryKey => $category) {
            $blockScripts = array_filter((array)Settings::generalOptionField('occ_' . $categoryKey . '_block_scripts'));
            if (count($blockScripts) === 0) {
                continue;
            }

            foreach ($blockScripts as $blockScript) {
                if (isset($blockScript['script_id'])
                    && $blockScript['script_id'] != ''
                    && (strpos($tag, 'id=\'' . $blockScript['script_id'] . '-js\'') !== false || strpos($tag, 'id="' . $blockScript['script_id'] . '-js"') !== false)
                ) {
                    return str_replace(
                        ' src=',
                        '  type="text/plain" data-category="' . $categoryKey . '" src=',
                        $tag
                    );
                }
            }
        }
        return $tag;
    }

    public function addGtm4WpScriptToAnalyticScripts($tag)
    {
        if (Settings::generalOptionField('occ_gtm_consent_mode')) {
            return $tag;
        }
        $tag = str_replace('<script', '<script type="text/plain" data-category="analytics"', $tag);
        return $tag;
    }

    public function customGtm4WpScript()
    {

        if (!function_exists('gtm4wp_wp_header_begin')) {
            return;
        }
        
        $gtm4wp_header_begin_prior = 10;
        $loadEarly = constant('GTM4WP_OPTION_LOADEARLY');
        if (isset($GLOBALS['gtm4wp_options']) && $GLOBALS['gtm4wp_options'][$loadEarly]) {
            $gtm4wp_header_begin_prior = 2;
        }
        remove_action('wp_head', 'gtm4wp_wp_header_begin', $gtm4wp_header_begin_prior);
        add_action('wp_head', function () {
            ob_start();
            gtm4wp_wp_header_begin();
            $header = ob_get_clean();
            echo $this->addGtm4WpScriptToAnalyticScripts($header);
        }, $gtm4wp_header_begin_prior, 0);
    }


    public function addCookieSettingsMenuItem($items, $args)
    {
        $navMenu = get_field('occ_consent_modal_trigger_in_menu', 'option');
        if ($navMenu == 'term_id_' . $args->menu->term_id) {
            $items .= '<li class="menu-item menu-item__cookie-settings"><a href="#" aria-label="' . __('Review cookie settings', 'otomaties-cookie-consent') . '" data-cc="show-preferencesModal">' . __('Cookie settings', 'otomaties-cookie-consent') . '</a></li>'; // phpcs:ignore Generic.Files.LineLength
        }
        return $items;
    }

    public function addGoogleConsentMode()
    {
        if (!Settings::generalOptionField('occ_gtm_consent_mode')) {
            return;
        }
        ?>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }

            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'analytics_storage': 'denied',
                'functionality_storage': 'granted',
                'personalization_storage': 'denied',
                'security_storage': 'denied',
                'ad_user_data': 'denied',
                'ad_personalization': 'denied',
            });
        </script>
        <?php
    }
}
