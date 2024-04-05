<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

class ServiceResultTime
{
    /** @var int|string */
    public $startTime;
    /** @var int|string */
    public $endTime;
    /** @var int|string */
    public $elapsed;

    /**
     *
     */
    public function __construct()
    {
        $this->startTime = \time();
    }

    /**
     * @return void
     */
    public function seal(): void
    {
        $this->endTime = \time();
        $this->elapsed = $this->endTime - $this->startTime;
    }
    
    /**
     * @return array
     * @throws \JsonException
     */
    public function toArray(): array
    {
        $asJson = \json_encode($this, \JSON_THROW_ON_ERROR);
        $asArray = \json_decode($asJson, true, 512, \JSON_THROW_ON_ERROR);
        return $asArray;
    }


}

