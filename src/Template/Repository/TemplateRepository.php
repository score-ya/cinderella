<?php

namespace ScoreYa\Cinderella\Template\Repository;

use ScoreYa\Cinderella\Template\Model\Template;
use ScoreYa\Cinderella\User\Model\User;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
interface TemplateRepository
{
    /**
     * @param string $name
     * @param string $mimeType
     * @param User   $user
     *
     * @return Template
     */
    public function findForApiCall($name, $mimeType, User $user);

    /**
     * @param User $user
     *
     * @return Template[]
     */
    public function findAllByUser(User $user);

    /**
     * @param Template $template
     *
     * @return void
     */
    public function delete(Template $template);

    /**
     * @param Template $template
     *
     * @return void
     */
    public function update(Template $template);

    /**
     * @param Template $template
     *
     * @return void
     */
    public function create(Template $template);

    /**
     * @param array $options
     *
     * @return Template[]
     */
    public function findUniqueBy(array $options);
}
