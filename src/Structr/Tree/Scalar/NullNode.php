<?php
/**
 * Copyright (c) 2012 Gijs Kunze
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Structr\Tree\Scalar;

use Structr\Tree\Base\Node;
use Structr\Tree\Base\ScalarNode;
use Structr\Tree\Composite\ChoiceNode;

class NullNode extends ScalarNode
{
    /**
     * {@inheritdoc}
     */
    public function getScalarType()
    {
        return 'NULL';
    }

    /**
     * @param Node $node
     */
    public static function canHaveNullValue($node)
    {
        if($node instanceof NullNode) {
            return true;
        }

        if($node instanceof ChoiceNode) {
            return $node->canHaveNullValue();
        }

        return false;
    }
}
