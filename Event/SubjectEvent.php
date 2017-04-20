<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SocialButtonsBundle\Event;

use Ekyna\Bundle\SocialButtonsBundle\Model\Subject;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SubjectEvent
 * @package Ekyna\Bundle\SocialButtonsBundle\Event
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
final class SubjectEvent extends Event
{
    private array    $parameters;
    private ?Subject $subject = null;


    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets the parameters.
     *
     * @param array $parameters
     *
     * @return SubjectEvent
     */
    public function setParameters(array $parameters): SubjectEvent
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sets the subject.
     *
     * @param Subject $subject
     *
     * @return SubjectEvent
     */
    public function setSubject(Subject $subject): SubjectEvent
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Returns the subject.
     *
     * @return Subject
     */
    public function getSubject(): ?Subject
    {
        return $this->subject;
    }
}
