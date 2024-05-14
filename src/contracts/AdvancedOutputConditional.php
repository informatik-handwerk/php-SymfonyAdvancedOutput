<?php

declare(strict_types=1);

namespace ihde\php74\SymfonyAdvancedOutput\contracts;


interface AdvancedOutputConditional
{
    
    /**
     * @return AdvancedOutputWriteln
     */
    public function if_q(): AdvancedOutputWriteln;
    
    /**
     * @return AdvancedOutputWriteln
     */
    public function if_n(): AdvancedOutputWriteln;
    
    /**
     * @return AdvancedOutputWriteln
     */
    public function if_v(): AdvancedOutputWriteln;
    
    /**
     * @return AdvancedOutputWriteln
     */
    public function if_vv(): AdvancedOutputWriteln;
    
    /**
     * @return AdvancedOutputWriteln
     */
    public function if_vvv(): AdvancedOutputWriteln;
    
}

