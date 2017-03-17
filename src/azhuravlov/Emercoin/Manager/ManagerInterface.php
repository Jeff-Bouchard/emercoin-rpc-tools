<?php

namespace azhuravlov\Emercoin\Manager;

use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\Manager\DPO\Product;

interface ManagerInterface
{
    public function getProduct($record);

    /**
     * @param Product $product
     * @return boolean
     * @throws TransportException
     */
    public function persist(Product $product);
}
