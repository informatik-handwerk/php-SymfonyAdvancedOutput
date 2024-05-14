<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\impl\std;

use ihde\php74\SymfonyAdvancedOutput\contracts\ConsoleResult;
use ihde\php74\SymfonyAdvancedOutput\contracts\ConsoleResultTime;

class ConsoleResult_stdClass
    implements ConsoleResult
{

    protected ConsoleResultTime $time;
    protected int $exitCode = ConsoleResult::EXITCODE_FATA_ERROR_SIGNAL + ConsoleResult::SIGNAL_SIGHUP;

    /**
     *
     */
    public function __construct()
    {
        $this->time = new ConsoleResultTime_stdClass();
    }
    
    /**
     * @implements ConsoleResult
     * @inheritdoc
     */
    public function seal(int $exitCode): void
    {
        assert($exitCode >= 0 && $exitCode <= 255);

        $this->time->seal();
        $this->exitCode = $exitCode;
    }
    
    /**
     * @implements ConsoleResult
     * @inheritdoc
     */
    public function getExitCode(): int
    {
        return $this->exitCode;
    }
    
    /**
     * @implements ConsoleResult
     * @inheritdoc
     */
    public function getTime(): ConsoleResultTime {
       return $this->time;
    }
    
    /**
     * @implements ConsoleResult
     * @inheritdoc
     */
    public function toArray(): array
    {
        $asJson = \json_encode($this, \JSON_THROW_ON_ERROR);
        $asArray = \json_decode($asJson, true, 512, \JSON_THROW_ON_ERROR);
        return $asArray;
    }


}

