<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Model;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Query\QueryBuilder;
use LmiSchool\Core\DatabaseConnection;
use LmiSchool\Model\Exception\ModelException;

/**
 * Class BaseModel
 *
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
abstract class BaseModel
{
    public static function count()
    {
        $model = new static();
        $queryBuilder = new QueryBuilder(DatabaseConnection::getConnection());
        $queryBuilder->select('COUNT(1)')
            ->from($model->getTableName(), substr($model->getTableName(), 0, 1));
        $count = DatabaseConnection::getConnection()->fetchColumn(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );
        unset($queryBuilder);

        return $count;
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param integer|null $limit
     * @param integer|null $offset
     * @return static[]
     */
    public static function findBy(array $criteria = [], array $orderBy = [], $limit = null, $offset = null)
    {
        $model = new static();
        $fieldNames = array_keys($model->dump());
        $queryBuilder = new QueryBuilder(DatabaseConnection::getConnection());
        $queryBuilder->select(implode(',', $fieldNames))
            ->from($model->getTableName(), substr($model->getTableName(), 0, 1));
        foreach ($criteria as $key => $value) {
            if (is_array($value)) {
                $queryBuilder->andWhere(sprintf(
                    '%s IN (%s)',
                    $key,
                    implode(',', $value)
                ));
            } else {
                $parameter = ':' . str_replace(['.', ' '], '_', $key);
                $queryBuilder->andWhere(sprintf('LOWER(%s) LIKE %s', $key, $parameter));
                $queryBuilder->setParameter($parameter, strtolower('%' . $value . '%'));
            }
        }
        foreach ($orderBy as $key => $value) {
            $queryBuilder->addOrderBy($key, $value);
        }
        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }
        if ($limit) {
            $queryBuilder->setMaxResults($limit);
        }

        unset($model);
        $rows = DatabaseConnection::getConnection()->fetchAll(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );
        unset($queryBuilder);

        $result = [];

        foreach ($rows as $row) {
            $model = new static();
            $result[] = $model->init($row);
        }

        return $result;
    }

    /**
     * @param array $criteria
     * @return static
     */
    public static function findOneBy(array $criteria)
    {
        $model = new static();
        $fieldNames = array_keys($model->dump());
        $queryBuilder = new QueryBuilder(DatabaseConnection::getConnection());
        $queryBuilder->select(implode(',', $fieldNames))
            ->from($model->getTableName(), substr($model->getTableName(), 0, 1));
        foreach ($criteria as $key => $value) {
            $queryBuilder->andWhere(sprintf('%s = %s', $key, $queryBuilder->createNamedParameter($value)));
        }

        $queryBuilder->setMaxResults(1);

        unset($model);
        $row = DatabaseConnection::getConnection()->fetchAssoc(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );
        unset($queryBuilder);

        $model = new static();
        $model->init($row ?: null);

        return $model;

    }

    /**
     * @param integer $id
     * @return null|static
     */
    public static function find($id)
    {
        $model = new static();
        $fieldNames = array_keys($model->dump());
        $queryBuilder = new QueryBuilder(DatabaseConnection::getConnection());
        $queryBuilder->select(implode(',', $fieldNames))
            ->from($model->getTableName(), substr($model->getTableName(), 0, 1))
            ->where('id = :id')
            ->setParameter('id', $id);

        unset($model);
        $row = DatabaseConnection::getConnection()->fetchAssoc(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters()
        );
        unset($queryBuilder);

        if (!$row) {
            return null;
        }

        $model = new static();
        $model->init($row);

        return $model;
    }

    public function save()
    {
        if (!$this->getId()) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * @return integer|string
     */
    public abstract function getId();

    /**
     * @return array
     */
    protected abstract function dump();

    /**
     * @param array|null $data
     * @return static
     */
    protected abstract function init($data);

    /**
     * @return string
     */
    protected abstract function getTableName();

    private function insert()
    {
        try {
            DatabaseConnection::getConnection()->insert($this->getTableName(), $this->dump());
        } catch (DBALException $e) {
            throw ModelException::failedToInsert($e);
        }
    }

    private function update()
    {
        try {
            DatabaseConnection::getConnection()
                ->update($this->getTableName(), $this->dump(), ['id' => $this->getId()]);
        } catch (DBALException $e) {
            throw ModelException::failedToUpdate($e);
        }
    }
}
