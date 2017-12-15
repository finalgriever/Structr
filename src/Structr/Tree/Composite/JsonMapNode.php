<?php
/**
 * Copyright (c) 2012 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Structr\Tree\Composite;

use Structr\Structr;

class JsonMapNode extends MapNode
{
    /**
     * @var array functions to apply to the value of this node
     *      after decoding, but before checking the value of this node
     */
    private $_post_decode = array();

    /**
     * Add a post-decode-processing callable to this node.
     * Post-decode-processing callables are applied to the value of this node just
     * after the decoding the value, but just before the value is checked.
     * The callables are applied in the order in which they are added.
     *
     * @param mixed $callable A valid PHP callable
     * @throws \Structr\Exception
     * @return \Structr\Tree\Base\Node This node
     */
    public function post_decode($callable)
    {
        if (is_callable($callable, false)) {
            $this->_post_decode[] = $callable;
        } else {
            throw new Exception('Invalid callable supplied to JsonMapNode::post_decode()');
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function _walk_value($value = null)
    {
        $value = Structr::json_decode($value);
        $value = $this->_walk_post_decode($value);
        return parent::_walk_value($value);
    }

    /**
     * Apply all post-processing callables to a value
     *
     * @param mixed $value The value to process
     * @return mixed Result of all pre-processing callables
     */
    protected function _walk_post_decode($value)
    {
        foreach ($this->_post_decode as $callable) {
            $value = call_user_func($callable, $value);
        }

        return $value;
    }
}
