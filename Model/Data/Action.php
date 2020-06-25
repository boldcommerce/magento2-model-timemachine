<?php
namespace Bold\ModelTimemachine\Model\Data;

use DateTimeImmutable;
use Magento\Framework\Api\AbstractExtensibleObject;
use Bold\ModelTimemachine\Api\Data\ActionInterface;

/**
 * Class Action
 *
 * @package Bold\ModelTimemachine\Model\Data
 */
class Action extends AbstractExtensibleObject implements ActionInterface
{
    /**
     * @inheritDoc
     */
    public function getEntityId(): ?int
    {
        return $this->_get(static::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId(int $value = null)
    {
        $this->setData(static::ENTITY_ID, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getType(): ?string
    {
        return $this->_get(static::TYPE);
    }

    /**
     * @inheritDoc
     */
    public function setType(string $value)
    {
        $this->setData(static::TYPE, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTypeId(): ?int
    {
        return $this->_get(static::TYPE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTypeId(int $value)
    {
        $this->setData(static::TYPE_ID, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSequence(): ?int
    {
        return $this->_get(static::SEQUENCE);
    }

    /**
     * @inheritDoc
     */
    public function setSequence(int $value = null)
    {
        $this->setData(static::SEQUENCE, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOperation(): ?string
    {
        return $this->_get(static::OPERATION);
    }

    /**
     * @inheritDoc
     */
    public function setOperation($value = null)
    {
        $this->setData(static::OPERATION, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getOrigin(): ?string
    {
        return $this->_get(static::ORIGIN);
    }

    /**
     * @inheritDoc
     */
    public function setOrigin($value = null)
    {
        $this->setData(static::ORIGIN, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCodePath(): ?string
    {
        return $this->_get(static::CODE_PATH);
    }

    /**
     * @inheritDoc
     */
    public function setCodePath($value = null)
    {
        $this->setData(static::CODE_PATH, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->_get(static::CREATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function setCreatedAt(string $value = null)
    {
        $this->setData(static::CREATED_AT, $value);

        return $this;
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Bold\ModelTimemachine\Api\Data\ActionExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Bold\ModelTimemachine\Api\Data\ActionExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Bold\ModelTimemachine\Api\Data\ActionExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }
}
