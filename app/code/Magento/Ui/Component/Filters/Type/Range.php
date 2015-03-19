<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Ui\Component\Filters\Type;

use Magento\Ui\Component\Filters\AbstractFilter;

/**
 * Class Range
 */
class Range extends AbstractFilter
{
    const NAME = 'filter_range';

    /**
     * Get component name
     *
     * @return string
     */
    public function getComponentName()
    {
        return static::NAME;
    }

    /**
     * Prepare component configuration
     *
     * @return void
     */
    public function prepare()
    {
        parent::prepare();
        $this->applyFilter();
        $jsConfig = $this->getConfiguration($this);
        $this->getContext()->addComponentDefinition($this->getComponentName(), $jsConfig);
    }

    /**
     * Apply filter
     *
     * @return void
     */
    protected function applyFilter()
    {
        $condition = $this->getCondition();
        if ($condition !== null) {
            $this->getContext()->getDataProvider()->addFilter($this->getName(), $condition);
        }
    }

    /**
     * Get condition by data type
     *
     * @return array|null
     */
    public function getCondition()
    {
        $value = isset($this->filterData[$this->getName()]) ? $this->filterData[$this->getName()] : null;
        if (!empty($value['from']) || !empty($value['to'])) {
            if (isset($value['from']) && empty($value['from']) && $value['from'] !== '0') {
                $value['orig_from'] = $value['from'];
                $value['from'] = null;
            }
            if (isset($value['to']) && empty($value['to']) && $value['to'] !== '0') {
                $value['orig_to'] = $value['to'];
                $value['to'] = null;
            }
        } else {
            $value = null;
        }

        return $value;
    }
}
