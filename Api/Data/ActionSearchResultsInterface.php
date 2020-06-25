<?php

namespace Bold\ModelTimemachine\Api\Data;

/**
 * Interface ActionSearchResultsInterface
 *
 * @package Bold\ModelTimemachine\Api\Data
 */
interface ActionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get Action list.
     * @return \Bold\ModelTimemachine\Api\Data\ActionInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \Bold\ModelTimemachine\Api\Data\ActionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
