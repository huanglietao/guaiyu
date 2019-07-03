<?php

namespace App\CodeRuleSet;

use PHPMD\AbstractNode;
use PHPMD\Rule\FunctionAware;
use PHPMD\Rule\MethodAware;
use PHPMD\Rule\AbstractLocalVariable;

/**
 * Class Underscore
 * @package App\CodeRuleSet
 */
class Underscore extends AbstractLocalVariable implements FunctionAware, MethodAware
{
    /**
     * @var array
     */
    private $exceptions = array(
        '$php_errormsg',
        '$http_response_header',
        '$GLOBALS',
        '$_SERVER',
        '$_GET',
        '$_POST',
        '$_FILES',
        '$_COOKIE',
        '$_SESSION',
        '$_REQUEST',
        '$_ENV',
    );

    /**
     * This method checks if a variable is not named in camelCase
     * and emits a rule violation.
     *
     * @param \PHPMD\AbstractNode $node
     * @return void
     */
    public function apply(AbstractNode $node)
    {
        foreach ($node->findChildrenOfType('Variable') as $variable) {
            $image = $variable->getImage();

            if (in_array($image, $this->exceptions)) {
                continue;
            }

            if ($variable->getParent()->isInstanceOf('PropertyPostfix')) {
                continue;
            }

            if (preg_match('/^\$.*[A-Z].*$/', $image)) {
                $this->addViolation($node, array($image, $variable->getBeginLine()));
            }
        }
    }
}
