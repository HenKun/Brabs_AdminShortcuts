<?php


namespace Brabs\AdminShortcuts\Model;


class Shortcut
{
    private $name;
    private $shortcut;
    private $id;
    private $params;

    public function __construct($name, $shortcut, $id, $params)
    {
        $this->name = $name;
        $this->shortcut = $shortcut;
        $this->id = $id;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}