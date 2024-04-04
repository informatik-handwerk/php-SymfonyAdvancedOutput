<?php

declare(strict_types=1);

namespace App\Command\Utils;


interface AdvancedOutputLike
    extends AdvancedOutputConditional,
            AdvancedOutputWriteln
{

}

