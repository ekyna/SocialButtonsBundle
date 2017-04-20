<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Model;

/**
 * Class Button
 * @package Ekyna\Bundle\SocialButtonsBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
final class Button
{
    public ?string $name  = null;
    public ?string $title = null;
    public ?string $url   = null;
    public ?string $icon  = null;
}
