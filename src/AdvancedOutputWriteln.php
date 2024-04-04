<?php

declare(strict_types=1);

namespace App\Command\Utils;

use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

interface AdvancedOutputWriteln
{
    /**
     * @param string $stringModel
     * @param array<int, string> $vsprintf
     * @param array<int, array|callable> $colorMapper
     * @return void
     */
    public function writeln(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;

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

