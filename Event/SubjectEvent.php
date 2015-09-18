<?php

namespace Ekyna\Bundle\SocialButtonsBundle\Event;

use Ekyna\Bundle\SocialButtonsBundle\Share\Subject;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class SubjectEvent
 * @package Ekyna\Bundle\SocialButtonsBundle\Event
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class SubjectEvent extends Event
{
    /**
     * @var array
     */
    private $parameters;

    /**
     * @var Subject
     */
    private $subject;


    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets the parameters.
     *
     * @param array $parameters
     * @return SubjectEvent
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Sets the subject.
     *
     * @param Subject $subject
     * @return SubjectEvent
     */
    public function setSubject(Subject $subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Returns the subject.
     *
     * @return Subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
