<?php

namespace Otomaties\CookieConsent;

use Otomaties\CookieConsent\Database\RecordsOfConsent;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 */

class Updater
{

    public function __construct(private string $pluginName, private string $version)
    {
    }

    public function migrate() {
        $dbVersion = get_option($this->pluginName . '_version');
        if (version_compare($dbVersion, '2.2.0', '<')) {
            RecordsOfConsent::create();
            update_option($this->pluginName . '_version', $this->version);
        }
    }
    
}
