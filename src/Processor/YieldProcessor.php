<?php

namespace OpsWay\Migration\Processor;

class YieldProcessor extends AbstractProcessor
{
    public function processing()
    {
        while ($item = $this->getReader()->read()) {
            yield $item;
        }
    }
}
