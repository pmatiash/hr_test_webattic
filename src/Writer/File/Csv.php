<?php

namespace OpsWay\Migration\Writer\File;

use OpsWay\Migration\Writer\WriterFileInterface;

class Csv implements WriterFileInterface
{
    protected $file;
    protected $filename = 'default.csv';

    public function __construct(array $params)
    {
        if (!empty($params['filename'])) {
            $this->filename =  $params['filename'];
        }

        $this->checkFileName();
    }

    /**
     * @param $item array
     *
     * @return bool
     */
    public function write(array $item)
    {
        if (!$this->file) {
            if (!($this->file = fopen($this->filename, 'w+'))) {
                throw new \RuntimeException(sprintf('Can not create file "%s" for writing data.', $this->filename));
            }
            fputcsv($this->file, array_keys($item));
        }
        return fputcsv($this->file, $item);
    }

    public function __destruct()
    {
        if ($this->file) {
            fclose($this->file);
        }
    }

    private function checkFileName()
    {
        if (file_exists($this->filename)) {
            throw new \RuntimeException(sprintf('File "%s" already exists. Remove it and run again.', $this->filename));
        }
    }

    /**
     * @param string $fileName
     * @return $this
     */
    public function setFilename($fileName)
    {
        if (!$fileName) {
            throw new \RuntimeException('File Name is not set!');
        }

        $this->filename = $fileName;
        return $this;
    }
}
