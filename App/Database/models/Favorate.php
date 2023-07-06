<?php

namespace App\Database\Models;

use App\Database\Models\Contract\Crud;
use App\Database\Models\Contract\Model;

class Favorate extends Model implements Crud
{
    private $users_id, $products_id;
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
    public function favorateList()
    {
        $query = "SELECT products.en_name,products.price,products.image as productImage , products.id , products.status , users.id , favorite.users_id , favorite.products_id FROM products JOIN favorite on favorite.products_id = products.id JOIN users on favorite.users_id =users.id
         WHERE users_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('i', $this->users_id);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function deleteFavItem()
    {
        $query = "DELETE FROM `favorite` WHERE users_id= ? AND products_id= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('ii', $this->users_id, $this->products_id);
        return  $stmt->execute();
    }
    public function addFavItem()
    {
        $query = "INSERT INTO `favorite`(`users_id`, `products_id`) VALUES (?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_Param('ii', $this->users_id, $this->products_id);
        return  $stmt->execute();
    }
}
