<?php

namespace App\Database\models;

use App\Database\Models\Contract\Model;
use App\Database\Models\Contract\Crud;

class Products extends Model implements Crud

{
    private $id, $en_name, $ar_name, $price, $quantity, $status, $image, $code,
        $details_ar, $detials_en, $brand_id, $subcategory_id, $created_at, $updated_at;
    private const ACTIVE = 1;
    private const NOT_ACTIVE = 0;
    function read()
    {
        $query = "SELECT * FROM products WHERE status =  " . self::ACTIVE;
        return $this->conn->query($query);
    }
    function create()
    {
    }
    function update()
    {
    }
    function delete()
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
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of details_ar
     */
    public function getDetails_ar()
    {
        return $this->details_ar;
    }

    /**
     * Set the value of details_ar
     *
     * @return  self
     */
    public function setDetails_ar($details_ar)
    {
        $this->details_ar = $details_ar;

        return $this;
    }

    /**
     * Get the value of detials_en
     */
    public function getDetials_en()
    {
        return $this->detials_en;
    }

    /**
     * Set the value of detials_en
     *
     * @return  self
     */
    public function setDetials_en($detials_en)
    {
        $this->detials_en = $detials_en;

        return $this;
    }

    /**
     * Get the value of brand_id
     */
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

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
    function getProductByName(string $input, int $value)
    {
        $query = "SELECT * FROM products WHERE status =  " . self::ACTIVE . " AND $input = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $value);
        $stmt->execute();
        return $stmt->get_result();
    }
}
