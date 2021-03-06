<?php

namespace ScoreYa\Cinderella\Template\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class TemplateDocumentRepository extends DocumentRepository implements TemplateRepository
{
    /**
     * {@inheritdoc}
     */
    public function findForApiCall($name, $mimeType, User $user)
    {
        return $this->findOneBy(['apiName' => $name, 'mimeType' => $mimeType, 'user.id' => $user->getId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllByUser(User $user)
    {
        return $this->findBy(['user.id' => $user->getId()]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Template $template)
    {
        $this->dm->remove($template);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Template $template)
    {
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function create(Template $template)
    {
        $this->dm->persist($template);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function findUniqueBy(array $options)
    {
        if (array_key_exists('user', $options)) {
            $options['user.id'] = $options['user'];
            unset($options['user']);
        }

        return $this->findBy($options);
    }
}
