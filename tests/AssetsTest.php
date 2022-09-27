<?php declare(strict_types=1);

use Otomaties\CookieConsent\Assets;
use PHPUnit\Framework\TestCase;

final class AssetsTest extends TestCase
{

    public function testAssetCanBeFound()
    {
        $this->assertEquals(Assets::find('js/app.js'), 'http://example.com/wp-content/plugins/otomaties-cookie-consent/public/js/app.js');
        $this->assertEquals(Assets::find('css/app.css'), 'http://example.com/wp-content/plugins/otomaties-cookie-consent/public/css/app.css');
        $this->assertEquals(Assets::find('unknown.css'), 'http://example.com/wp-content/plugins/otomaties-cookie-consent/public/unknown.css');
    }
}
