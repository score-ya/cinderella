<?php

namespace ScoreYa\Cinderella\Template\Model;

use ScoreYa\Cinderella\Multitenancy\Model\Tenant;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Template
{
    private $id;
    private $name;
    private $nameCanonical;
    private $tenant;
    private $content;
    private $mimeType;
    private $openingVariable;
    private $closingVariable;

    public function __construct()
    {
        $this->id = (string) new \MongoId();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $nameCanonical
     *
     * @return Template
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param Tenant $tenant
     *
     * @return Template
     */
    public function setTenant(Tenant $tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    /**
     * @return string
     */
    public function getOpeningVariable()
    {
        return $this->openingVariable;
    }

    /**
     * @return string
     */
    public function getClosingVariable()
    {
        return $this->closingVariable;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
