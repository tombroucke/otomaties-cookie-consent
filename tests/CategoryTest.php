<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Otomaties\CookieConsent\Category;

final class CategoryTest extends TestCase
{

    private $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category('necessary');
    }

    public function testCookieTableReturnsArray()
    {
        $this->assertIsArray($this->category->cookieTable());
    }

    public function testCookieTableReturnCorrectCookie() 
    {
        $this->assertEquals($this->category->cookieTable()[0]['col1'], 'wordpress_test_cookie');
        $this->assertEquals($this->category->cookieTable()[0]['col2'], 'example.com');
        $this->assertEquals($this->category->cookieTable()[0]['col3'], 'Session');
        $this->assertEquals($this->category->cookieTable()[0]['col4'], 'WordPress test cookie');
        $this->assertArrayNotHasKey('is_regex', $this->category->cookieTable()[0]);
        $this->assertTrue($this->category->cookieTable()[1]['is_regex']);

    }

    public function testInformationIsCorrect() {
        $this->assertEquals($this->category->information()['title'], 'Strictly necessary cookies');
        $this->assertEquals($this->category->information()['description'], 'Necessary description');
        $this->assertEquals($this->category->information()['cookieTable'], $this->category->cookieTable());
    }
}
