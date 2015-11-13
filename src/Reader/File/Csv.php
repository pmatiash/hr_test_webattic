<?php

namespace OpsWay\Migration\Reader\File;

use OpsWay\Migration\Reader\ReaderInterface;

/**
 * Class Csv
 * @package OpsWay\Migration\Reader\File
 */
class Csv implements ReaderInterface {

    private $file;
    private $fileName = 'default.csv';

    public function __construct(array $params)
    {
        if (!empty($params['filename'])) {
            $this->fileName = $params['filename'];
        }

        $this->checkFileName();
    }

    /**
     * @return array
     */
    public function read()
    {
        if (!$this->file) {
            if (!($this->file = fopen($this->fileName, 'r'))) {
                throw new \RuntimeException(sprintf('Can not read file "%s"!', $this->fileName));
            }
        }

        while ($item = fgetcsv($this->file)) {
            return $item;
        }
    }

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    private function checkFileName()
    {
        if (!file_exists($this->fileName)) {
            throw new \RuntimeException(sprintf('File "%s" is not exists. Create it and run again.', $this->fileName));
        }
    }

} 