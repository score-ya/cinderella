<?php

namespace ScoreYa\Cinderella\Template\Controller;

use ScoreYa\Cinderella\Template\Repository\TemplateRepository;

/**
 * @author Alexander Miehe <alexander.miehe@movingimage.com>
 */
abstract class Base
{
    protected $templateRepository;

    /**
     * @param TemplateRepository $templateRepository
     */
    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }
}
