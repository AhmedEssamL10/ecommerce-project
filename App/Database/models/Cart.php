<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Cart extends Model implements Crud
{
    private $users_id, $products_id, $quantity;
    public function create()
    {
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
     * Get the value of products_id
     */
    public function getProducts_id()
    {
        return $this->products_id;
    }

    /**
     * Set the value of products_id
     *
     * @return  self
     */
    public function setProducts_id($products_id)
    {
        $this->products_id = $products_id;

        return $this;
    }

    /**
     * Get the value of users_id
     */
    public function getUsers_id()
    {
        return $this->users_id;
    }

    /**
     * Set the value of users_id
     *
     * @return  self
     */
    public function setUsers_id($users_id)
    {
        $this->users_id = $users_id;

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
    public function cartList()
    {
        $query = "SELECT products.en_name,products.price,products.image as productImage, 
        carts.quantity , products.id , products.status , users.id , carts.users_id , carts.products_id 
        FROM products JOIN carts on carts.products_id = products.id  JOIN users on carts.users_id =users.id
        WHERE users_id=  ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('i', $this->users_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteCartItem()
    {
        $query = "DELETE FROM `carts` WHERE users_id= ? AND products_id= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('ii', $this->users_id, $this->products_id);
        return  $stmt->execute();
    }
    public function addCartItem()
    {
        $query = "INSERT INTO `carts`(`users_id`, `products_id` ,`quantity`) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('iii', $this->users_id, $this->products_id, $this->quantity);
        return  $stmt->execute();
    }
    public function updateQuantity()
    {
        $query = "UPDATE `carts` SET `quantity`=? WHERE `users_id` = ? AND `products_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('iii', $this->quantity, $this->users_id, $this->products_id);
        return  $stmt->execute();
    }
    public function deleteAll()
    {
        $query = "DELETE FROM `carts` WHERE `users_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('i', $this->users_id);
        return  $stmt->execute();
    }
}
//DELETE FROM `carts` WHERE `users_id` = ?