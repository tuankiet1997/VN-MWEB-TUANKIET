<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Framework\Api;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Phrase;

/**
 * Data object for sort order.
 */
class SortOrder extends AbstractSimpleObject
{
    const FIELD = 'field';
    const DIRECTION = 'direction';
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /**
     * Initialize object and validate sort direction
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        if (null !== $this->getDirection()) {
            $this->validateDirection($this->getDirection());
        }
        if ($this->getField() !== null) {
            $this->validateField($this->getField());
        }
    }

    /**
     * Get sorting field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->_get(SortOrder::FIELD);
    }

    /**
     * Set sorting field.
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->validateField($field);

        return $this->setData(SortOrder::FIELD, $field);
    }

    /**
     * Get sorting direction.
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->_get(SortOrder::DIRECTION);
    }

    /**
     * Set sorting direction.
     *
     * @param string $direction
     * @return $this
     */
    public function setDirection($direction)
    {
        $this->validateDirection($direction);
        return $this->setData(SortOrder::DIRECTION, $this->normalizeDirectionInput($direction));
    }

    /**
     * Validate direction argument ASC or DESC
     * 
     * @param mixed $direction
     * @return null
     * @throws InputException
     */
    private function validateDirection($direction)
    {
        $this->validateDirectionIsString($direction);
        $this->validateDirectionIsAscOrDesc($direction);
    }

    /**
     * @param string $direction
     * @throws InputException
     * @return null
     */
    private function validateDirectionIsString($direction)
    {
        if (!is_string($direction)) {
            throw new InputException(new Phrase(
                'The sort order has to be specified as a string, got %1.',
                [gettype($direction)]
            ));
        }
    }

    /**
     * @param string $direction
     * @throws InputException
     * @return null
     */
    private function validateDirectionIsAscOrDesc($direction)
    {
        $normalizedDirection = $this->normalizeDirectionInput($direction);
        if (!in_array($normalizedDirection, [SortOrder::SORT_ASC, SortOrder::SORT_DESC], true)) {
            throw new InputException(new Phrase(
                'The sort order has to be specified as %1 for ascending order or %2 for descending order.',
                [SortOrder::SORT_ASC, SortOrder::SORT_DESC]
            ));
        }
    }

    /**
     * @param string $direction
     * @return string
     */
    private function normalizeDirectionInput($direction)
    {
        return strtoupper($direction);
    }

    /**
     * Check if given value can be used as sorting field.
     *
     * @param string $field
     * @return void
     * @throws InputException
     */
    private function validateField($field)
    {
        if (preg_match('/[^a-z0-9\_]/i', $field)) {
            throw new InputException(
                new Phrase(
                    'Sort order field %1 contains restricted symbols',
                    [$field]
                )
            );
        }
    }
}
