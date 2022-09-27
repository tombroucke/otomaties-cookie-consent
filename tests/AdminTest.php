<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\Admin;

final class AdminTest extends TestCase
{

    private $admin;
    private $pluginName = 'otomaties-cookie-consent';
    private $version = '1.0.0';

    protected function setUp() : void
    {
        $this->admin = new Admin($this->pluginName, $this->version);
    }

    public function testAdminScriptsAreEnqueued()
    {
        $this->setup();
        $this->admin->enqueueScripts();
        $this->assertTrue(wp_script_is($this->pluginName, 'enqueued'));
    }

    public function testAdminStylesAreEnqueued()
    {
        $this->setup();
        $this->admin->enqueueStyles();
        $this->assertTrue(wp_style_is($this->pluginName, 'enqueued'));
    }
}
