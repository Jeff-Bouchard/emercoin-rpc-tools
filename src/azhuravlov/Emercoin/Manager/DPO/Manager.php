<?php

namespace azhuravlov\Emercoin\Manager\DPO;

use azhuravlov\Emercoin\Connection\ConnectionInterface;
use azhuravlov\Emercoin\Exception\TransportException;
use azhuravlov\Emercoin\Manager\DPO\Configuration\ProductConfig;
use azhuravlov\Emercoin\Manager\DPO\Configuration\VendorConfig;
use azhuravlov\Emercoin\Manager\DPO\Exception\ConfigurationException;
use azhuravlov\Emercoin\Manager\ManagerInterface;
use azhuravlov\Emercoin\NVS\Exception\RecordNotFoundException;
use azhuravlov\Emercoin\NVS;

class Manager implements ManagerInterface
{
    /** @var ConnectionInterface */
    protected $connection;
    /** @var NVS\DPO */
    protected $vendor;
    /** @var VendorConfig */
    protected $vendorConfig;
    /** @var ProductConfig */
    protected $productConfig;

    /**
     * @param ConnectionInterface $connection
     * @param VendorConfig $vendorConfig
     * @param ProductConfig $productConfig
     */
    public function __construct(
        ConnectionInterface $connection,
        VendorConfig $vendorConfig,
        ProductConfig $productConfig
    ) {
        $this->connection = $connection;
        $this->vendorConfig = $vendorConfig;
        $this->productConfig = $productConfig;

        try {
            $this->vendor = new NVS\DPO($connection, $vendorConfig->getVendor());
        } catch (RecordNotFoundException $e) {
            throw new ConfigurationException(
                sprintf('Vendor "%s" can not be found in NVS database.', $vendorConfig->getVendor())
            );
        }
    }

    /**
     * @return NVS\DPO
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param $record string
     * @return Product
     */
    public function getProduct($record)
    {
        for ($i = 0; $i < $this->vendorConfig->getSearchDepth(); $i++) {
            try {
                $product = new Product(
                    $this->connection,
                    "{$this->vendorConfig->getVendor()}:{$record}:{$i}",
                    $this->productConfig
                );

                if ($product->hasSignature()) {
                    if ($this->verifyBySignature($product)) {
                        return $product;
                    }
                }

                if (!$product->hasSignature() && !$product->isExpired()) {
                    if ($this->verifyByAddress($product)) {
                        return $product;
                    }
                }
            } catch (RecordNotFoundException $e) {
                break;
            }
        }

        return null;
    }

    /**
     * @param Product $product
     * @return bool
     */
    protected function verifyByAddress(Product $product)
    {
        if ($this->vendor->getAddress() === $product->getHistoryAddress()) {
            $product->setVerified(true);
            $product->setVerifiedBy(Product::ADDRESS);
        }

        return $product->isVerified();
    }

    /**
     * @param Product $product
     * @return bool
     */
    protected function verifyBySignature(Product $product)
    {
        $response = $this->connection->query(
            'verifymessage',
            [
                $this->getVendor()->getAddress(),
                $product->getSignature(),
                $product->verifyData(),
            ]
        );
        if ($response->getResult() && !$product->isExpired()) {
            $product->setVerified(true);
            $product->setVerifiedBy(Product::SIGNATURE);
        };

        return $product->isVerified();
    }

    /**
     * @param Product $product
     * @return bool
     * @throws TransportException
     */
    public function persist(Product $product)
    {
        $this->connection->query(
            'name_update',
            [
                $product->getName(),
                $product->getValue(),
                $this->vendorConfig->getNVSDAYS(),
                (($product->getVerifiedBy() === Product::ADDRESS)
                    ? $product->getHistoryAddress()
                    : $product->getAddress()
                ),
            ]
        );

        return true;
    }
}
