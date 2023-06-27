<?php

namespace App\Database\Http\Requests;

use App\Database\Models\Contract\Model;

// this class validate on inputs and return errors if exists
class validation
{
    private string $input;
    private $value;
    private array $errors = [];

    /**
     * Get the value of input
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Set the value of input
     *
     * @return  self
     */
    public function setInput($input)
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Get the value of value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
    public function getError(string $input)
    {
        if (isset($this->errors[$input])) {
            foreach ($this->errors[$input] as $error) {

                return $error;
            }
        } else
            return null;
    }

    /**
     * Set the value of errors
     *
     * @return  self
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    public function required()
    {
        if (empty($this->value)) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = str_replace("_", " ", $this->input) . " is required";
        }
        return $this;
    }
    public function max(int $max)
    {
        if (strlen($this->value) > $max) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = str_replace("_", " ", $this->input) . " length should less than $max character";
        }
        return $this;
    }
    public function min(int $min)
    {
        if (strlen($this->value) < $min) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = str_replace("_", " ", $this->input) . " length should greater than $min character";
        }
        return $this;
    }
    public function in(array $values)
    {
        if (!in_array($this->value, $values)) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = str_replace("_", " ", $this->input) . " must be" . implode(',', $values);
        }
        return $this;
    }
    public function regex(string $pattern, string $massage = "")
    {
        if (!preg_match($pattern, $this->value)) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = $massage ? $massage : str_replace("_", " ", $this->input) . " invalid";
        }
        return $this;
    }
    public function confirmation($input)
    {
        if (!($this->value == $input)) {
            // array_push($this -> errors, "This field is Required");
            // return false;
            $this->errors[$this->input][__FUNCTION__] = str_replace("_", " ", $this->input) . " not confirmed";
        }
        return $this;
    }
    public function getOldValues(string $input)
    {
        if (isset($_POST[$input])) {
            return $_POST[$input];
        } else
            return null;
    }
    public function unique(string $table, string $col)
    {
        $query = "SELECT * FROM {$table} WHERE {$col} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        $stmt->bind_Param('s', $this->value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows >= 1) {
            $this->errors[$this->input][__FUNCTION__] = "This " . str_replace("_", " ", $this->input) . "  Already exists";
        }
        return $this;
    }
    public function exists(string $table, string $col)
    {
        $query = "SELECT * FROM {$table} WHERE {$col} = ?";
        $model = new Model;
        $stmt = $model->conn->prepare($query);
        $stmt->bind_Param('s', $this->value);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $this->errors[$this->input][__FUNCTION__] = "This " . str_replace("_", " ", $this->input) . "  not exists";
        }
        return $this;
    }
}
//rowCount()