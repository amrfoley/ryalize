<?php

namespace App\Repositories;

use App\Entities\Location;
use PDO;
use PDOException;

final class LocationRepository extends BaseRepository
{
    private array $sql;

    public function __construct()
    {
        parent::__construct();
        $this->sql = Location::sql();
    }

    public function all()
    {
        $sql = $this->sql['index'];
        try {
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->setStatus(200);
            return $result;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }
    
    public function random(int $limit)
    {
        $sql = $this->sql['index'] . ' ORDER BY rand() LIMIT ' . $limit;
        try {
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->setStatus(200);
            return $result;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }

    public function getById(int $id)
    {
        $sql = $this->sql['show'];

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $this->sanitizeInt($id), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            $this->setStatus(200);
            return $result;
        } catch (PDOException $e) {
            $error = array(
                'message' => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }

    public function store(array &$data)
    {
        $sql = $this->sql['store'];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':country', $this->sanitizeString($data['country']), PDO::PARAM_STR);
            $stmt->bindValue(':state', $this->sanitizeString($data['state']), PDO::PARAM_STR);
            $stmt->bindValue(':city', $this->sanitizeString($data['city']), PDO::PARAM_STR);
            $stmt->execute();
            $this->setStatus(200);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }

    public function update(int $id, array &$data)
    {
        $sql = $this->sql['update'];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $this->sanitizeInt($id), PDO::PARAM_INT);
            $stmt->bindValue(':country', $this->sanitizeString($data['country']), PDO::PARAM_STR);
            $stmt->bindValue(':state', $this->sanitizeString($data['state']), PDO::PARAM_STR);
            $stmt->bindValue(':city', $this->sanitizeString($data['city']), PDO::PARAM_STR);
            $result = $stmt->execute();
            $this->setStatus(200);
            return $result;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }

    public function destroy(int $id)
    {
        $sql = $this->sql['destroy'];
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $this->sanitizeInt($id), PDO::PARAM_INT);
            $result = $stmt->execute();
            $this->setStatus(200);
            return $result;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        } finally {
            unset($this->conn);
        }
    }
}
