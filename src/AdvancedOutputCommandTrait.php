<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

use App\Service\API\ServiceResult;
use Symfony\Component\Console\Helper\Helper;

trait AdvancedOutputCommandTrait
{
    
    /**
     * @param string $name
     * @param $value
     * @return void
     */
    protected function outputParameter(string $name, $value): void {
        if ($value === null) {
            $value = "<gray>null</gray>";
        } elseif (\is_bool($value)) {
            $value = "(bool) <white>" . ($value ? "true" : "false") . "</white>";
        } elseif (\is_int($value) || \is_float($value)) {
            $value = "(number) <white>$value</white>";
        } elseif (\is_string($value)) {
            $value = "(string) <white>$value</white>";
        } elseif ($value instanceof \DateTimeInterface) {
            $value = "(date) <white>" . $value->format("r") . "</white>";
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
     * @param \stdClass|array|mixed $result
     * @return void
     * @throws \JsonException
     */
    protected function outputResult($result): int {
        if (\is_object($result)) {
            if ($result instanceof ServiceResult) {
                $timeObject = $result->time;
            } else {
                $timeObject = $result->state;
            }
            
            $timeObject->elapsed = Helper::formatTime($timeObject->endTime - $timeObject->startTime);
            $timeObject->startTime = (new \DateTimeImmutable("@{$timeObject->startTime}"))->format("r");
            $timeObject->endTime = (new \DateTimeImmutable("@{$timeObject->endTime}"))->format("r");
        }
        
        $this->out_if_n(
            "<bold-white>\$result = </bold-white>\n"
            . "<white>"
            . \json_encode($result, \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT)
            . "</white>"
        );
        
        if ($result instanceof ServiceResult) {
            return $result->exitCode;
        } else {
            //invalid, not implemented, caller should know
            return -1;
        }
    }
    
    
}
