<?php

namespace OpsWay\Migration\Logger;

use OpsWay\Migration\Writer\WriterFactory;

class OutOfStockLogger
{
    /**
     * @var \OpsWay\Migration\Writer\WriterFileInterface
     */
    private $writer;

    private $keyQty = null;
    private $keyIsStock = null;

    const FIELD_NAME_QTY = 'qty';
    const FIELD_NAME_IS_STOCK = 'is_stock';

    public function __construct(array $params)
    {
        $this->writer = WriterFactory::create('OpsWay\Migration\Writer\File\Csv');

        if (!empty($params['out_of_stock_file'])) {
            $this->writer->setFileName($params['out_of_stock_file']);
        }
    }

    public function __invoke($item, $status, $msg)
    {
        if (is_null($this->keyQty)) {
            $this->keyQty = array_search(static::FIELD_NAME_QTY, $item);
        }

        if (is_null($this->keyIsStock )) {
            $this->keyIsStock = array_search(static::FIELD_NAME_IS_STOCK, $item);
        }

        if ($item[$this->keyQty] == static::FIELD_NAME_QTY || $item[$this->keyIsStock] == static::FIELD_NAME_IS_STOCK) {
            return false;
        }

        if ($item[$this->keyQty] == 0 & $item[$this->keyIsStock] == 0) {
            $this->writer->write($item);
        }
    }
}
