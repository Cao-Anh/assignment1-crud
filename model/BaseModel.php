<?php
declare(strict_types=1);


class BaseModel
{

    protected $pdo;
    public function select(array $params):array
    {
        $result = [];
        $sql = $params['sql'];
        $limit = $params['limit'];
        $offset = $params['offset'];

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }

    
    public function insert(array $params):array
    {
        $result = [];

        return $result;


        
    }

    public function update(array $params):array
    {
        $result = [];

        return $result;

    }

    public function delete(array $params):array
    {
        $result = [];

        return $result;

    }


}