<?php

declare(strict_types=1);

namespace App\Command\Utils;


use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Output\OutputInterface;

class VoidProgressBar
    implements ProgressBarLike
{
    protected static self $instance;

    /**
     *
     */
    protected function __construct()
    {
    }

    /**
     * @return static
     */
    public static function instance(): self
    {
        self::$instance = self::$instance ?? new static();
        return self::$instance;
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function setFormat(string $format)
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function start(int $max = null)
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function advance(int $step = 1)
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function setProgress(int $step)
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function setMaxSteps(int $max)
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function finish(): void
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function display(): void
    {
    }

    /**
     * @implements ProgressBarLike
     * @inheritDoc
     */
    public function clear(): void
    {
    }

}

