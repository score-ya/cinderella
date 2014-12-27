<?php

namespace ScoreYa\Cinderella\Core\Util;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class Canonicalizer
{
    /**
     * @param $string
     *
     * @return null|string
     */
    public function canonicalize($string)
    {
        return null === $string ? null : mb_convert_case($string, MB_CASE_LOWER, mb_detect_encoding($string));
    }

    /**
     * @param mixed  $object
     * @param string $propertyName
     * @param string $canonicalizedPropertyName
     */
    public function canonicalizeObjectProperty($object, $propertyName, $canonicalizedPropertyName)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $accessor->setValue(
            $object,
            $canonicalizedPropertyName,
            $this->canonicalize($accessor->getValue($object, $propertyName))
        );
    }
}
