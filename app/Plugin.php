<?php

namespace Otomaties\CookieConsent;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 */

class Plugin
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The current version of the plugin.
     *
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * The name of the plugin
     *
     * @var string
     */
    protected $pluginName;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     */
    public function __construct($pluginData)
    {
        $this->version = $pluginData['Version'];
        $this->pluginName = $pluginData['pluginName'];
        $this->loader = new Loader();

        $this->setLocale();
        $this->defineAdminHooks();
        $this->defineFrontendHooks();
        $this->addOptionsPage();
        $this->addShortcodes();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     */
    private function setLocale()
    {
        $plugin_i18n = new I18n();
        $plugin_i18n->loadTextdomain();
    }

    /**
     * Register all of the hooks related to the admin-facing functionality
     * of the plugin.
     *
     */
    private function defineAdminHooks() : void
    {

        $admin = new Admin($this->getPluginName(), $this->getVersion());
        $this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueScripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     */
    private function defineFrontendHooks() : void
    {
        $frontend = new Frontend($this->getPluginName());
        $this->loader->addAction('wp_enqueue_scripts', $frontend, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $frontend, 'enqueueScripts');
        $this->loader->addAction('script_loader_tag', $frontend, 'deferScript', 10, 2);
        $this->loader->addAction('script_loader_tag', $frontend, 'addCookieCategoryToScripts', 10, 2);
        $this->loader->addFilter('gtm4wp_get_the_gtm_tag', $frontend, 'addGtm4WpScriptToAnalyticScripts'); // phpcs:ignore Generic.Files.LineLength
        $this->loader->addAction('template_redirect', $frontend, 'customGtm4WpScript');
        $this->loader->addFilter('wp_nav_menu_items', $frontend, 'addCookieSettingsMenuItem', 10, 2);
        $this->loader->addFilter('wp_head', $frontend, 'addGoogleConsentMode', 10, 2);
    }

    private function addOptionsPage() : void
    {
        $options = new OptionsPage();
        $this->loader->addAction('acf/init', $options, 'addOptionsPage');
        $this->loader->addAction('acf/init', $options, 'addOptionsFields');
    }

    private function addShortcodes() : void
    {
        $shortcodes = new Shortcodes();
        add_shortcode('cookie-table', [$shortcodes, 'cookieTable']);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     */
    public function run() : void
    {
        $this->loader->run();
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Loader    Orchestrates the hooks of the plugin.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    public function getPluginName() : string
    {
        return $this->pluginName;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function getVersion() : string
    {
        return $this->version;
    }
}
