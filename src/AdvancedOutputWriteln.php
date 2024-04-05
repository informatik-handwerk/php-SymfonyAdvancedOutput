<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

use Symfony\Component\Console\Helper\ProgressBar;

interface AdvancedOutputWriteln
{
    /**
     * @param string $stringModel
     * @param null|array<int, string> $vsprintf
     * @param null|array<int, array|callable> $colorMapper
     * @return void
     */
    public function writeln(string $stringModel, ?array $vsprintf = null, array $colorMapper = null): void;
    
    /**
     * @param string[] $lines
     * @param string $style
     * @return void
     */
    public function writeLargeBlock(array $lines, string $style): void;
    
    /**
     * @return ProgressBar|ProgressBarLike
     */
    public function progressBar();
    
    /**
     * @param \Throwable $t
     * @return void
     */
    public function renderThrowable(\Throwable $t): void;
    
    
}

