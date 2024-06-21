<?php
class Database {

    private $conn;

    function __construct($db) {
        try {
            $conn = new PDO("sqlite:{$db}");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $conn;
        }
        catch (PDOException $error) {
            echo "Failed to connect to database: " . $error->getMessage();
        }
    }

    function queryAll($table) {
        $sql = "SELECT * FROM {$table}";
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch(PDOException $error) {
            echo "Query Failed: " . $error->getMessage();
            return [];
        }
    }

    function querySortedTable($table, $col, $param, $direction) {
        if ($param === 'name') {
            $sql = "SELECT * FROM $table ORDER BY $col $direction";
        }
        else if ($param === 'difficulty') {
            $sql = "SELECT * FROM $table ORDER BY $col $direction";
        }
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        catch (PDOException $e) {
            echo "Query Failed: " . $e->getMessage();
            return [];
        }
        
    }

    function querySpecificClass($courseNumber) {
        $sql = "SELECT * FROM class_list WHERE course_number = :courseNumber";
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':courseNumber', $courseNumber, PDO::PARAM_STR);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Query Failed: " . $e->getMessage();
            return [];
        }
    }

    function queryResources($courseNumber) {
        $sql = "SELECT resource_1, resource_2, resource_3, link_1, link_2, link_3, link_desc_1, link_desc_2, link_desc_3, resource_desc_1, resource_desc_2, resource_desc_3, language_used FROM class_list INNER JOIN class_resources ON class_list.course_number = class_resources.course_number WHERE class_resources.course_number = :courseNumber";
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':courseNumber', $courseNumber, PDO::PARAM_STR);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Query Failed: " . $e->getMessage();
            return [];
        }
    }

    function queryCourseDescription($courseNumber) {
        $sql = "SELECT course_description FROM class_description WHERE course_number = :courseNumber";
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':courseNumber', $courseNumber, PDO::PARAM_STR);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }

    function queryCommunities() {
        $sql = "SELECT * FROM communities";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            echo "Unable to complete query: " . $error->getMessage();
        }
    }

    function queryWGUResources() {
        $sql = "SELECT * FROM wgu_resources";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $error) {
            echo "Unable to complete query: " . $error->getMessage();
        }
    }
}

$conn = new Database("the-owl-roost.db");
?>
