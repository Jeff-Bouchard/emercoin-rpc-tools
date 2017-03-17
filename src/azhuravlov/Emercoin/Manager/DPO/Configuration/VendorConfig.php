<?php

namespace azhuravlov\Emercoin\Manager\DPO\Configuration;

class VendorConfig
{
    /** @var string */
    protected $vendor = 'DPO VENDOR NAME';
    /** @var string */
    protected $salt = 'SALT TO HASH PASSWORDS';
    /** @var int */
    protected $NVS_DAYS = 3650;
    /** @var int */
    protected $allowedUpdates = 2;
    /** @var int */
    protected $searchDepth = 10;
    /** @var string */
    protected $name = 'Name';
    /** @var string */
    protected $logo = 'Logo';

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return int
     */
    public function getNVSDAYS()
    {
        return $this->NVS_DAYS;
    }

    /**
     * @param int $NVS_DAYS
     */
    public function setNVSDAYS($NVS_DAYS)
    {
        $this->NVS_DAYS = $NVS_DAYS;
    }

    /**
     * @return int
     */
    public function getAllowedUpdates()
    {
        return $this->allowedUpdates;
    }

    /**
     * @param int $allowedUpdates
     */
    public function setAllowedUpdates($allowedUpdates)
    {
        $this->allowedUpdates = $allowedUpdates;
    }

    /**
     * @return int
     */
    public function getSearchDepth()
    {
        return $this->searchDepth;
    }

    /**
     * @param int $searchDepth
     */
    public function setSearchDepth($searchDepth)
    {
        $this->searchDepth = $searchDepth;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }
}
