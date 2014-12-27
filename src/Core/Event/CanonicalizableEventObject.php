<?php

namespace ScoreYa\Cinderella\Core\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
interface CanonicalizableEventObject
{
    /**
     * @return mixed
     */
    public function getCanonicalizableObject();
}
