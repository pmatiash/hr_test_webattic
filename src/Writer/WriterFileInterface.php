<?php

namespace OpsWay\Migration\Writer;

interface WriterFileInterface extends WriterInterface
{
    /**
     * @param string $fileName
     * @return mixed
     */
    public function setFileName($fileName);
}
