<?php
/**
 * @author Gustavo Dauer <gustavo.dauer@hotmail.com>
 */
declare(strict_types=1);

namespace Dauer\ReviewReminderApi\Api\Data;

/**
 * Data interface for Review Reminder.
 */
interface ReviewReminderInterface
{
    public const string ENTITY_ID = 'entity_id';
    public const string IDENTIFIER = 'identifier';
    public const string CUSTOMER_GROUP_ID = 'customer_group_id';
    public const string PRODUCT_SKUS = 'product_skus';
    public const string START_DATE = 'start_date';
    public const string END_DATE = 'end_date';
    public const string CREATED_AT = 'created_at';
    public const string UPDATED_AT = 'updated_at';
    public const string IS_EMAIL_SENT = 'is_email_sent';

    /** Entity id getter.
     *
     * @return int
     */
    public function getEntityIdentifier(): int;

    /**
     * Entity id setter.
     *
     * @param int $entityId
     *
     * @return void
     */
    public function setEntityIdentifier(int $entityId): void;

    /**
     * Identifier getter.
     *
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * Identifier setter.
     *
     * @param string $identifier
     *
     * @return void
     */
    public function setIdentifier(string $identifier): void;

    /**
     * Customer group id getter.
     *
     * @return int|null
     */
    public function getCustomerGroupId(): ?int;

    /**
     * Customer group id setter.
     *
     * @param int|null $customerGroupId
     *
     * @return void
     */
    public function setCustomerGroupId(?int $customerGroupId = null): void;

    /**
     * Get products Skus as an array.
     *
     * @return array
     */
    public function getProductSkusArray(): array;

    /**
     * Set products Skus as an array.
     *
     * @param array|null $productSkusArray
     *
     * @return void
     */
    public function setProductSkusArray(?array $productSkusArray = null): void;

    /**
     * Start date getter.
     *
     * @return string
     */
    public function getStartDate(): string;

    /**
     * Start date setter.
     *
     * @param string $startDate
     *
     * @return void
     */
    public function setStartDate(string $startDate): void;

    /**
     * End date getter.
     *
     * @return string
     */
    public function getEndDate(): string;

    /**
     * End date setter.
     *
     * @param string $endDate
     *
     * @return void
     */
    public function setEndDate(string $endDate): void;

    /**
     * Created at getter.
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Created at setter.
     *
     * @param string $createdAt
     *
     * @return void
     */
    public function setCreatedAt(string $createdAt): void;

    /**
     * Updated at getter.
     *
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * Updated at setter.
     *
     * @param string $updatedAt
     *
     * @return void
     */
    public function setUpdatedAt(string $updatedAt): void;

    /**
     * Email used flag setter.
     *
     * @param bool $emailUsed
     *
     * @return void
     */
    public function setEmailUsed(bool $emailUsed): void;

    /**
     * Email used flag getter.
     *
     * @return bool
     */
    public function isEmailUsed(): bool;
}
