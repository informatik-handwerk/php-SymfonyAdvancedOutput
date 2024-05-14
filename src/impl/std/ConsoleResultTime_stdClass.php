<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\impl\std;

use ihde\php74\SymfonyAdvancedOutput\contracts\ConsoleResultTime;

class ConsoleResultTime_stdClass
    implements ConsoleResultTime
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
     * @implements ConsoleResultTime
     * @inheritdoc
     */
    public function seal(): void
    {
        $this->endTime = \time();
        $this->elapsed = $this->endTime - $this->startTime;
    }
    
    /**
     * @implements ConsoleResultTime
     * @inheritdoc
     */
    public function toArray(): array
    {
        $asJson = \json_encode($this, \JSON_THROW_ON_ERROR);
        $asArray = \json_decode($asJson, true, 512, \JSON_THROW_ON_ERROR);
        return $asArray;
    }


}

