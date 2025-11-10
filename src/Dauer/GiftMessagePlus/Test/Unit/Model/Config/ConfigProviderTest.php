<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlus\Test\Unit\Model\Config;

use Dauer\GiftMessagePlus\Model\Config\ConfigProvider as TestSubject;
use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterface;
use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterfaceFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Test class.
 */
class ConfigProviderTest extends TestCase
{
    private ScopeConfigInterface $scopeConfig;
    private EditorConfigDataInterfaceFactory $configDataInterfaceFactory;
    private array $plugins;
    private array $additionalSettings;

    /**
     * Setup method.
     *
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
        $this->configDataInterfaceFactory = $this->createMock(EditorConfigDataInterfaceFactory::class);
        $this->plugins = ['some_plugin' => 'some_plugin'];
        $this->additionalSettings = ['some_additional_setting' => false];

        $this->testSubject = new TestSubject(
            $this->scopeConfig,
            $this->configDataInterfaceFactory,
            $this->plugins,
            $this->additionalSettings
        );
    }

    /**
     * Test if the module is enabled.
     *
     * @return void
     */
    public function testIsGiftMessagePlusEnabled(): void
    {
        $this->scopeConfig->expects($this->once())
            ->method('isSetFlag')
            ->with('sales/gift_options/gift_message_plus/enabled', 'website')
            ->willReturn(true);

        $result = $this->testSubject->isGiftMessagePlusEnabled();
        $this->assertTrue($result);
    }

    /**
     * Test get message max length.
     *
     * @return void
     */
    public function testGetMessageMaxLength(): void
    {
        $this->scopeConfig->expects($this->once())
            ->method('getValue')
            ->with('sales/gift_options/gift_message_plus/max_length', 'website')
            ->willReturn(255);

        $result = $this->testSubject->getMessageMaxLength();
        $this->assertEquals(255, $result);
    }

    /**
     * Test get Editor Configuration.
     *
     * @return void
     * @throws Exception
     */
    public function testGetEditorConfiguration(): void
    {
        $editor = $this->createMock(EditorConfigDataInterface::class);
        $this->configDataInterfaceFactory->expects($this->once())
            ->method('create')
            ->willReturn($editor);

        $editor->expects($this->once())
            ->method('setCssSelector')
            ->with('gift-message-whole-message-');

        $editor->expects($this->once())
            ->method('setPluginList')
            ->with($this->plugins);

        $editor->expects($this->once())
            ->method('setMode')
            ->with('exact');

        $editor->expects($this->once())
            ->method('setAdditionalSettings')
            ->with($this->additionalSettings);

        $result = $this->testSubject->getEditorConfiguration();
        $this->assertEquals($editor, $result);
    }
}
