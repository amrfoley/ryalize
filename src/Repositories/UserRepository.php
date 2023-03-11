<?php

namespace App\Repositories;

use App\Entities\User;
use PDO;
use PDOException;

final class UserRepository extends BaseRepository
{
    private array $sql;

    public function __construct()
    {
        parent::__construct();
        $this->sql = User::sql();
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
            $stmt->bindValue(':name', $this->sanitizeString($data['name']), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->sanitizeEmail($data['email']), PDO::PARAM_STR);
            $stmt->bindValue(':phone', $this->sanitizeString($data['phone']), PDO::PARAM_STR);
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
            $stmt->bindValue(':name', $this->sanitizeString($data['name']), PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->sanitizeEmail($data['email']), PDO::PARAM_STR);
            $stmt->bindValue(':phone', $this->sanitizeString($data['phone']), PDO::PARAM_STR);
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
