<?php

/**
 * Project: simple-feedback-form
 * Date: 06.05.16
 * Time: 21:05
 * @author  Dmitriy Zhavoronkov <dimaz.lark@gmail.com>
 * @license GPL-3.0
 * @link    http://artlark.ru/
 */

namespace Models;

class Comment extends Generic
{
    protected $tableColumns = [
        'id',
        'name',
        'email',
        'text',
        'show',
        'edited',
        'image',
        'date',
    ];

    /**
     * Accept comment
     * @param int $id id
     * @return bool
     */
    public function accept($id)
    {
        $stmt = $this->db->prepare('UPDATE `comments` SET `show` = 1 WHERE `id` = :id');

        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    /**
     * Reject comment
     * @param int $id id
     * @return bool
     */
    public function reject($id)
    {
        $stmt = $this->db->prepare('UPDATE `comments` SET `show` = 0 WHERE `id` = :id');

        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    /**
     * Create new comment
     * @param array $data
     * @return bool
     */
    public function create(array $data)
    {
        $data = $this->prepareValues($data);

        // Validate values
        $this->validate($data);

        // Remove pk key
        if (array_key_exists('id', $data)) {
            unset($data['id']);
        }

        $columns = array_map(
            function ($value) {
                return '`' . $value . '`';
            },
            array_keys($data)
        );

        $placeholders = array_map(
            function ($value) {
                return ':' . $value;
            },
            array_keys($data)
        );

        $query = 'INSERT INTO `comments` (' . implode(', ', $columns) . ') 
        VALUES (' . implode(', ', $placeholders) . ')';

        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        return $stmt->execute();
    }

    /**
     * Simple fields validation
     * @param $data
     * @throws \Exception
     */
    protected function validate($data)
    {
        $requiredFields = [
            'name',
            'email',
            'text',
        ];

        foreach ($requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $data)) {
                throw new \Exception('Field ' . $requiredField . ' is required');
            }
        }
    }

    /**
     * Update existent comment
     * @param array $data
     * @return bool
     */
    public function update(array $data)
    {
        $data = $this->prepareValues($data);

        $sets = [];

        foreach ($data as $key => $value) {
            $sets[] = '`' . $key . '` = :' . $key;
        }

        $query = 'UPDATE `comments` SET `edited` = 1, ' . implode(', ', $sets) . ' WHERE `id` = :id';

        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->bindValue(':id', $data['id']);

        return $stmt->execute();
    }

    /**
     * Return all comments
     * @param bool $isAdmin
     * @return array
     */
    public function findAll($isAdmin = false)
    {
        $query = 'SELECT * FROM `comments`';

        if (!$isAdmin) {
            $query .= ' WHERE `show` = 1';
        }

        $query .= $this->getOrder();

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
