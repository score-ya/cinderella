<?php

namespace ScoreYa\Cinderella\Template\Model;

use ScoreYa\Cinderella\User\Model\User;

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
    private $content;
    private $mimeType;
    private $openingVariable;
    private $closingVariable;
    private $user;
    private $apiName;

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

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param mixed $apiName
     */
    public function setApiName($apiName)
    {
        $this->apiName = $apiName;
    }
}
