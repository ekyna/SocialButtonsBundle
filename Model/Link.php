<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Model;

/**
 * Class Link
 * @package Ekyna\Bundle\SocialButtonsBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Link
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;


    /**
     * Constructor.
     *
     * @param string $name
     * @param string $icon
     * @param string $url
     * @param string $title
     */
    public function __construct($name, $icon, $url, $title = null)
    {
        $this->name = $name;
        $this->icon = $icon;
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return Link
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return 0 < strlen($this->name) ? $this->name : $this->icon;
    }

    /**
     * Sets the icon.
     *
     * @param string $icon
     *
     * @return Link
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Returns the icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the url.
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Returns the url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     *
     * @return Link
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Returns the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
