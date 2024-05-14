<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\contracts;

interface ConsoleResultTime
{

    /**
     * @return void
     */
    public function seal(): void;
    
    /**
     * @return array
     * @throws \JsonException
     */
    public function toArray(): array;


}

