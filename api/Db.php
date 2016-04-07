<?php

class Db
{

    protected $pdo;

    protected $affectedRows = 0;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function execute($sql, array $params = array())
    {
        try {
            $stmt               = $this->pdo->prepare($sql);
            $return             = $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $return;
        } catch (PDOException $ex) {
            die("Database Error: " . $ex->getMessage());
        }
    }

    public function rows($sql, array $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            die("Database Error: " . $ex->getMessage());
        }
    }

    public function row($sql, array $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $ex) {
            die("Database Error: " . $ex->getMessage());
        }
    }

    public function numRows($sql, array $params = array())
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $this->affectedRows = $stmt->rowCount();
            return $this->affectedRows;
        } catch (PDOException $ex) {
            die("Database Error: " . $ex->getMessage());
        }
    }

    public function getAffectedRows()
    {
        return $this->affetedRows;
    }

    public function getInsertId()
    {
        return $this->pdo->lastInsertId;
    }
}
