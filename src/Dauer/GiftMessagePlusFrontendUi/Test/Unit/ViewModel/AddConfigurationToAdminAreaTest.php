<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\GiftMessagePlusFrontendUi\Test\Unit\ViewModel;

use Dauer\GiftMessagePlus\Model\Checkout\ConfigProvider\GiftMessageConfig;
use Dauer\GiftMessagePlusFrontendUi\ViewModel\AddConfigurationToAdminArea as TestSubject;
use Magento\Framework\Serialize\SerializerInterface;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Test class.
 */
class AddConfigurationToAdminAreaTest extends TestCase
{
    private GiftMessageConfig $giftMessageConfig;
    private SerializerInterface $serializer;
    private TestSubject $testSubject;

    /**
     * Setup method.
     *
     * @return void
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->giftMessageConfig = $this->createMock(GiftMessageConfig::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->testSubject = new TestSubject($this->giftMessageConfig, $this->serializer);
    }

    /**
     * Test get gift message config.
     *
     * @return void
     */
    public function testGetGiftMessageConfig(): void
    {
        $this->serializer->expects($this->once())
            ->method('serialize')
            ->willReturn('{serialized_string: "some_value"}');

        $this->giftMessageConfig->expects($this->once())
            ->method('getConfig')
            ->willReturn(['some_key' => 'some_value']);

        $result = $this->testSubject->getGiftMessageConfig();
        $this->assertEquals('{serialized_string: "some_value"}', $result);
    }
}
