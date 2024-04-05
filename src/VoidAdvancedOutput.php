<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

class VoidAdvancedOutput implements AdvancedOutputLike
{
    protected static self $instance;
    
    /**
     *
     */
    protected function __construct() {
    }
    
    /**
     * @return static
     */
    public static function instance(): self {
        self::$instance = self::$instance ?? new static();
        return self::$instance;
    }
    
    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function writeln(string $stringModel, ?array $vsprintf = null, ?array $colorMapper = null): void {
    }
    
    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function writeLargeBlock(array $lines, string $style): void {
    }
    
    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function renderThrowable(\Throwable $t): void {
    }
    
    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_q(): AdvancedOutputWriteln {
        return $this;
    }
    
    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_n(): AdvancedOutputWriteln {
        return $this;
    }
    
    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_v(): AdvancedOutputWriteln {
        return $this;
    }
    
    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_vv(): AdvancedOutputWriteln {
        return $this;
    }
    
    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_vvv(): AdvancedOutputWriteln {
        return $this;
    }
    
    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function progressBar() {
        return VoidProgressBar::instance();
    }
    
    
}

