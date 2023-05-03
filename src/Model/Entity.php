<?php

namespace App\Model;

use App\Config\Database;

class Entity
{
    private $conn;
    private $table_name = "entities";

    public $id;
    public $title;
    public $content;
    public $author_id;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . "
            SET
                title = :title,
                content = :content,
                author_id = :author_id,
                created_at = :created_at,
                updated_at = :updated_at";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at = htmlspecialchars(strip_tags($this->updated_at));

        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readAll()
    {
        $query = "SELECT e.id, e.title, e.content, e.author_id, e.created_at, e.updated_at, u.name as author_name
                FROM " . $this->table_name . " e
                LEFT JOIN users u ON e.author_id = u.id
                ORDER BY e.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne()
    {
        $query = "SELECT e.id, e.title, e.content, e.author_id, e.created_at, e.updated_at, u.name as author_name
                FROM " . $this->table_name . " e
                LEFT JOIN users u ON e.author_id = u.id
                WHERE e.id = ?
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->author_id = $row['author_id'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
        $this->author_name = $row['author_name'];
    }

    public function update()
    {
        $query = "UPDATE " . $this->table_name . "
                SET
                    title = :title,
                    content = :content,
                    author_id = :author_id,
                    updated_at = :updated_at
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":author_id", $this->author_id);
        $stmt->bindParam(":updated_at", $this->updated_at);
        $stmt->bindParam(":id", $this->id);
    
        // execute the query
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        $stmt = $this->conn->prepare($query);
    
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(1, $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
    
    public function search($keywords)
    {
        $query = "SELECT e.id, e.title, e.content, e.author_id, e.created_at, e.updated_at, u.name as author_name
                FROM " . $this->table_name . " e
                LEFT JOIN users u ON e.author_id = u.id
                WHERE e.title LIKE ? OR e.content LIKE ?
                ORDER BY e.created_at DESC";
    
        $stmt = $this->conn->prepare($query);
    
        $keywords = htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
    
        $stmt->execute();
    
        return $stmt;
    }
}

?>