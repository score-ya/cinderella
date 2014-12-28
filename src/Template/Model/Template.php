<?php

namespace ScoreYa\Cinderella\Template\Model;

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
     * @return mixed
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
}
