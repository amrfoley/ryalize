<?php

namespace App\Repositories;

use PDO;
use PDOException;

final class TransactionRepository extends BaseRepository
{
    public function searchByLocationIdAndDate(array &$data)
    {
        $hasYear = $hasMonth = $hasDay = false;

        $sql = "SELECT users.name, users.email, transactions.date, transactions.amount, locations.country, locations.state, locations.city
        FROM transactions 
        INNER JOIN users 
        ON transactions.user_id=users.id
        INNER JOIN locations 
        ON transactions.location_id=locations.id
        WHERE transactions.location_id=:location_id";

        if (isset($data['year'])) {
            $hasYear = true;
            $sql .= ' AND YEAR(transactions.date)=:date_year';
        }
        if (isset($data['month'])) {
            $hasMonth = true;
            $sql .= ' AND MONTH(transactions.date)=:date_month';
        }
        if (isset($data['day'])) {
            $hasDay = true;
            $sql .= ' AND DAY(transactions.date)=:date_day';
        }
        if (isset($data['page'])) {
            $page = (int) $this->sanitizeInt($data['page']);
            $offset = (int) $this->sanitizeInt($data['offset']);
            $from = $page * $offset - $offset + 1;
            $sql .= " ORDER BY transactions.date DESC
                LIMIT $from,$offset";
        }
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':location_id', $this->sanitizeInt(intval($data['location_id'])), PDO::PARAM_INT);
            if ($hasYear) {
                $stmt->bindValue(':date_year', $this->sanitizeInt(intval($data['year'])), PDO::PARAM_INT);
            }
            if ($hasMonth) {
                $stmt->bindValue(':date_month', $this->sanitizeInt(intval($data['month'])), PDO::PARAM_INT);
            }
            if ($hasDay) {
                $stmt->bindValue(':date_day', $this->sanitizeInt(intval($data['day'])), PDO::PARAM_INT);
            }
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->setStatus(200);
            return $transactions;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        }
    }

    public function storeMany(array &$data)
    {
        $sql = "INSERT INTO transactions (user_id, location_id, amount, date) VALUES ";
        $values = " ('%u', '%u', '%f', '%s')";
        $loop = 0;
        $length = count($data);
        foreach ($data as $val) {
            if (
                isset($val['user_id'], $val['location_id'], $val['amount'], $val['date']) &&
                !empty($val['location_id']) &&
                !empty($val['amount']) &&
                !empty($val['date'])
            ) {
                $sql .= sprintf(
                    $values,
                    $this->sanitizeInt(intval($val['user_id'])),
                    $this->sanitizeInt(intval($val['location_id'])),
                    $this->sanitizeFloat($val['amount']),
                    $this->sanitizeString($val['date']),
                );
                if ($loop < ($length - 1)) {
                    $sql .= ',';
                }
            }
            $loop++;
        }

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $this->setStatus(200);
            return true;
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

    public function paginate(int $page, int $offset)
    {
        $from = $page * $offset - $offset + 1;
        $sql = "SELECT users.name, users.email, transactions.date, transactions.amount, locations.country, locations.state, locations.city
        FROM transactions 
        INNER JOIN users 
        ON transactions.user_id=users.id
        INNER JOIN locations 
        ON transactions.location_id=locations.id
        ORDER BY transactions.date DESC
        LIMIT $from,$offset";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->setStatus(200);
            return $transactions;
        } catch (PDOException $e) {
            $error = array(
                "message" => $e->getMessage()
            );
            $this->setStatus(500);
            return $error;
        }
    }

    public function count()
    {
        $sql = "SELECT COUNT(id) AS count FROM transactions";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->setStatus(200);
            return $transactions[0]['count'] ?? $transactions;
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
