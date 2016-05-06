<?php
/**
 * Created by PhpStorm.
 * User: dim
 * Date: 07.05.16
 * Time: 0:14
 */

namespace Models;

use App;

abstract class Generic
{
    /**
     * ORDER BY query
     * @var string
     */
    protected $order;

    public function __construct()
    {
        $config = App::config();

        try {
            $this->db = new \PDO($config['db']['dsn'], $config['db']['user'], $config['db']['password']);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * Unset wrong columns
     * @param array $data
     * @return array
     */
    public function prepareValues($data)
    {
        foreach ($data as $key => $value) {
            if (!in_array($key, $this->tableColumns)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * Set order column
     * @param string $column
     * @return string
     */
    public function setOrder($column)
    {
        if (!in_array($column, $this->tableColumns)) {
            $column = 'id';
        }

        $this->order = ' ORDER BY `' . $column . '` DESC';
    }

    /**
     * Get order sub command
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }
}
