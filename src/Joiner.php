<?php

namespace Uvinum;

use Uvinum\Manipulator\Manipulator;
use Uvinum\Serializer\Serializer;

final class Joiner
{
    /** @var Serializer */
    private $serializer;

    /** @var Manipulator */
    private $manipulator;

    private $base;

    public function __construct(Serializer $serializer, Manipulator $manipulator)
    {
        $this->serializer  = $serializer;
        $this->manipulator = $manipulator;
        $this->reset();
    }

    public function join($arg)
    {
        $this->base = $arg;

        return $this;
    }

    public function append($key, $arg)
    {
        $serializedArg = $this->serializer->serialize($arg);
        $this->manipulator->append($key, $serializedArg);

        return $this;
    }

    public function filter($key)
    {
        $this->manipulator->filter($key);

        return $this;
    }

    public function execute()
    {
        $serializedBase = $this->serializer->serialize($this->base);

        return $this->manipulator->process($serializedBase);
    }

    private function reset()
    {
        $this->base = null;
    }
}
