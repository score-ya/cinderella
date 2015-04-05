<?php

namespace ScoreYa\Cinderella\User\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class UserDocumentRepository extends DocumentRepository implements UserRepository
{
    /**
     * {@inheritdoc}
     */
    public function findByConfirmationToken($token)
    {
        return $this->findOneBy(['confirmationToken' => $token]);
    }

}
