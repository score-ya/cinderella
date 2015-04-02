<?php

namespace ScoreYa\Cinderella\User\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor;
use ScoreYa\Cinderella\User\Event\UserEvent;
use ScoreYa\Cinderella\User\Model\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class UserFlushProcessor extends BaseFlushProcessor
{
    private $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param DocumentManager $dm
     * @param mixed           $doc
     *
     * @return void
     */
    public function process(DocumentManager $dm, $doc)
    {
        if ($this->isType(self::CREATED, $dm, $doc)) {
            $this->eventDispatcher->dispatch(UserEvent::CREATED, new UserEvent($doc));
        }
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supports($class)
    {
        return is_a($class, User::class, true);
    }
}
