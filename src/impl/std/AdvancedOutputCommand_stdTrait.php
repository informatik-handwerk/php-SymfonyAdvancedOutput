<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\impl\std;

use ihde\php74\SymfonyAdvancedOutput\contracts\ConsoleOutputter;
use Symfony\Component\Console\Helper\Helper;

trait AdvancedOutputCommand_stdTrait
{
    
    /**
     * @param string $name
     * @param $value
     * @return void
     */
    protected function outputParameter(string $name, $value): void {
        /** @var ConsoleOutputter $this */
        
        if ($value === null) {
            $value = "<gray>null</gray>";
            
        } elseif (\is_bool($value)) {
            $value = "(bool) <white>" . ($value ? "true" : "false") . "</white>";
            
        } elseif (\is_int($value) || \is_float($value)) {
            $value = "(number) <white>$value</white>";
            
        } elseif (\is_string($value)) {
            $value = "(string) <white>$value</white>";
            
        } elseif ($value instanceof \DateTimeInterface) {
            $value = "(time) <white>" . $this->formatAs_dateTime($value) . "</white>";
            
        } else {
            $type = \gettype($value);
            if (\is_scalar($value)) {
                $value = "($type) <white>$value</white>";
            } else {
                $value = "($type) <white>...</white>";
            }
        }
        
        $this->out_if_n("<bold-white>--$name = </bold-white>$value");
    }
    
    /**
     * @param ConsoleResult_stdClass|\stdClass|array|mixed $result
     * @return int
     * @throws \JsonException
     */
    protected function outputResult($result): int {
        /** @var ConsoleOutputter $this */
        
        if ($result instanceof ConsoleResult_stdClass) {
            $timeObject = $result->time;
        } elseif (\is_object($result->state) && isset($result->state->startTime, $result->state->endTime)) {
            $timeObject = $result->state;
        } else {
            $timeObject = null;
        }
        
        if ($timeObject !== null) {
            $timeObject->elapsed = $this->formatAs_duration($timeObject->startTime, $timeObject->endTime);
            $timeObject->startTime = $this->formatAs_dateTime($timeObject->startTime);
            $timeObject->endTime = $this->formatAs_dateTime($timeObject->endTime);
        }
        
        $this->out_if_n(
            "<bold-white>\$result = </bold-white>\n"
            . "<white>"
            . \json_encode($result, \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT)
            . "</white>"
        );
        
        if ($result instanceof ConsoleResult_stdClass) {
            return $result->getExitCode();
        } else {
            //invalid, not implemented, caller should know
            return -1;
        }
    }
    
    /**
     * @param \DateTimeInterface|int $value
     * @param string $format https://www.php.net/manual/en/datetime.format.php
     * @return string
     */
    protected function formatAs_dateTime($value, string $format = "r"): string {
        $dateTime = $this->valToTime_dateTime($value);
        
        $result = $dateTime->format($format);
        return $result;
    }
    
    /**
     * @param \DateTimeInterface|int $from
     * @param \DateTimeInterface|int $to
     * @return string
     */
    protected function formatAs_duration($from, $to): string {
        $unixFrom = $this->valToTime_unix($from);
        $unixTo = $this->valToTime_unix($to);
        
        $result = Helper::formatTime($unixTo - $unixFrom);
        return $result;
    }
    
    /**
     * @param \DateTimeInterface|int $value
     * @return int
     */
    protected function valToTime_unix($value): int {
        if (\is_int($value)) {
            return $value;
            
        } elseif ($value instanceof \DateTimeInterface) {
            return $value->getTimestamp();
            
        } else {
            throw new \TypeError('@param \DateTimeInterface|int $value');
        }
    }
    
    /**
     * @param \DateTimeInterface|int $value
     * @return \DateTimeInterface
     */
    protected function valToTime_dateTime($value): \DateTimeInterface {
        if (\is_int($value)) {
            return new \DateTimeImmutable("@$value");
            
        } elseif ($value instanceof \DateTimeInterface) {
            return $value;
            
        } else {
            throw new \TypeError('@param \DateTimeInterface|int $value');
        }
    }
    
    
}
