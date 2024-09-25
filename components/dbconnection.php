<?php
// clean input
function cleanedInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}


// CRUD class 

class DbConfig
{
    private $hostName = "localhost";
    private $userName = "root";
    private $password = "";
    private $dbName = "full_stack_project_be22";
    private $conn;

    public function __construct() {}

    private function connect()
    {
        $this->conn = @new Mysqli($this->hostName, $this->userName, $this->password, $this->dbName);
        return true;
    }

    private function dcConnect()
    {
        $this->conn->close();
        $this->conn = null;
    }

    public function __destruct()
    {
        if ($this->conn != null) {
            $this->dcConnect();
        }
    }

    public function read($for, $table, $cols = "*", $conditions = "", $join = "", $orderBy = "", $groupBy = "", $subQuery = "")
    {
        $this->connect();
        $columns = "";
        $joins = "";
        if (is_array($cols)) {
            $columns = implode(", ", $cols); # join(", ")
        } else {
            $columns = $cols;
        }

        if (is_array($join)) {
            $joins = implode(" ", $join); # join(", ")
        } else {
            $joins = $join;
        }

        $sql = "SELECT $columns FROM $table $joins $conditions $subQuery $groupBy $orderBy";

        $result = $this->conn->query($sql);

        if ($result->num_rows == 0) {
            if ($for == "JSON") {
                $this->JSONresponse(200, "No results found!");
                return null;
            } else {
                return null;
            }
        } else {
            if ($for == "JSON") {
                $this->JSONresponse(200, "All products!", $result->fetch_all(MYSQLI_ASSOC));
            } else {
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        }

        return false;
    }

    # $obj->delete("users", "id = 5", "API")
    public function delete($table, $where, $for = null)
    {
        $this->connect();

        $stmt = $this->conn->prepare("DELETE FROM $table WHERE $where");

        $stmt->execute();

        $stmt->close();
        if ($for == "JSON") {
            $this->JSONresponse(200, "Product has been deleted!");
        }
        return true;
    }

    # ["name" => "ahmad", "email"=> "email@tt.com"]
    # $obj->update("users", ["email"=>"test@mail.com", "age"=>12], "id = 5 ") 
    public function update($table, $arrayParams, $where, $for = null)
    {
        $this->connect();

        $values = "";
        $data = "";
        $types = "";
        $binds = "";
        $params = [];
        if (is_array($arrayParams)) {
            foreach ($arrayParams as $key => $value) {
                if ($data != "") {
                    $data .= ", ";
                }
                if (is_numeric($value)) {
                    $types .= "i";
                } else {
                    $types .= "s";
                }
                $data .= "$key = ?";

                $params[] = $value;
            }
        } else {
            return false;
        }
        # ?, ?, ?

        $stmt = $this->conn->prepare("UPDATE $table SET $data WHERE $where");


        $bind_names[] = $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_name = 'bind' . $i;
            $$bind_name = $params[$i];
            $bind_names[] = &$$bind_name;
        }

        call_user_func_array([$stmt, 'bind_param'], $bind_names);

        $stmt->execute();


        if ($for == "JSON") {
            $this->JSONresponse(200, "Product has been updated!");
        }

        return true;
    }

    public function create($table, $arrayParams, $for = null)
    {
        $this->connect();

        $values = "";
        $types = "";
        $binds = "";
        $params = [];
        if (is_array($arrayParams)) {
            $keys = array_keys($arrayParams);
            $keys = implode(", ", $keys); # join(", ")

            foreach ($arrayParams as $value) {
                if ($values != "") {
                    $values .= ", ";
                    $binds .= ", ";
                }
                if (is_numeric($value)) {
                    $types .= "i";
                } else {
                    $types .= "s";
                }
                $binds .= "?";
                $values .= "?";
                $params[] = $value;
            }
        } else {
            return false;
        }
        # ?, ?, ?

        $stmt = $this->conn->prepare("INSERT INTO $table ($keys) VALUES ($binds)");


        $bind_names[] = $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_name = 'bind' . $i;
            $$bind_name = $params[$i];
            $bind_names[] = &$$bind_name;
        }

        call_user_func_array([$stmt, 'bind_param'], $bind_names);

        $stmt->execute();


        if ($for == "JSON") {
            $this->JSONresponse(201, "Product has been created!");
        }

        return true;
    }

    public function JSONresponse($status, $message, $data = null)
    {
        $response = array();
        $response["status"] = $status;
        $response["message"] = $message;
        $response["data"] = $data;

        echo json_encode($response);
    }
}

$obj = new DbConfig();


# $conn->prepare("INSERT INTO users (email, age) VALUES (?, ?))
# $conn->bind_params("si", $email, $age)
# $conn->execute();

// $text = $age = 30;
// eval($text);

// $obj->update("user", array("email" => "serri@gmail.com"), "user_id = 3", "JSON");
