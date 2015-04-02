<?php

namespace ScoreYa\Cinderella\Core\EventListener;

use ScoreYa\Cinderella\Core\Event\CanonicalizableEventObject;
use ScoreYa\Cinderella\Core\Util\Canonicalizer;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class CanonicalizePropertyListener
{
    private $canonicalizer;
    private $propertyName;
    private $canonicalizedPropertyName;

    /**
     * @param Canonicalizer $canonicalizer
     * @param string        $propertyName
     * @param string        $canonicalizedPropertyName
     */
    public function __construct(Canonicalizer $canonicalizer, $propertyName, $canonicalizedPropertyName)
    {
        $this->canonicalizer             = $canonicalizer;
        $this->propertyName              = $propertyName;
        $this->canonicalizedPropertyName = $canonicalizedPropertyName;
    }

    /**
     * @param CanonicalizableEventObject $event
     */
    public function canonicalize(CanonicalizableEventObject $event)
    {
        $this->canonicalizer->canonicalizeObjectProperty(
            $event->getCanonicalizableObject(),
            $this->propertyName,
            $this->canonicalizedPropertyName
        );
    }
}
