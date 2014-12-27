<?php

namespace ScoreYa\Cinderella\Core\Validator;

use ScoreYa\Cinderella\Core\Util\Canonicalizer;
use Symfony\Component\Validator\ObjectInitializerInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class CanonicalInitializer implements ObjectInitializerInterface
{
    private $canonicalizer;
    private $className;
    private $propertyName;
    private $canonicalizedPropertyName;

    /**
     * @param Canonicalizer $canonicalizer
     * @param string        $className
     * @param string        $propertyName
     * @param string        $canonicalizedPropertyName
     */
    public function __construct(Canonicalizer $canonicalizer, $className, $propertyName, $canonicalizedPropertyName)
    {
        $this->propertyName              = $propertyName;
        $this->canonicalizedPropertyName = $canonicalizedPropertyName;
        $this->canonicalizer             = $canonicalizer;
        $this->className                 = $className;
    }

    /**
     * Initializes an object just before validation.
     *
     * @param object $object The object to validate
     *
     * @api
     */
    public function initialize($object)
    {
        if ($object instanceof $this->className) {
            $this->canonicalizer->canonicalizeObjectProperty(
                $object,
                $this->propertyName,
                $this->canonicalizedPropertyName
            );
        }
    }
}
