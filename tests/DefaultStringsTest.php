<?php

declare(strict_types=1);

use Otomaties\CookieConsent\DefaultStrings;
use PHPUnit\Framework\TestCase;

final class DefaultStringsTest extends TestCase
{
    public function test_if_get_returns_correct_string()
    {
        $this->assertEquals(DefaultStrings::get('occ_consent_modal_title'), __('We use cookies 🍪', 'otomaties-cookie-consent'));
        $this->assertEquals(DefaultStrings::get('occ_necessary_title'), __('Strictly necessary cookies', 'otomaties-cookie-consent'));
    }

    public function test_if_get_returns_null_for_unset_key()
    {
        $this->assertNull(DefaultStrings::get('occ_non_existing_key'));
    }

    public function test_value_is_correct()
    {
        $this->assertEquals(DefaultStrings::value('occ_necessary_title'), __('Strictly necessary cookies', 'otomaties-cookie-consent'));
    }
}
