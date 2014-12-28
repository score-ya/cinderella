<?php

namespace ScoreYa\Cinderella\User\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use ScoreYa\Cinderella\User\Model\ApiUser;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class ApiUserDocumentRepository extends DocumentRepository implements ApiUserRepository
{
    /**
     * @param string $apiKey
     *
     * @return ApiUser
     */
    public function findByApiKey($apiKey)
    {
        return $this->findOneBy(['apiKey' => $apiKey]);
    }
}
