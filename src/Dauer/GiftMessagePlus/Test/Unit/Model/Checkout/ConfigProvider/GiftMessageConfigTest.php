<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlus\Test\Unit\Model\Checkout\ConfigProvider;

use Dauer\GiftMessagePlus\Model\Checkout\ConfigProvider\GiftMessageConfig as TestSubject;
use Dauer\GiftMessagePlusApi\Api\Config\ConfigProviderInterface as GiftMessageConfigProvider;
use Dauer\GiftMessagePlusApi\Api\Data\Config\EditorConfigDataInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Unit test class
 */
class GiftMessageConfigTest extends TestCase
{
    private readonly GiftMessageConfigProvider $configProvider;
    private TestSubject $testSubject;

    /**
     * Setup method.
     *
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->configProvider = $this->createMock(GiftMessageConfigProvider::class);

        $this->testSubject = new TestSubject($this->configProvider);
    }

    /**
     * Test get config.
     *
     * @return void
     * @throws Exception
     */
    public function testGetConfig(): void
    {
        $editorConfigData = $this->createMock(EditorConfigDataInterface::class);

        $this->configProvider->expects($this->once())
            ->method('getEditorConfiguration')
            ->willReturn($editorConfigData);

        $this->configProvider->expects($this->once())
            ->method('isGiftMessagePlusEnabled')
            ->willReturn(true);

        $this->configProvider->expects($this->once())
            ->method('getMessageMaxLength')
            ->willReturn(100);

        $editorConfigData->expects($this->once())
            ->method('getMode')
            ->willReturn('exact');

        $editorConfigData->expects($this->once())
            ->method('getPluginList')
            ->willReturn('something.other');

        $editorConfigData->expects($this->once())
            ->method('getCssSelector')
            ->willReturn('some-css-selector');

        $editorConfigData->expects($this->once())
            ->method('getAdditionalSettings')
            ->willReturn(['some-additional-setting' => false]);

        $result = $this->testSubject->getConfig();
        $this->assertEquals(
            [
                'gift_message_plus' => [
                    'enabled' => true,
                    'max_length' => 100,
                    'editor_config' => [
                        'mode' => 'exact',
                        'plugins' => 'something.other',
                        'css_selector' => 'some-css-selector'
                    ],
                    'additional_settings' => ['some-additional-setting' => false]
                ]
            ],
            $result
        );
    }
}
