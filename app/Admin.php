<?php

namespace Otomaties\CookieConsent;

use Otomaties\CookieConsent\CookieDatabase\CookieList;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @subpackage CookieConsent/admin
 */

class Admin
{

    /**
     * The ID of this plugin.
     *
     * @var      string    $pluginName    The ID of this plugin.
     */
    private $pluginName;

    /**
     * The version of this plugin.
     *
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param      string    $pluginName       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($pluginName, $version)
    {

        $this->pluginName = $pluginName;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->pluginName, Assets::find('css/admin.css'), [], $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->pluginName, Assets::find('js/admin.js'), [], $this->version, false);
    }

    public function addCookies()
    {
        if (!current_user_can('manage_options')) {
            wp_send_json_error('You are not logged in');
            exit;
        }
        // get csv file from directory
        $cookieDatabase = new CookieList(dirname(__FILE__, 2) . '/open-cookie-database.csv');
        foreach ($_POST['cookies'] as $cookieName) {
            $cookie = $cookieDatabase->find($cookieName);
            
            if ($cookie) {
                $category = new Category($cookie->category());
                $cookieFound = false;
                foreach ($category->cookies() as $existingCookie) {
                    if ($existingCookie['name'] === $cookie->name()) {
                        $cookieFound = true;
                        break;
                    }
                }
                if (!$cookieFound) {
                    $category->addCookie($cookie);
                } else {
                    ray("Cookie already exists: $cookieName");
                }
            } else {
                ray("Cookie not found: $cookieName");
            }
        }
        wp_send_json_success('Cookies added');
    }
}
