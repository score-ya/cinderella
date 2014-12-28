<?php

namespace ScoreYa\Cinderella\Multitenancy\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class Tenant
{
    private $id;
    private $name;
    private $nameCanonical;
    private $users;
    private $apiUser;
    private $templates;

    public function __construct()
    {
        $this->id = (string) new \MongoId();
        $this->users = new ArrayCollection();
        $this->templates = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param string $nameCanonical
     *
     * @return Tenant
     */
    public function setNameCanonical($nameCanonical)
    {
        $this->nameCanonical = $nameCanonical;

        return $this;
    }
}
