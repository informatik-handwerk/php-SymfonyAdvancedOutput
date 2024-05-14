<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

class ServiceResult
{
    private const SIGNAL_SIGHUP = 1;
    private const EXITCODE_FATA_ERROR_SIGNAL = 128;

    public ServiceResultTime $time;
    protected int $exitCode = self::EXITCODE_FATA_ERROR_SIGNAL + self::SIGNAL_SIGHUP;

    /**
     *
     */
    public function __construct()
    {
        $this->time = new ServiceResultTime();
    }

    /**
     * @param int $exitCode
     * @return void
     */
    public function seal(int $exitCode): void
    {
        assert($exitCode >= 0 && $exitCode <= 255);

        $this->time->seal();
        $this->exitCode = $exitCode;
    }

    /**
     * @return int
     */
    public function getExitCode(): int
    {
        return $this->exitCode;
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

