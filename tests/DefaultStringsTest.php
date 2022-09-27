<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\DefaultStrings;

final class DefaultStringsTest extends TestCase
{
    public function testIfGetReturnsCorrectString() {
        $this->assertEquals(DefaultStrings::get('occ_consent_modal_title'), __('We use cookies 🍪', 'otomaties-cookie-consent'));
        $this->assertEquals(DefaultStrings::get('occ_necessary_title'), __('Strictly necessary cookies', 'otomaties-cookie-consent'));
    }

    public function testIfGetReturnsNullForUnsetKey() {
        $this->assertNull(DefaultStrings::get('occ_non_existing_key'));
    }

    public function testValueIsCorrect() {
        $this->assertEquals(DefaultStrings::value('occ_necessary_title'), __('Strictly necessary cookies', 'otomaties-cookie-consent'));
    }
}
