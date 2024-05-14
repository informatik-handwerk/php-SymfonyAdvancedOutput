<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\contracts;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\Output;

interface ConsoleOutputter
{
    public const IF_q = "if_q";
    public const IF_n = "if_n";
    public const IF_v = "if_v";
    public const IF_vv = "if_vv";
    public const IF_vvv = "if_vvv";
    public const IF_any = "noIf";
    public const IF_no = "no";
    public const VERBOSITIES = [
        self::IF_q,
        self::IF_n,
        self::IF_v,
        self::IF_vv,
        self::IF_vvv,
        self::IF_any,
        self::IF_no,
    ];
    
    /**
     * @param null|Output|AdvancedOutputLike|ConsoleOutputter $autputModel
     * @param bool $authoritative
     * @return void
     */
    public function initializeConsoleOutputter($autputModel, bool $authoritative): void;
    
    /**
     * @return AdvancedOutputLike
     */
    public function out(): AdvancedOutputLike;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_no(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_noIf(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if_q(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if_n(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if_v(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if_vv(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if_vvv(string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @implements AdvancedOutputWriteln::writeln
     * @param string $verbosity
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    public function out_if(string $ifVerbosity, string $stringModel, array $vsprintf = [], array $colorMapper = []): void;
    
    /**
     * @return ProgressBar|ProgressBarLike
     */
    public function out_progressBar();
    
}
