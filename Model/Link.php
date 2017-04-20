<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Model;

/**
 * Class Link
 * @package Ekyna\Bundle\SocialButtonsBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class Link
{
    private ?string $name  = null;
    private ?string $icon  = null;
    private ?string $url   = null;
    private ?string $title = null;


    public function setName(?string $name): Link
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): ?string
    {
        return 0 < strlen($this->name) ? $this->name : $this->icon;
    }

    public function setIcon(?string $icon): Link
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setUrl(?string $url): Link
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setTitle(?string $title): Link
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
