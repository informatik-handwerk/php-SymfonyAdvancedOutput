<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

trait ConsoleOutputterTrait
{
    /** @var null|Output|AdvancedOutputLike|ConsoleOutputter $autputModel */
    private $autputModel;
    private AdvancedOutputLike $autput;
    private string $autputObject;
    public string $autputIndent = "";
    /** @var ProgressBar|ProgressBarLike|null */
    private $autputProgressBar = null;

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function initializeConsoleOutputter($autputModel, bool $authoritative): void
    {
        if (!isset($this->autputModel) || $authoritative) {
            $this->autputModel = $autputModel;
        }

        foreach ($this as $property) {
            if ($property === $this) {
                continue;
            }
            if ($property instanceof ConsoleOutputter)  {
                $property->initializeConsoleOutputter($autputModel, false);
            }
        }
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out(): AdvancedOutputLike
    {
        if (!isset($this->autput)) {
            $className = \substr(\strrchr(\get_class($this), "\\"), 1);
            $this->autputObject = $className . "." . \spl_object_id($this);

            if (!isset($this->autputModel)) {
                $this->autput = VoidAdvancedOutput::instance();
            } elseif ($this->autputModel instanceof OutputInterface) {
                $this->autput = new AdvancedOutput($this->autputModel);
            } elseif ($this->autputModel instanceof AdvancedOutputLike) {
                $this->autput = $this->autputModel;
                $this->autputIndent = "    ";
            } elseif ($this->autputModel instanceof ConsoleOutputter) {
                $this->autput = $this->autputModel->out();
                $this->autputIndent = $this->autputModel->autputIndent . "    ";
            } else {
                throw new \LogicException("Unexpected type.");
            }
        }

        return $this->autput;
    }

    /**
     * @param AdvancedOutputWriteln $autput
     * @param string $stringModel
     * @param array $vsprintf
     * @param array $colorMapper
     * @return void
     */
    protected function out_writeln(
        AdvancedOutputWriteln $autput,
        string $stringModel,
        array $vsprintf = [],
        array $colorMapper = []
    ): void {
        if ($this->autputProgressBar) {
            $this->autputProgressBar->clear();
        }

        $autput = $autput ?? $this->out();
        $autput->writeln(
            $this->autputIndent . "<gray>[" . $this->autputObject . "]</gray> " . $stringModel,
            $vsprintf,
            $colorMapper
        );

        if ($this->autputProgressBar) {
            $this->autputProgressBar->display();
        }
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_no(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_noIf(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if_q(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out()->if_q(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if_n(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out()->if_n(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if_v(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out()->if_v(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if_vv(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out()->if_vv(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if_vvv(string $stringModel, array $vsprintf = [], array $colorMapper = []): void
    {
        $this->out_writeln(
            $this->out()->if_vvv(),
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @implements ConsoleOutputter
     * @inheritDoc
     */
    public function out_if(
        string $ifVerbosity,
        string $stringModel,
        array $vsprintf = [],
        array $colorMapper = []
    ): void {
        assert(\in_array($ifVerbosity, ConsoleOutputter::VERBOSITIES, true));

        $fOut = "out_$ifVerbosity";
        $this->{$fOut}(
            $stringModel,
            $vsprintf,
            $colorMapper
        );
    }

    /**
     * @return ProgressBar|ProgressBarLike
     */
    public function out_progressBar()
    {
        if ($this->autputProgressBar !== null) {
            throw new \LogicException("Multiple progress bars not supported.");
        }

        $this->autputProgressBar = $this->out()->progressBar();
        return $this->autputProgressBar;
    }

    /**
     * @return ProgressBar|ProgressBarLike
     */
    public function out_progressBar_fixate()
    {
        $this->out()->writeln("");
        return $this->autputProgressBar;
    }

    /**
     * @return void
     */
    public function out_progressBar_finish(): void
    {
        $this->autputProgressBar->finish();
        $this->out()->writeln("");
        $this->autputProgressBar = null;
    }


}
