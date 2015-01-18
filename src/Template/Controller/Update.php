<?php

namespace ScoreYa\Cinderella\Template\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use ScoreYa\Cinderella\Template\Model\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Update
{
    private $dm;

    /**
     * @param DocumentManager       $dm
     */
    public function __construct( DocumentManager $dm)
    {
        $this->dm           = $dm;
    }

    /**
     * @param Template $template
     *
     * @return Response
     */
    public function __invoke(Template $template)
    {
        $this->dm->persist($template);

        $this->dm->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
