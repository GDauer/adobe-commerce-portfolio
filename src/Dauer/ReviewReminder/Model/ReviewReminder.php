<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminder\Model;

use Dauer\ReviewReminder\Model\ResourceModel\ReviewReminderResource;
use Dauer\ReviewReminderApi\Api\Data\ReviewReminderInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;

/**
 * Model class
 */
class ReviewReminder extends AbstractModel implements ReviewReminderInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'dauer_review_reminder_model';

    /**
     * Initialize magento model.
     *
     * @return void
     * @throws LocalizedException
     */
    protected function _construct(): void
    {
        $this->_init(ReviewReminderResource::class);
    }

    /**
     * Return the SKU list as an array.
     *
     * @return array
     */
    public function getProductSkusArray(): array
    {
        $skus = $this->getData(self::PRODUCT_SKUS);
        return $skus ? array_map('trim', explode(',', $skus)) : [];
    }

    /**
     * Get a customer group id.
     *
     * @return int|null
     */
    public function getCustomerGroupId(): ?int
    {
        if (is_string($this->getData(self::CUSTOMER_GROUP_ID))) {
            return (int) $this->getData(self::CUSTOMER_GROUP_ID);
        }

        return $this->getData(self::CUSTOMER_GROUP_ID);
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return (string) $this->getData(self::IDENTIFIER);
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier(string $identifier): void
    {
        $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerGroupId(?int $customerGroupId = null): void
    {
        $this->setData(self::CUSTOMER_GROUP_ID, $customerGroupId);
    }

    /**
     * @inheritDoc
     */
    public function setProductSkusArray(?array $productSkusArray = null): void
    {
        $this->setData(
            self::PRODUCT_SKUS,
            $productSkusArray ? implode(',', $productSkusArray) : null
        );
    }

    /**
     * @inheritDoc
     */
    public function getStartDate(): string
    {
        return (string) $this->getData(self::START_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setStartDate(string $startDate): void
    {
        $this->setData(self::START_DATE, $startDate);
    }

    /**
     * @inheritDoc
     */
    public function getEndDate(): string
    {
        return (string) $this->getData(self::END_DATE);
    }

    /**
     * @inheritDoc
     */
    public function setEndDate(string $endDate): void
    {
        $this->setData(self::END_DATE, $endDate);
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): string
    {
        return (string) $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): string
    {
        return (string) $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @inheritDoc
     */
    public function getEntityIdentifier(): int
    {
        return (int) $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityIdentifier(int $entityId): void
    {
        $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheirtDoc
     */
    public function setEmailUsed(bool $emailUsed): void
    {
        $this->setData(self::IS_EMAIL_SENT, $emailUsed);
    }

    /**
     * @inheirtDoc
     */
    public function isEmailUsed(): bool
    {
        return (bool) $this->setData(self::IS_EMAIL_SENT);
    }
}
