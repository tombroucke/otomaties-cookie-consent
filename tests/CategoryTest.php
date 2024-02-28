<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\Category;

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

    public function testCookieTableReturnsArray()
    {
        $this->assertIsArray($this->category->cookieTable());
    }

    public function testCookieTableReturnCorrectCookie() 
    {
        $this->assertEquals($this->category->cookieTable()[0]['name'], 'wordpress_test_cookie');
        $this->assertEquals($this->category->cookieTable()[0]['domain'], 'example.com');
        $this->assertEquals($this->category->cookieTable()[0]['description'], 'WordPress test cookie');
        $this->assertEquals($this->category->cookieTable()[0]['expiration'], 'Session');
        $this->assertArrayNotHasKey('isRegex', $this->category->cookieTable()[0]);
        $this->assertTrue($this->category->cookieTable()[1]['isRegex']);

    }

    public function testInformationIsCorrect() {
        $this->assertEquals($this->category->information()['title'], 'Strictly necessary cookies');
        $this->assertEquals($this->category->information()['description'], 'Necessary description');
        $this->assertEquals($this->category->information()['cookieTable'], $this->category->cookieTable());
    }
}
