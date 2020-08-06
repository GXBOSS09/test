<?php
/**
 * Test for PhpMyAdmin\Header class
 */

declare(strict_types=1);

namespace PhpMyAdmin\Tests;

use PhpMyAdmin\Core;
use PhpMyAdmin\Header;
use ReflectionProperty;
use function define;
use function defined;

/**
 * Test for PhpMyAdmin\Header class
 *
 * @group medium
 */
class HeaderTest extends AbstractTestCase
{
    /**
     * Configures global environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        parent::defineVersionConstants();
        parent::setTheme();
        parent::setLanguage();
        if (! defined('PMA_IS_WINDOWS')) {
            define('PMA_IS_WINDOWS', false);
        }
        $GLOBALS['server'] = 0;
        $GLOBALS['message'] = 'phpmyadminmessage';
        $GLOBALS['pmaThemePath'] = $GLOBALS['PMA_Theme']->getPath();
        $GLOBALS['PMA_PHP_SELF'] = Core::getenv('PHP_SELF');
        $GLOBALS['server'] = 'server';
        $GLOBALS['db'] = 'db';
        $GLOBALS['table'] = '';
        parent::setGlobalConfig();
        $GLOBALS['PMA_Config']->enableBc();
        $GLOBALS['cfg']['Server']['DisableIS'] = false;
        $GLOBALS['cfg']['Server']['verbose'] = 'verbose host';
        $GLOBALS['cfg']['Server']['pmadb'] = '';
        $GLOBALS['cfg']['Server']['user'] = '';
    }

    /**
     * Test for disable
     */
    public function testDisable(): void
    {
        $header = new Header();
        $header->disable();
        $this->assertEquals(
            '',
            $header->getDisplay()
        );
    }

    /**
     * Test for enable
     */
    public function testEnable(): void
    {
        $header = new Header();
        $this->assertStringContainsString(
            '<title>phpMyAdmin</title>',
            $header->getDisplay()
        );
    }

    /**
     * Test for Set BodyId
     */
    public function testSetBodyId(): void
    {
        $header = new Header();
        $header->setBodyId('PMA_header_id');
        $this->assertStringContainsString(
            'PMA_header_id',
            $header->getDisplay()
        );
    }

    /**
     * Test for print view
     */
    public function testPrintView(): void
    {
        $header = new Header();
        $header->enablePrintView();
        $this->assertStringContainsString(
            'Print view',
            $header->getDisplay()
        );
    }

    /**
     * Test for Get JsParams
     */
    public function testGetJsParams(): void
    {
        $header = new Header();
        $this->assertArrayHasKey(
            'common_query',
            $header->getJsParams()
        );
    }

    /**
     * Test for Get JsParamsCode
     */
    public function testGetJsParamsCode(): void
    {
        $header = new Header();
        $this->assertStringContainsString(
            'CommonParams.setAll',
            $header->getJsParamsCode()
        );
    }

    /**
     * Test for Get Message
     */
    public function testGetMessage(): void
    {
        $header = new Header();
        $this->assertStringContainsString(
            'phpmyadminmessage',
            $header->getMessage()
        );
    }

    /**
     * Test for Disable Warnings
     *
     * @test
     */
    public function testDisableWarnings(): void
    {
        $reflection = new ReflectionProperty(Header::class, 'warningsEnabled');
        $reflection->setAccessible(true);

        $header = new Header();
        $header->disableWarnings();

        $this->assertFalse($reflection->getValue($header));
    }
}
