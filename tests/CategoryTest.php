<?php

declare(strict_types=1);

use Otomaties\CookieConsent\Category;
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase
{
    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category([
            'key' => 'necessary',
            'label' => __('Strictly necessary cookies', 'otomaties-cookie-consent'),
        ]);
    }

    public function test_cookie_table_returns_array()
    {
        $this->assertIsArray($this->category->cookieTable());
    }

    public function test_cookie_table_return_correct_cookie()
    {
        $this->assertEquals($this->category->cookieTable()[0]['name'], 'wordpress_test_cookie');
        $this->assertEquals($this->category->cookieTable()[0]['domain'], 'example.com');
        $this->assertEquals($this->category->cookieTable()[0]['description'], 'WordPress test cookie');
        $this->assertEquals($this->category->cookieTable()[0]['expiration'], 'Session');
        $this->assertArrayNotHasKey('isRegex', $this->category->cookieTable()[0]);
        $this->assertTrue($this->category->cookieTable()[1]['isRegex']);

    }

    public function test_information_is_correct()
    {
        $this->assertEquals($this->category->information()['title'], 'Strictly necessary cookies');
        $this->assertEquals($this->category->information()['description'], 'Necessary description');
        $this->assertEquals($this->category->information()['cookieTable'], $this->category->cookieTable());
    }
}
