<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;


interface ProgressBarLike
{
    
    public function setFormat(string $format);
    
    /**
     * Starts the progress output.
     *
     * @param int|null $max Number of steps to complete the bar (0 if indeterminate), null to leave unchanged
     */
    public function start(int $max = null);
    
    /**
     * Advances the progress output X steps.
     *
     * @param int $step Number of steps to advance
     */
    public function advance(int $step = 1);
    
    public function setProgress(int $step);
    
    public function setMaxSteps(int $max);
    
    /**
     * Finishes the progress output.
     */
    public function finish(): void;
    
    /**
     * Outputs the current progress string.
     */
    public function display(): void;
    
    /**
     * Removes the progress bar from the current line.
     *
     * This is useful if you wish to write some output
     * while a progress bar is running.
     * Call display() to show the progress bar again.
     */
    public function clear(): void;
    
}

