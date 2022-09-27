<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\Frontend;

final class FrontendTest extends TestCase
{

    private $frontend;
    private $pluginName = 'otomaties-cookie-consent';
    private $version = '1.0.0';

    protected function setUp() : void
    {
        $this->frontend = new Frontend($this->pluginName, $this->version);
    }

    public function testFrontendScriptsAreEnqueued()
    {
        $this->setup();
        $this->frontend->enqueueScripts();
        $this->assertTrue(wp_script_is($this->pluginName, 'enqueued'));
        $this->assertTrue(wp_script_is($this->pluginName, 'localized'));
    }

    public function testFrontendStylesAreEnqueued()
    {
        $this->setup();
        $this->frontend->enqueueStyles();
        $this->assertTrue(wp_style_is($this->pluginName, 'enqueued'));
    }

    public function testIfScriptIsDeferred() {
        $tag = '<script src="http://example.com/wp-content/plugins/otomaties-cookie-consent/public/js/otomaties-cookie-consent.js?ver=1.0.0" id="otomaties-cookie-consent-js"></script>';
        $this->assertEquals($this->frontend->deferScript($tag, $this->pluginName), '<script defer src="http://example.com/wp-content/plugins/otomaties-cookie-consent/public/js/otomaties-cookie-consent.js?ver=1.0.0" id="otomaties-cookie-consent-js"></script>');
    }

    public function testIfScriptIsNotDeferred() {
        $tag = '<script src="http://example.com/whatever.js" id="whatever"></script>';
        $this->assertEquals($this->frontend->deferScript($tag, 'not-otomaties-cookie-consent'), $tag);
    }

    public function testCookieCategoryIsAddedToScripts() {
        $tag = '<script id=\'please-add-category-js\' src="blocked.js">alert("blocked");</script>';
        $this->assertEquals($this->frontend->addCookieCategoryToScripts($tag, 'please-add-category'), '<script id=\'please-add-category-js\'  type="text/plain" data-cookiecategory="necessary" src="blocked.js">alert("blocked");</script>');
    }

    public function testCookieCategoryIsNotAddedToScripts() {
        $tag = '<script id=\'please-dont-add-category-js\' src="not-blocked.js">alert("not blocked");</script>';
        $this->assertEquals($this->frontend->addCookieCategoryToScripts($tag, 'not-please-add-category'), $tag);
    }

    public function testAnalyticsCategoryIsAddedToGtm4WpScript() {
        $tag = '<script src="gtm4wp.js"></script>';
        $this->assertEquals('<script type="text/plain" data-cookiecategory="analytics" src="gtm4wp.js"></script>', $this->frontend->addGtm4WpScriptToAnalyticScripts($tag));


        global $consentMode;
        $consentMode = true;
        $this->assertEquals('<script src="gtm4wp.js"></script>', $this->frontend->addGtm4WpScriptToAnalyticScripts($tag));
    }

    public function testGtm4WpisUpdatedAndPrinted() {
        $this->frontend->customGtm4WpScript();
        global $actions;

        ob_start();
        gtm4wp_wp_header_begin();
        $expected = ob_get_clean();

        $this->expectOutputString($this->frontend->addGtm4WpScriptToAnalyticScripts($expected));
        $actions['wp_head'][0]['function']();
    }

    public function testIfCookieSettingsIsAddedToMenu() {
        $items = '<li><a href="http://example.com">Home</a></li>';
        
        $args = (object) array('menu' => [
            'term_id' => 69
        ]);
        $args = new stdClass();
        $menu = new stdClass();
        $menu->term_id = 69;
        $args->menu = $menu;
        $items = $this->frontend->addCookieSettingsMenuItem($items, $args);
        $this->assertEquals($items, '<li><a href="http://example.com">Home</a></li><li class="menu-item menu-item__cookie-settings"><a href="#" aria-label="Review cookie settings" data-cc="c-settings">Cookie settings</a></li>');
    }

    public function testIfConsentModeIsPrinted() {
        global $consentMode;
        $consentMode = true;

        ob_start();
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
            });
        </script>
        <?php
        $expected = ob_get_clean();
        $this->expectOutputString($expected);
        $this->frontend->addGoogleConsentMode();

        $consentMode = false;
        $this->assertNull($this->frontend->addGoogleConsentMode());
    }
}
