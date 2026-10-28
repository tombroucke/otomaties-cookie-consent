<?php

declare(strict_types=1);

use Otomaties\CookieConsent\CookieTable;
use PHPUnit\Framework\TestCase;

final class CookieTableTest extends TestCase
{
    private CookieTable $cookieTable;

    protected function setUp(): void
    {
        parent::setUp();
        global $fieldValues, $registeredFields;
        $fieldValues = [
            'occ_necessary_cookie_table' => [
                [
                    'name' => 'cc_cookie',
                    'domain' => 'example.com',
                    'expiration' => '182 days',
                    'description' => 'Tracks your cookie consent',
                    'regex' => false,
                ],
            ],
            'occ_analytics_cookie_table' => [
                [
                    'name' => '_ga_*',
                    'domain' => 'example.com',
                    'expiration' => '2 years',
                    'description' => 'Google Analytics',
                    'regex' => '1',
                ],
            ],
        ];
        $registeredFields = array_map(
            fn ($category) => 'field_cookie-consent-category-settings_occ_'.$category.'_cookie_table',
            ['necessary', 'analytics', 'advertising', 'personalization', 'security']
        );
        $this->cookieTable = new CookieTable;
    }

    protected function tearDown(): void
    {
        global $fieldValues, $registeredFields;
        $fieldValues = [];
        $registeredFields = [];
        parent::tearDown();
    }

    public function test_all_returns_cookies_of_all_categories()
    {
        $cookies = $this->cookieTable->all();

        $this->assertCount(2, $cookies);
        $this->assertEquals('necessary', $cookies[0]['category']);
        $this->assertEquals('analytics', $cookies[1]['category']);
        $this->assertTrue($cookies[1]['regex']);
    }

    public function test_all_filters_by_category()
    {
        $cookies = $this->cookieTable->all('analytics');

        $this->assertCount(1, $cookies);
        $this->assertEquals('_ga_*', $cookies[0]['name']);
    }

    public function test_find_returns_null_for_unknown_cookie()
    {
        $this->assertNull($this->cookieTable->find('unknown'));
    }

    public function test_create_appends_cookie_to_category()
    {
        $cookie = $this->cookieTable->create([
            'category' => 'advertising',
            'name' => '_fbp',
            'domain' => 'example.com',
        ]);

        $this->assertEquals([
            'category' => 'advertising',
            'name' => '_fbp',
            'domain' => 'example.com',
            'expiration' => '',
            'description' => '',
            'regex' => false,
        ], $cookie);
        $this->assertCount(1, $this->cookieTable->all('advertising'));
    }

    public function test_create_rejects_existing_name_in_other_category()
    {
        $result = $this->cookieTable->create(['category' => 'advertising', 'name' => 'cc_cookie']);

        $this->assertInstanceOf(WP_Error::class, $result);
        $this->assertEquals(409, $result->get_error_data()['status']);
    }

    public function test_create_fails_when_cookie_table_is_not_registered()
    {
        global $registeredFields;
        $registeredFields = [];

        $result = $this->cookieTable->create(['category' => 'advertising', 'name' => '_fbp']);

        $this->assertInstanceOf(WP_Error::class, $result);
        $this->assertEquals('occ_cookie_table_unavailable', $result->get_error_code());
    }

    public function test_update_changes_fields_in_place()
    {
        $cookie = $this->cookieTable->update('cc_cookie', ['description' => 'Updated', 'name' => 'cc_cookie']);

        $this->assertEquals('Updated', $cookie['description']);
        $this->assertEquals('182 days', $cookie['expiration']);
        $this->assertCount(1, $this->cookieTable->all('necessary'));
    }

    public function test_update_renames_cookie()
    {
        $cookie = $this->cookieTable->update('cc_cookie', ['name' => 'cc_cookie_v2']);

        $this->assertEquals('cc_cookie_v2', $cookie['name']);
        $this->assertNull($this->cookieTable->find('cc_cookie'));
    }

    public function test_update_rejects_rename_to_existing_name()
    {
        $result = $this->cookieTable->update('cc_cookie', ['name' => '_ga_*']);

        $this->assertInstanceOf(WP_Error::class, $result);
        $this->assertEquals(409, $result->get_error_data()['status']);
    }

    public function test_update_moves_cookie_to_other_category()
    {
        $cookie = $this->cookieTable->update('_ga_*', ['category' => 'advertising']);

        $this->assertEquals('advertising', $cookie['category']);
        $this->assertTrue($cookie['regex']);
        $this->assertCount(0, $this->cookieTable->all('analytics'));
        $this->assertCount(1, $this->cookieTable->all('advertising'));
    }

    public function test_update_returns_404_for_unknown_cookie()
    {
        $result = $this->cookieTable->update('unknown', ['description' => 'Updated']);

        $this->assertInstanceOf(WP_Error::class, $result);
        $this->assertEquals(404, $result->get_error_data()['status']);
    }

    public function test_delete_removes_cookie()
    {
        $cookie = $this->cookieTable->delete('cc_cookie');

        $this->assertEquals('cc_cookie', $cookie['name']);
        $this->assertNull($this->cookieTable->find('cc_cookie'));
        $this->assertCount(1, $this->cookieTable->all());
    }

    public function test_delete_returns_404_for_unknown_cookie()
    {
        $result = $this->cookieTable->delete('unknown');

        $this->assertInstanceOf(WP_Error::class, $result);
        $this->assertEquals(404, $result->get_error_data()['status']);
    }
}
