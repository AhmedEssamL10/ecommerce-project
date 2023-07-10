<?php

/*INSERT INTO orders_products (price, product_id, quantity, user_id)
SELECT products.price, carts.products_id, carts.quantity, carts.users_id
FROM carts 
JOIN products  ON carts.products_id = products.id
HAVING carts.users_id = 42 */

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Orders_products extends Model implements Crud
{
    private $user_id, $product_id, $quantity, $price, $id;
    public function create()
    {

        $query = "INSERT INTO orders_products (price, product_id, quantity, user_id)
            SELECT products.price, carts.products_id, carts.quantity, carts.users_id
            FROM carts 
            JOIN products  ON carts.products_id = products.id
            HAVING carts.users_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('i', $this->user_id);
        return  $stmt->execute();
    }
    public function read()
    {
    }
    public function update()
    {
    }
    public function delete()
    {
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
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

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
}
