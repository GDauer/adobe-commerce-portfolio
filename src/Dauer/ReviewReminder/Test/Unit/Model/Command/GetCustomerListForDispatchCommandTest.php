<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command;

use Dauer\ReviewReminder\Model\Command\GetCustomerListForDispatchCommand;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Dauer\ReviewReminderApi\Api\ReviewReminderRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Filter;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use PHPUnit\Framework\TestCase;

class GetCustomerListForDispatchCommandTest extends TestCase
{
    private GetCustomerListForDispatchCommand $subject;
    private SearchCriteriaBuilder $searchCriteriaBuilderMock;
    private FilterBuilder $filterBuilderMock;
    private ReviewReminderRepositoryInterface $reviewReminderRepositoryMock;
    private Filter $filterMock;

    protected function setUp(): void
    {
        $this->searchCriteriaBuilderMock = $this->getMockBuilder(SearchCriteriaBuilder::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['addFilter', 'create'])
            ->getMock();

        $this->filterBuilderMock = $this->createMock(FilterBuilder::class);
        $this->reviewReminderRepositoryMock = $this->createMock(ReviewReminderRepositoryInterface::class);
        $this->filterMock = $this->createMock(Filter::class);

        $this->subject = new GetCustomerListForDispatchCommand(
            $this->searchCriteriaBuilderMock,
            $this->filterBuilderMock,
            $this->reviewReminderRepositoryMock
        );
    }

    public function testExecuteReturnsEmptyArray(): void
    {
        $result = $this->executeWithMocks();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testExecuteReturnsMultipleReminders(): void
    {
        $reviewReminders = [
            $this->createMock(ReviewReminder::class),
            $this->createMock(ReviewReminder::class),
            $this->createMock(ReviewReminder::class),
        ];

        $result = $this->executeWithMocks($reviewReminders);

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertEquals($reviewReminders, $result);
    }

    /**
     * Setup expectations for FilterBuilder calls
     */
    private function expectFilterBuilderCalls(): void
    {
        $this->filterBuilderMock->expects(self::once())
            ->method('setField')
            ->with(ReviewReminderInterface::IS_EMAIL_SENT)
            ->willReturnSelf();

        $this->filterBuilderMock->expects(self::once())
            ->method('setValue')
            ->with(false)
            ->willReturnSelf();

        $this->filterBuilderMock->expects(self::once())
            ->method('setConditionType')
            ->with('eq')
            ->willReturnSelf();

        $this->filterBuilderMock->expects(self::once())
            ->method('create')
            ->willReturn($this->filterMock);
    }

    /**
     * Execute the command with full setup
     */
    private function executeWithMocks(array $expectedResult = []): array
    {
        $searchCriteriaMock = $this->createMock(SearchCriteria::class);

        $this->expectFilterBuilderCalls();
        $this->expectSearchCriteriaBuilderCalls($searchCriteriaMock);
        $this->expectRepositoryGetListCall($searchCriteriaMock, $expectedResult);

        return $this->subject->execute();
    }

    /**
     * Setup expectations for SearchCriteriaBuilder calls
     */
    private function expectSearchCriteriaBuilderCalls(SearchCriteria $searchCriteria): void
    {
        $this->searchCriteriaBuilderMock->expects(self::once())
            ->method('addFilter')
            ->with($this->filterMock)
            ->willReturnSelf();

        $this->searchCriteriaBuilderMock->expects(self::once())
            ->method('create')
            ->willReturn($searchCriteria);
    }

    /**
     * Setup expectations for ReviewReminderRepository calls
     */
    private function expectRepositoryGetListCall(SearchCriteria $searchCriteria, array $result): void
    {
        $this->reviewReminderRepositoryMock->expects(self::once())
            ->method('getList')
            ->with($searchCriteria)
            ->willReturn($result);
    }
}
