<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\contracts;

interface ConsoleResult
{
    public const SIGNAL_SIGHUP = 1;
    public const EXITCODE_FATA_ERROR_SIGNAL = 128;

    /**
     * @param int $exitCode
     * @return void
     */
    public function seal(int $exitCode): void;

    /**
     * @return int
     */
    public function getExitCode(): int;
    
    /**
     * @return ConsoleResultTime
     */
    public function getTime(): ConsoleResultTime;
    
    /**
     * @return array
     * @throws \JsonException
     */
    public function toArray(): array;


}

