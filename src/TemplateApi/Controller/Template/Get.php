<?php

namespace ScoreYa\Cinderella\TemplateApi\Controller\Template;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Get
{
    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke($id)
    {
        return new JsonResponse([$id]);
    }
}
