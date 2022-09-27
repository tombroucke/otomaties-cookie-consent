<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\Category;
use Otomaties\CookieConsent\Settings;

final class SettingsTest extends TestCase
{

    private $settings;

    protected function setUp() : void
    {
        $this->settings = new Settings();
    }

    public function testCategoryCanBeCreatedByKey() : void
    {
        $this->assertInstanceOf(Category::class, $this->settings->category('necessary'));
    }

    public function testConsentModalSettings() : void
    {
        $this->assertIsArray($this->settings->consentModal());
        $this->assertArrayHasKey('title', $this->settings->consentModal());
        $this->assertArrayHasKey('description', $this->settings->consentModal());
        $this->assertArrayHasKey('accept', $this->settings->consentModal());
        $this->assertArrayHasKey('reject', $this->settings->consentModal());

        $this->assertIsString($this->settings->consentModal()['title']);
        $this->assertIsString($this->settings->consentModal()['description']);
        $this->assertIsString($this->settings->consentModal()['accept']);
        $this->assertIsString($this->settings->consentModal()['reject']);
    }

    public function testSettingsModalSettings() : void {

        $this->assertIsArray($this->settings->settingsModal());
        $this->assertArrayHasKey('title', $this->settings->settingsModal());
        $this->assertArrayHasKey('saveSettingsBtn', $this->settings->settingsModal());
        $this->assertArrayHasKey('acceptAllBtn', $this->settings->settingsModal());
        $this->assertArrayHasKey('rejectAllBtn', $this->settings->settingsModal());
        $this->assertArrayHasKey('closeBtnlabel', $this->settings->settingsModal());
        $this->assertArrayHasKey('cookieTableHeaders', $this->settings->settingsModal());

        $this->assertIsString($this->settings->settingsModal()['title']);
        $this->assertIsString($this->settings->settingsModal()['saveSettingsBtn']);
        $this->assertIsString($this->settings->settingsModal()['acceptAllBtn']);
        $this->assertIsString($this->settings->settingsModal()['rejectAllBtn']);
        $this->assertIsString($this->settings->settingsModal()['closeBtnlabel']);
        $this->assertIsArray($this->settings->settingsModal()['cookieTableHeaders']);

        $this->assertArrayHasKey('name', $this->settings->settingsModal()['cookieTableHeaders']);
        $this->assertArrayHasKey('domain', $this->settings->settingsModal()['cookieTableHeaders']);
        $this->assertArrayHasKey('expiration', $this->settings->settingsModal()['cookieTableHeaders']);
        $this->assertArrayHasKey('description', $this->settings->settingsModal()['cookieTableHeaders']);
    }

    public function testUsage() : void
    {
        $this->assertIsArray($this->settings->usage());
        $this->assertArrayHasKey('title', $this->settings->usage());
        $this->assertArrayHasKey('description', $this->settings->usage());
        $this->assertStringContainsString('For more details relative to cookies and other sensitive data', $this->settings->usage()['description']);
        
        global $privacyPolicyUrl;
        $privacyPolicyUrl = '';
        $this->assertStringNotContainsString('For more details relative to cookies and other sensitive data', $this->settings->usage()['description']);
    }

    public function testMoreInformation() : void {
        $this->assertIsArray($this->settings->moreInformation());
        $this->assertArrayHasKey('title', $this->settings->moreInformation());
        $this->assertArrayHasKey('description', $this->settings->moreInformation());
    }

    public function testBlocksIsDefined() : void
    {
        $this->assertIsArray($this->settings->blocks());
        $this->assertArrayHasKey('usage', $this->settings->blocks());
        $this->assertArrayHasKey('necessary', $this->settings->blocks());
        $this->assertArrayHasKey('analytics', $this->settings->blocks());
        $this->assertArrayHasKey('advertising', $this->settings->blocks());
        $this->assertArrayHasKey('personalization', $this->settings->blocks());
        $this->assertArrayHasKey('security', $this->settings->blocks());

        $this->assertArrayHasKey('moreInformation', $this->settings->blocks());

    }

    public function testGuiOptionsHasEntries() : void
    {
        $this->assertIsArray($this->settings->guiOptions());
        $this->assertArrayHasKey('consentModal', $this->settings->guiOptions());
        $this->assertArrayHasKey('layout', $this->settings->guiOptions()['consentModal']);
        $this->assertArrayHasKey('position', $this->settings->guiOptions()['consentModal']);
        $this->assertArrayHasKey('transition', $this->settings->guiOptions()['consentModal']);
        $this->assertArrayHasKey('swapButtons', $this->settings->guiOptions()['consentModal']);
        $this->assertArrayHasKey('settingsModal', $this->settings->guiOptions());
        $this->assertArrayHasKey('layout', $this->settings->guiOptions()['settingsModal']);
        $this->assertArrayHasKey('position', $this->settings->guiOptions()['settingsModal']);
        $this->assertArrayHasKey('transition', $this->settings->guiOptions()['settingsModal']);

        $this->assertIsBool($this->settings->guiOptions()['consentModal']['swapButtons']);
    }

    public function testScriptVariables() : void 
    {
        $this->assertIsArray($this->settings->scriptVariables());
        $this->assertArrayHasKey('locale', $this->settings->scriptVariables());
        $this->assertArrayHasKey('guiOptions', $this->settings->scriptVariables());
        $this->assertArrayHasKey('strings', $this->settings->scriptVariables());
        $this->assertArrayHasKey('gtmConsentMode', $this->settings->scriptVariables());
        $this->assertArrayHasKey('showAllCategories', $this->settings->scriptVariables());

        $this->assertIsArray($this->settings->scriptVariables()['strings']);
        $this->assertIsBool($this->settings->scriptVariables()['gtmConsentMode']);
        $this->assertIsBool($this->settings->scriptVariables()['showAllCategories']);
    }
}
