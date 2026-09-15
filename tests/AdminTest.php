<?php

declare(strict_types=1);

use Otomaties\CookieConsent\Admin;
use PHPUnit\Framework\TestCase;

final class AdminTest extends TestCase
{
    private $admin;

    private $pluginName = 'otomaties-cookie-consent';

    private $version = '1.0.0';

    protected function setUp(): void
    {
        $this->admin = new Admin($this->pluginName, $this->version);
    }

    public function test_admin_scripts_are_enqueued()
    {
        $this->setup();
        $this->admin->enqueueScripts();
        $this->assertTrue(wp_script_is($this->pluginName, 'enqueued'));
    }

    public function test_admin_styles_are_enqueued()
    {
        $this->setup();
        $this->admin->enqueueStyles();
        $this->assertTrue(wp_style_is($this->pluginName, 'enqueued'));
    }
}
