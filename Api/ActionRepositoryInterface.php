<?php
namespace Bold\ModelTimemachine\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ActionRepositoryInterface
 *
 * @package Bold\ModelTimemachine\Api
 */
interface ActionRepositoryInterface
{
    /**
     * Save Action
     * @param \Bold\ModelTimemachine\Api\Data\ActionInterface $action
     * @return \Bold\ModelTimemachine\Api\Data\ActionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Bold\ModelTimemachine\Api\Data\ActionInterface $action
    );

    /**
     * Retrieve Action
     * @param string $actionId
     * @return \Bold\ModelTimemachine\Api\Data\ActionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($actionId);

    /**
     * Retrieve Action matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Bold\ModelTimemachine\Api\Data\ActionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Action
     * @param \Bold\ModelTimemachine\Api\Data\ActionInterface $action
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Bold\ModelTimemachine\Api\Data\ActionInterface $action
    );

    /**
     * Delete Action by ID
     * @param string $actionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($actionId);

    /**
     * @param Data\ActionInterface $entity
     * @return int
     */
    public function getNextSequence(Data\ActionInterface $entity): int;
}

