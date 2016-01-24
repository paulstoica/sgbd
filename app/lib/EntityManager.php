<?php

namespace App\Lib;

use App\Project;

class EntityManager
{
    public function get($entityClassName, $id) {

        if (!is_int($id)) {
            return null;
        }

        $db = Project::getDB();

        $sql = 'SELECT * FROM ' . $this->getTable($entityClassName) . ' WHERE id=:id';

        $statement = $db->prepare($sql);

        if ($statement->execute(array(':id' => $id))) {
            return $statement->fetchObject($entityClassName);
        }

        return array();

    }

    public function getOneBy($entityClassName, array $criteria = array()) {

        if (empty($criteria)) {
            return null;
        }

        $db = Project::getDB();

        $columns = $this->prepareCriteria(array_keys($criteria));
        $columnsValues = $this->prepareCriteriaValues($criteria);

        $sql = 'SELECT * FROM ' . $this->getTable($entityClassName) . ' WHERE ' . $columns . ' LIMIT 1';

        $statement = $db->prepare($sql);

        if ($statement->execute($columnsValues)) {
            return $statement->fetchObject($entityClassName);
        }

        return array();

    }

    public function getAll($entityClassName) {

        $db = Project::getDB();

        $sql = 'SELECT * FROM ' . $this->getTable($entityClassName);

        $statement = $db->prepare($sql);

        if ($statement->execute()) {
            return $statement->fetchAll(\PDO::FETCH_CLASS, $entityClassName);
        }

        return array();

    }

    public function getAllBy($entityClassName, array $criteria = array()) {

        if (empty($criteria)) {
            return $this->getAll();
        }

        $db = Project::getDB();

        $columns = $this->prepareCriteria(array_keys($criteria));
        $columnsValues = $this->prepareCriteriaValues($criteria);

        $sql = 'SELECT * FROM ' . $this->getTable($entityClassName) . ' WHERE ' . $columns;

        $statement = $db->prepare($sql);

        if ($statement->execute($columnsValues)) {
            return $statement->fetchAll(\PDO::FETCH_CLASS, $entityClassName);
        }

        return array();

    }

    public function insert($entityClassName, array $values = array()) {

        if (empty($values) || count($values) !== count($values, COUNT_RECURSIVE)) {
            return 0;
        }

        $valuesStm = $this->prepareInsertValuesStm($values);

        $columns = implode(", ", array_keys($values));

        $sql = 'INSERT INTO ' . $this->getTable($entityClassName) . '(' . $columns .') VALUES ' . $valuesStm;

        $db = Project::getDB();

        $stm = $db->prepare($sql);

        if ($stm->execute()) {
            $entity = new $entityClassName;

            $values['id'] = $db->lastInsertId();

            $this->updateObject($entity, $values);

            return $entity;
        }

        return false;
    }

    public function update(EntityInterface $entity, $values) {
        if (empty($values) || count($values) !== count($values, COUNT_RECURSIVE)) {
            return 0;
        }

        $columnsStm = $this->prepareCriteria(array_keys($values));

        $columnsValues = $this->prepareCriteriaValues($values);

        $sql = 'UPDATE ' . $this->getTable(get_class($entity)) . ' SET ' . $columnsStm . ' WHERE id=:id';

        $db = Project::getDB();

        $stm = $db->prepare($sql);

        if ($stm->execute(array_merge(array(':id' => $entity->getId()), $columnsValues))) {

            $this->updateObject($entity, $values);

            return $entity;
        }

        return false;
    }

    public function delete(EntityInterface $entity) {
        $sql = 'DELETE FROM ' . $this->getTable(get_class($entity)) . ' WHERE id=:id';
        pr($sql);
        $db = Project::getDB();

        $stm = $db->prepare($sql);

        if ($stm->execute(array(':id' => $entity->getId()))) {
            return true;
        }

        return false;
    }

    public function deleteMultipleById($entityClassName, array $ids) {

        $ids = implode(', ', $ids);

        $sql = 'DELETE FROM ' . $this->getTable($entityClassName) . ' WHERE id in (' . $ids . ')';

        $db = Project::getDB();

        $stm = $db->prepare($sql);

        if ($stm->execute()) {
            return true;
        }

        return false;
    }

    protected function prepareInsertValuesStm(array $values) {
        $stm = '(';

        $i = 0;
        foreach ($values as $column => $value) {
            $i++;

            if (is_string($value)) {
                $stm .= "'$value'";
            }else {
                $stm .= $value;
            }

            if (count($values) - 1 >= $i) {
                $stm .= ', ';
            }

        }
        $stm .= ')';

        return $stm;
    }

    protected function prepareCriteria($columns) {
        $stm = '';

        $i = 0;
        foreach ($columns as $column) {
            $i++;

            $stm .= $column . '=:' . $column;

            if (count($columns) - 1 > $i) {
                $stm .= ', ';
            }

        }

        return $stm;
    }

    protected function prepareCriteriaValues(array $criteria) {
        $preparedCriteria = array();

        foreach ($criteria as $column => $value) {

            $column = ':' . $column;

            $preparedCriteria[$column] = $value;
        }

        return $preparedCriteria;
    }

    protected function updateObject(EntityInterface &$entity, array $values) {

        if(empty($values)) {
            return;
        }

        foreach($values as $column => $value) {

            $method = 'set' . Project::camelize($column);

            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }

        }
    }

    protected function getTable($entityClassName) {
        if (class_exists($entityClassName) && method_exists($entityClassName, 'getTable')) {
            return $entityClassName::getTable();
        }

        return null;
    }
}