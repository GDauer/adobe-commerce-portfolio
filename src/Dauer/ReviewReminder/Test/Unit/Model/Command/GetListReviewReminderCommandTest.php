<?php
/**
 * Unit test for GetListReviewReminderCommand
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Test\Unit\Model\Command;

use Dauer\ReviewReminder\Model\Command\GetListReviewReminderCommand;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminder\Collection;
use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminder\CollectionFactory;
use Dauer\ReviewReminder\Model\ReviewReminder;
use Dauer\ReviewReminder\Model\ReviewReminderFactory;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\View\Element\UiComponent\DataProvider\FilterPool;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetListReviewReminderCommandTest extends TestCase
{
    private GetListReviewReminderCommand $command;
    private CollectionFactory|MockObject $collectionFactoryMock;
    private FilterPool|MockObject $filterPoolMock;
    private ReviewReminderFactory|MockObject $reviewReminderFactoryMock;
    private Collection|MockObject $collectionMock;
    private SearchCriteriaInterface|MockObject $searchCriteriaMock;

    protected function setUp(): void
    {
        $this->collectionFactoryMock = $this->createMock(CollectionFactory::class);
        $this->filterPoolMock = $this->getMockBuilder(FilterPool::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['applyFilters'])
            ->getMock();
        $this->reviewReminderFactoryMock = $this->createMock(ReviewReminderFactory::class);
        $this->collectionMock = $this->createMock(Collection::class);
        $this->searchCriteriaMock = $this->createMock(SearchCriteriaInterface::class);

        $this->command = new GetListReviewReminderCommand(
            $this->collectionFactoryMock,
            $this->filterPoolMock,
            $this->reviewReminderFactoryMock
        );
    }

    /**
     * Test that execute returns empty array when no collection items exist
     */
    public function testExecuteReturnsEmptyArrayWhenNoItems(): void
    {
        $this->setupCollection([], []);
        $result = $this->command->execute($this->searchCriteriaMock);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Test that execute returns ReviewReminder models created from collection items
     */
    public function testExecuteReturnsCreatedModels(): void
    {
        $itemsData = [
            ['id' => 1, 'email' => 'user1@example.com'],
            ['id' => 2, 'email' => 'user2@example.com'],
        ];

        $collectionItems = array_map(fn($data) => $this->createItem($data), $itemsData);
        $createdModels = array_map(fn() => $this->createMock(ReviewReminder::class), $itemsData);

        $this->setupCollection($collectionItems, []);
        $this->reviewReminderFactoryMock->expects(self::exactly(2))
            ->method('create')
            ->willReturnOnConsecutiveCalls(...$createdModels);

        $result = $this->command->execute($this->searchCriteriaMock);

        $this->assertCount(2, $result);
        $this->assertEquals($createdModels, $result);
    }

    /**
     * Test that execute applies pagination and filters from search criteria
     */
    public function testExecutionAppliesPaginationAndFilters(): void
    {
        $pageSize = 50;
        $currentPage = 3;

        $this->collectionFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionMock->expects(self::once())
            ->method('setPageSize')
            ->with($pageSize)
            ->willReturnSelf();

        $this->collectionMock->expects(self::once())
            ->method('setCurPage')
            ->with($currentPage)
            ->willReturnSelf();

        $this->searchCriteriaMock->expects(self::once())
            ->method('getPageSize')
            ->willReturn($pageSize);

        $this->searchCriteriaMock->expects(self::once())
            ->method('getCurrentPage')
            ->willReturn($currentPage);

        $this->filterPoolMock->expects(self::once())
            ->method('applyFilters')
            ->with($this->collectionMock, $this->searchCriteriaMock);

        $this->searchCriteriaMock->expects(self::once())
            ->method('getSortOrders')
            ->willReturn([]);

        $this->collectionMock->expects(self::once())
            ->method('getItems')
            ->willReturn([]);

        $this->command->execute($this->searchCriteriaMock);
    }

    /**
     * Test that execute applies sort orders in correct sequence to collection
     */
    public function testExecutionAppliesSortOrders(): void
    {
        $sortOrder1 = $this->createSortOrder('email', 'ASC');
        $sortOrder2 = $this->createSortOrder('created_at', 'DESC');

        $this->setupCollection([], [$sortOrder1, $sortOrder2]);

        $setOrderCalls = [];
        $this->collectionMock->expects(self::exactly(2))
            ->method('setOrder')
            ->willReturnCallback(function ($field, $direction) use (&$setOrderCalls) {
                $setOrderCalls[] = [$field, $direction];
                return $this->collectionMock;
            });

        $this->command->execute($this->searchCriteriaMock);

        $this->assertEquals([['email', 'ASC'], ['created_at', 'DESC']], $setOrderCalls);
    }

    /**
     * Test that execute ignores sort orders with empty field values
     */
    public function testExecutionIgnoresSortOrdersWithoutField(): void
    {
        $sortOrderWithField = $this->createSortOrder('id', 'ASC');
        $sortOrderWithoutField = $this->createMock(SortOrder::class);
        $sortOrderWithoutField->method('getField')->willReturn(null);

        $this->setupCollection([], [$sortOrderWithField, $sortOrderWithoutField]);

        $this->collectionMock->expects(self::once())
            ->method('setOrder')
            ->with('id', 'ASC')
            ->willReturnSelf();

        $this->command->execute($this->searchCriteriaMock);
    }

    /**
     * Helper: Setup collection with items and sort orders
     */
    private function setupCollection(array $items, array $sortOrders): void
    {
        $this->collectionFactoryMock->expects(self::once())
            ->method('create')
            ->willReturn($this->collectionMock);

        $this->collectionMock->expects(self::once())
            ->method('setPageSize')
            ->willReturnSelf();

        $this->collectionMock->expects(self::once())
            ->method('setCurPage')
            ->willReturnSelf();

        $this->searchCriteriaMock->method('getPageSize')->willReturn(20);
        $this->searchCriteriaMock->method('getCurrentPage')->willReturn(1);
        $this->searchCriteriaMock->method('getSortOrders')->willReturn($sortOrders);

        $this->filterPoolMock->expects(self::once())
            ->method('applyFilters')
            ->with($this->collectionMock, $this->searchCriteriaMock);

        $this->collectionMock->expects(self::once())
            ->method('getItems')
            ->willReturn($items);
    }

    /**
     * Helper: Create mock collection item
     */
    private function createItem(array $data): ReviewReminder|MockObject
    {
        $item = $this->createMock(ReviewReminder::class);
        $item->method('getData')->willReturn($data);
        return $item;
    }

    /**
     * Helper: Create sort order mock
     */
    private function createSortOrder(string $field, string $direction): SortOrder|MockObject
    {
        $sortOrder = $this->createMock(SortOrder::class);
        $sortOrder->method('getField')->willReturn($field);
        $sortOrder->method('getDirection')->willReturn($direction);
        return $sortOrder;
    }
}
