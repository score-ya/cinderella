<?php

namespace ScoreYa\Cinderella\User\Processor;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Core\Processor\BaseFlushProcessor;
use ScoreYa\Cinderella\User\Event\ApiUserEvent;
use ScoreYa\Cinderella\User\Model\ApiUser;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 */
class ApiUserFlushProcessor extends BaseFlushProcessor
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
     * @param ApiUser         $doc
     */
    public function process(DocumentManager $dm, $doc)
    {
        if ($this->isCreated($dm, $doc) && $doc->getApiKey() === null) {
            $this->eventDispatcher->dispatch(ApiUserEvent::CREATED, new ApiUserEvent($doc));
        }
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supports($class)
    {
        return is_a($class, ApiUser::class, true);
    }
}
