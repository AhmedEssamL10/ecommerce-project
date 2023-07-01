<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class SubCategory extends Model implements Crud
{
    private $id, $en_name, $ar_name, $status, $image, $created_at, $updated_at, $catigories_id;
    private const ACTIVE = 1;
    private const NOT_ACTIVE = 0;
    public function create()
    {
    }
    public function read()
    {
        $query = "SELECT * FROM subcatigories WHERE status =  " . self::ACTIVE;
        return $this->conn->query($query);
    }
    public function update()
    {
    }
    public function delete()
    {
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * Get the value of en_name
     */
    public function getEn_name()
    {
        return $this->en_name;
    }

    /**
     * Set the value of en_name
     *
     * @return  self
     */
    public function setEn_name($en_name)
    {
        $this->en_name = $en_name;

        return $this;
    }

    /**
     * Get the value of ar_name
     */
    public function getAr_name()
    {
        return $this->ar_name;
    }

    /**
     * Set the value of ar_name
     *
     * @return  self
     */
    public function setAr_name($ar_name)
    {
        $this->ar_name = $ar_name;

        return $this;
    }

    /**
     * Get the value of catigories_id
     */
    public function getCatigories_id()
    {
        return $this->catigories_id;
    }

    /**
     * Set the value of catigories_id
     *
     * @return  self
     */
    public function setCatigories_id($catigories_id)
    {
        $this->catigories_id = $catigories_id;

        return $this;
    }
}
