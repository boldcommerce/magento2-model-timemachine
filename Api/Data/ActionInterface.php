<?php

namespace Bold\ModelTimemachine\Api\Data;

use DateTimeImmutable;
use Magento\Framework\Api\ExtensibleDataInterface;

interface ActionInterface extends ExtensibleDataInterface
{
    const ENTITY_ID = 'entity_id';
    const TYPE = 'type';
    const TYPE_ID = 'type_id';
    const SEQUENCE = 'sequence';
    const OPERATION = 'operation';
    const ORIGIN = 'origin';
    const CODE_PATH = 'code_path';
    const CREATED_AT = 'created_at';

    /**
     * @return int
     */
    public function getEntityId(): ?int;

    /**
     * @param int $value
     * @return $this
     */
    public function setEntityId(int $value = null);

    /**
     * @return string
     */
    public function getType(): ?string;

    /**
     * @param string $value
     * @return $this
     */
    public function setType(string $value);

    /**
     * @return int
     */
    public function getTypeId(): ?int;

    /**
     * @param int $value
     * @return $this
     */
    public function setTypeId(int $value);

    /**
     * @return int
     */
    public function getSequence(): ?int;

    /**
     * @param int $value
     * @return $this
     */
    public function setSequence(int $value = null);

    /**
     * @return string
     */
    public function getOperation(): ?string;

    /**
     * @param string $value
     * @return $this
     */
    public function setOperation($value = null);

    /**
     * @return string
     */
    public function getOrigin(): ?string;

    /**
     * @param string $value
     * @return $this
     */
    public function setOrigin($value = null);

    /**
     * @return string
     */
    public function getCodePath(): ?string;

    /**
     * @param string $value
     * @return $this
     */
    public function setCodePath($value = null);

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedAt(): ?DateTimeImmutable;

    /**
     * @param DateTimeImmutable $value
     * @return $this
     */
    public function setCreatedAt(string $value = null);
}
