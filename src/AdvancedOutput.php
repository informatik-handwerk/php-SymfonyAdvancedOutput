<?php

declare(strict_types=1);

namespace App\Command\Utils;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;

class AdvancedOutput implements AdvancedOutputLike
{
    public const COLOR_black = "black";
    public const COLOR_red = "red";
    public const COLOR_green = "green";
    public const COLOR_yellow = "yellow";
    public const COLOR_blue = "blue";
    public const COLOR_magenta = "magenta";
    public const COLOR_cyan = "cyan";
    public const COLOR_white = "white";
    public const COLOR_default = "default";
    public const COLOR_gray = 'gray';
    public const COLOR_bright_red = 'bright-red';
    public const COLOR_bright_green = 'bright-green';
    public const COLOR_bright_yellow = 'bright-yellow';
    public const COLOR_bright_blue = 'bright-blue';
    public const COLOR_bright_magenta = 'bright-magenta';
    public const COLOR_bright_cyan = 'bright-cyan';
    public const COLOR_bright_white = 'bright-white';

    public const COLORS = [
        self::COLOR_black,
        self::COLOR_red,
        self::COLOR_green,
        self::COLOR_yellow,
        self::COLOR_blue,
        self::COLOR_magenta,
        self::COLOR_cyan,
        self::COLOR_white,
        self::COLOR_default,
        self::COLOR_gray,
        self::COLOR_bright_red,
        self::COLOR_bright_green,
        self::COLOR_bright_yellow,
        self::COLOR_bright_blue,
        self::COLOR_bright_magenta,
        self::COLOR_bright_cyan,
        self::COLOR_bright_white,
    ];

    public const OPTION_bold = "bold";
    public const OPTION_underscore = "underscore";
    public const OPTION_blink = "blink";
    public const OPTION_reverse = "reverse";
    public const OPTION_conceal = "conceal";

    protected OutputInterface $output;
    protected FormatterHelper $formatterHelper;
    protected Application $application; #lazy init

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        $this->formatterHelper = new FormatterHelper();

        foreach (static::COLORS as $fg) {
            $colorStyle = new OutputFormatterStyle($fg);
            $output->getFormatter()->setStyle($fg, $colorStyle);
            $colorStyle = new OutputFormatterStyle($fg, null, [self::OPTION_bold]);
            $output->getFormatter()->setStyle(self::OPTION_bold. "-" . $fg, $colorStyle);

            foreach (static::COLORS as $bg) {
                $colorStyle = new OutputFormatterStyle($fg, $bg);
                $output->getFormatter()->setStyle("{$fg}-on-{$bg}", $colorStyle);
            }
        }
    }

    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function writeln(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $mapping = [];

        foreach ($colorMapper as $vsprintfIndex => $mapper) {
            $value = $vsprintf[$vsprintfIndex];
            if (\is_array($mapper))  {
                $colorActually = $mapper[$value] ?? null;
            } elseif (\is_callable($mapper))  {
                $colorActually = $mapper($value, $vsprintfIndex);
            } else {
                $colorActually = null;
            }
            $mapping["<$vsprintfIndex>"] = $colorActually ? "<$colorActually>" : "";
            $mapping["</$vsprintfIndex>"] = $colorActually ? "</$colorActually>" : "";
        }

        if (empty($vsprintf)) {
            $stringModel = \str_replace("%", "%%", $stringModel);
        }

        $string = \vsprintf($stringModel, $vsprintf);
        $stringColored = \str_replace(\array_keys($mapping), \array_values($mapping), $string);

        $this->output->writeln($stringColored);
    }

    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function writeLargeBlock(array $lines, string $style): void
    {
        $formattedBlock = $this->formatterHelper->formatBlock($lines, $style, true);
        $this->output->writeln($formattedBlock);
        $this->output->writeln("");
    }

    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function renderThrowable(\Throwable $t): void
    {
        if (!isset($this->application))  {
            $this->application = new Application();
        }

        $oldVerbosity = $this->output->getVerbosity();
        $this->output->setVerbosity(OutputInterface::VERBOSITY_VERY_VERBOSE);

        $this->application->renderThrowable($t, $this->output);

        $this->output->setVerbosity($oldVerbosity);
    }

    /**
     * @param array $headers
     * @param array $items
     * @param callable|null $mapper
     * @return Table
     */
    public function constructTable(array $headers, array $items, ?callable $mapper): Table
    {
        $table = new Table($this->output);
        $table->setHeaders($headers);

        foreach ($items as $item) {
            if ($mapper) {
                $item = $mapper($item);
            }

            $table->addRow($item);
        }

        return $table;
    }

    /**
     * @param callable $test
     * @return AdvancedOutputWriteln
     */
    public function if(callable $test): AdvancedOutputWriteln {
        if ($test())  {
            return $this;
        } else  {
            return VoidAdvancedOutput::instance();
        }
    }

    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_q(): AdvancedOutputWriteln {
        return $this->if([$this->output, "isQuiet"]);
    }

    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_n(): AdvancedOutputWriteln {
        return $this->if(
            fn(): bool => $this->output->getVerbosity() >= OutputInterface::VERBOSITY_NORMAL
        );
    }

    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_v(): AdvancedOutputWriteln {
        return $this->if([$this->output, "isVerbose"]);
    }

    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_vv(): AdvancedOutputWriteln {
        return $this->if([$this->output, "isVeryVerbose"]);
    }

    /**
     * @implements AdvancedOutputConditional
     * @inheritDoc
     */
    public function if_vvv(): AdvancedOutputWriteln {
        return $this->if([$this->output, "isDebug"]);
    }

    /**
     * @implements AdvancedOutputWriteln
     * @inheritDoc
     */
    public function progressBar()
    {
        return new ProgressBar($this->output);
    }


}

