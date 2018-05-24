<?php

class Attendance
{
    //database connection and table name
    private $conn;
    private $table_name = "attandance";

    //object properties
    public $email;
    public $meet;
    public $location;
    public $time;

    //constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function readAll()
    {
        $query = "SELECT *
	    FROM " . $this->table_name . " ";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();
        return $stmt;
    }

    function readOne()
    {
        $query = "SELECT email, meet, location, time
                  FROM " . $this->table_name . "
		          WHERE email = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        //bind email of data attandance
        $stmt->bindParam(1, $this->email);

        // execute query
        $stmt->execute();

        /*// get retrive row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->email = $row['email'];
        $this->meet = $row['meet'];
        $this->location = $row['location'];
        $this->time = $row['time'];*/

        return $stmt;
    }

    function create()
    {
        // query to insert record
        $query = "INSERT INTO
		 " . $this->table_name . "
		 SET email=:email, meet=:meet, location=:location, time=:time";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->meet = htmlspecialchars(strip_tags($this->meet));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->time = htmlspecialchars(strip_tags($this->time));

        // bind values
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":meet", $this->meet);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":time", $this->time);

        // execute values
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}


