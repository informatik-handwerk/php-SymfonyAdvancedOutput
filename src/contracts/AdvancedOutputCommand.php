<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\contracts;

use ihde\php74\SymfonyAdvancedOutput\impl\std\ConsoleResult_stdClass;

interface AdvancedOutputCommand
{
    
    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function outputParameter(string $name, $value): void;
    
    /**
     * @param ConsoleResult_stdClass|\stdClass|array|mixed $result
     * @return int
     * @throws \JsonException
     */
    public function outputResult($result): int;
    
    
}
