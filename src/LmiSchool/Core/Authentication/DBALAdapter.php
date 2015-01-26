<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core\Authentication;
use Aura\Auth\Adapter\PdoAdapter;
use Aura\Auth\Verifier\VerifierInterface;
use Doctrine\DBAL\Connection;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class DBALAdapter extends PdoAdapter
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $cols = array();

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string|null
     */
    protected $where;

    /**
     * @var VerifierInterface
     */
    protected $verifier;

    /**
     * @param Connection $connection
     * @param VerifierInterface $verifier
     * @param array $cols
     * @param string $from
     * @param string|null $where
     */
    public function __construct(Connection $connection,
                                VerifierInterface $verifier,
                                array $cols,
                                $from,
                                $where = null)
    {
        $this->connection = $connection;
        $this->verifier = $verifier;
        $this->setCols($cols);
        $this->from = $from;
        $this->where = $where;
    }

    /**
     * @param string $query
     * @param array $bindings
     * @return array
     */
    protected function fetchRows($query, array $bindings)
    {
        unset($bindings['password']);

        return $this->connection->fetchAll($query, $bindings);
    }
}
