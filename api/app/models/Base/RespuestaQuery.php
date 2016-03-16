<?php

namespace Base;

use \Respuesta as ChildRespuesta;
use \RespuestaQuery as ChildRespuestaQuery;
use \Exception;
use \PDO;
use Map\RespuestaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'respuesta' table.
 *
 * 
 *
 * @method     ChildRespuestaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRespuestaQuery orderByPreId($order = Criteria::ASC) Order by the pre_id column
 * @method     ChildRespuestaQuery orderByExaId($order = Criteria::ASC) Order by the exa_id column
 * @method     ChildRespuestaQuery orderByTexto($order = Criteria::ASC) Order by the texto column
 * @method     ChildRespuestaQuery orderByCorrecto($order = Criteria::ASC) Order by the correcto column
 *
 * @method     ChildRespuestaQuery groupById() Group by the id column
 * @method     ChildRespuestaQuery groupByPreId() Group by the pre_id column
 * @method     ChildRespuestaQuery groupByExaId() Group by the exa_id column
 * @method     ChildRespuestaQuery groupByTexto() Group by the texto column
 * @method     ChildRespuestaQuery groupByCorrecto() Group by the correcto column
 *
 * @method     ChildRespuestaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRespuestaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRespuestaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRespuestaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRespuestaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRespuestaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRespuestaQuery leftJoinPregunta($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pregunta relation
 * @method     ChildRespuestaQuery rightJoinPregunta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pregunta relation
 * @method     ChildRespuestaQuery innerJoinPregunta($relationAlias = null) Adds a INNER JOIN clause to the query using the Pregunta relation
 *
 * @method     ChildRespuestaQuery joinWithPregunta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pregunta relation
 *
 * @method     ChildRespuestaQuery leftJoinWithPregunta() Adds a LEFT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildRespuestaQuery rightJoinWithPregunta() Adds a RIGHT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildRespuestaQuery innerJoinWithPregunta() Adds a INNER JOIN clause and with to the query using the Pregunta relation
 *
 * @method     \PreguntaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRespuesta findOne(ConnectionInterface $con = null) Return the first ChildRespuesta matching the query
 * @method     ChildRespuesta findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRespuesta matching the query, or a new ChildRespuesta object populated from the query conditions when no match is found
 *
 * @method     ChildRespuesta findOneById(int $id) Return the first ChildRespuesta filtered by the id column
 * @method     ChildRespuesta findOneByPreId(int $pre_id) Return the first ChildRespuesta filtered by the pre_id column
 * @method     ChildRespuesta findOneByExaId(int $exa_id) Return the first ChildRespuesta filtered by the exa_id column
 * @method     ChildRespuesta findOneByTexto(string $texto) Return the first ChildRespuesta filtered by the texto column
 * @method     ChildRespuesta findOneByCorrecto(boolean $correcto) Return the first ChildRespuesta filtered by the correcto column *

 * @method     ChildRespuesta requirePk($key, ConnectionInterface $con = null) Return the ChildRespuesta by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRespuesta requireOne(ConnectionInterface $con = null) Return the first ChildRespuesta matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRespuesta requireOneById(int $id) Return the first ChildRespuesta filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRespuesta requireOneByPreId(int $pre_id) Return the first ChildRespuesta filtered by the pre_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRespuesta requireOneByExaId(int $exa_id) Return the first ChildRespuesta filtered by the exa_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRespuesta requireOneByTexto(string $texto) Return the first ChildRespuesta filtered by the texto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRespuesta requireOneByCorrecto(boolean $correcto) Return the first ChildRespuesta filtered by the correcto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRespuesta[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRespuesta objects based on current ModelCriteria
 * @method     ChildRespuesta[]|ObjectCollection findById(int $id) Return ChildRespuesta objects filtered by the id column
 * @method     ChildRespuesta[]|ObjectCollection findByPreId(int $pre_id) Return ChildRespuesta objects filtered by the pre_id column
 * @method     ChildRespuesta[]|ObjectCollection findByExaId(int $exa_id) Return ChildRespuesta objects filtered by the exa_id column
 * @method     ChildRespuesta[]|ObjectCollection findByTexto(string $texto) Return ChildRespuesta objects filtered by the texto column
 * @method     ChildRespuesta[]|ObjectCollection findByCorrecto(boolean $correcto) Return ChildRespuesta objects filtered by the correcto column
 * @method     ChildRespuesta[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RespuestaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\RespuestaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Respuesta', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRespuestaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRespuestaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRespuestaQuery) {
            return $criteria;
        }
        $query = new ChildRespuestaQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id, $pre_id, $exa_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildRespuesta|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RespuestaTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RespuestaTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRespuesta A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, pre_id, exa_id, texto, correcto FROM respuesta WHERE id = :p0 AND pre_id = :p1 AND exa_id = :p2';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);            
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildRespuesta $obj */
            $obj = new ChildRespuesta();
            $obj->hydrate($row);
            RespuestaTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildRespuesta|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(RespuestaTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(RespuestaTableMap::COL_PRE_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(RespuestaTableMap::COL_EXA_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(RespuestaTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(RespuestaTableMap::COL_PRE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(RespuestaTableMap::COL_EXA_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RespuestaTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the pre_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPreId(1234); // WHERE pre_id = 1234
     * $query->filterByPreId(array(12, 34)); // WHERE pre_id IN (12, 34)
     * $query->filterByPreId(array('min' => 12)); // WHERE pre_id > 12
     * </code>
     *
     * @see       filterByPregunta()
     *
     * @param     mixed $preId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByPreId($preId = null, $comparison = null)
    {
        if (is_array($preId)) {
            $useMinMax = false;
            if (isset($preId['min'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_PRE_ID, $preId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($preId['max'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_PRE_ID, $preId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RespuestaTableMap::COL_PRE_ID, $preId, $comparison);
    }

    /**
     * Filter the query on the exa_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExaId(1234); // WHERE exa_id = 1234
     * $query->filterByExaId(array(12, 34)); // WHERE exa_id IN (12, 34)
     * $query->filterByExaId(array('min' => 12)); // WHERE exa_id > 12
     * </code>
     *
     * @see       filterByPregunta()
     *
     * @param     mixed $exaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByExaId($exaId = null, $comparison = null)
    {
        if (is_array($exaId)) {
            $useMinMax = false;
            if (isset($exaId['min'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_EXA_ID, $exaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exaId['max'])) {
                $this->addUsingAlias(RespuestaTableMap::COL_EXA_ID, $exaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RespuestaTableMap::COL_EXA_ID, $exaId, $comparison);
    }

    /**
     * Filter the query on the texto column
     *
     * Example usage:
     * <code>
     * $query->filterByTexto('fooValue');   // WHERE texto = 'fooValue'
     * $query->filterByTexto('%fooValue%'); // WHERE texto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $texto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByTexto($texto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($texto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $texto)) {
                $texto = str_replace('*', '%', $texto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(RespuestaTableMap::COL_TEXTO, $texto, $comparison);
    }

    /**
     * Filter the query on the correcto column
     *
     * Example usage:
     * <code>
     * $query->filterByCorrecto(true); // WHERE correcto = true
     * $query->filterByCorrecto('yes'); // WHERE correcto = true
     * </code>
     *
     * @param     boolean|string $correcto The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByCorrecto($correcto = null, $comparison = null)
    {
        if (is_string($correcto)) {
            $correcto = in_array(strtolower($correcto), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RespuestaTableMap::COL_CORRECTO, $correcto, $comparison);
    }

    /**
     * Filter the query by a related \Pregunta object
     *
     * @param \Pregunta $pregunta The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRespuestaQuery The current query, for fluid interface
     */
    public function filterByPregunta($pregunta, $comparison = null)
    {
        if ($pregunta instanceof \Pregunta) {
            return $this
                ->addUsingAlias(RespuestaTableMap::COL_EXA_ID, $pregunta->getExaId(), $comparison)
                ->addUsingAlias(RespuestaTableMap::COL_PRE_ID, $pregunta->getId(), $comparison);
        } else {
            throw new PropelException('filterByPregunta() only accepts arguments of type \Pregunta');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pregunta relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function joinPregunta($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pregunta');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pregunta');
        }

        return $this;
    }

    /**
     * Use the Pregunta relation Pregunta object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PreguntaQuery A secondary query class using the current class as primary query
     */
    public function usePreguntaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPregunta($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pregunta', '\PreguntaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRespuesta $respuesta Object to remove from the list of results
     *
     * @return $this|ChildRespuestaQuery The current query, for fluid interface
     */
    public function prune($respuesta = null)
    {
        if ($respuesta) {
            $this->addCond('pruneCond0', $this->getAliasedColName(RespuestaTableMap::COL_ID), $respuesta->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(RespuestaTableMap::COL_PRE_ID), $respuesta->getPreId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(RespuestaTableMap::COL_EXA_ID), $respuesta->getExaId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the respuesta table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RespuestaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RespuestaTableMap::clearInstancePool();
            RespuestaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RespuestaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RespuestaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            RespuestaTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            RespuestaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // RespuestaQuery
