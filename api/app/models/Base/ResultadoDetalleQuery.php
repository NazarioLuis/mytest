<?php

namespace Base;

use \ResultadoDetalle as ChildResultadoDetalle;
use \ResultadoDetalleQuery as ChildResultadoDetalleQuery;
use \Exception;
use \PDO;
use Map\ResultadoDetalleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'resultado_detalle' table.
 *
 * 
 *
 * @method     ChildResultadoDetalleQuery orderByAluId($order = Criteria::ASC) Order by the alu_id column
 * @method     ChildResultadoDetalleQuery orderByPreId($order = Criteria::ASC) Order by the pre_id column
 * @method     ChildResultadoDetalleQuery orderByExaId($order = Criteria::ASC) Order by the exa_id column
 * @method     ChildResultadoDetalleQuery orderBySeleccion($order = Criteria::ASC) Order by the seleccion column
 * @method     ChildResultadoDetalleQuery orderByCorrecto($order = Criteria::ASC) Order by the correcto column
 *
 * @method     ChildResultadoDetalleQuery groupByAluId() Group by the alu_id column
 * @method     ChildResultadoDetalleQuery groupByPreId() Group by the pre_id column
 * @method     ChildResultadoDetalleQuery groupByExaId() Group by the exa_id column
 * @method     ChildResultadoDetalleQuery groupBySeleccion() Group by the seleccion column
 * @method     ChildResultadoDetalleQuery groupByCorrecto() Group by the correcto column
 *
 * @method     ChildResultadoDetalleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildResultadoDetalleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildResultadoDetalleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildResultadoDetalleQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildResultadoDetalleQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildResultadoDetalleQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildResultadoDetalleQuery leftJoinPregunta($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pregunta relation
 * @method     ChildResultadoDetalleQuery rightJoinPregunta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pregunta relation
 * @method     ChildResultadoDetalleQuery innerJoinPregunta($relationAlias = null) Adds a INNER JOIN clause to the query using the Pregunta relation
 *
 * @method     ChildResultadoDetalleQuery joinWithPregunta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pregunta relation
 *
 * @method     ChildResultadoDetalleQuery leftJoinWithPregunta() Adds a LEFT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildResultadoDetalleQuery rightJoinWithPregunta() Adds a RIGHT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildResultadoDetalleQuery innerJoinWithPregunta() Adds a INNER JOIN clause and with to the query using the Pregunta relation
 *
 * @method     ChildResultadoDetalleQuery leftJoinResultado($relationAlias = null) Adds a LEFT JOIN clause to the query using the Resultado relation
 * @method     ChildResultadoDetalleQuery rightJoinResultado($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Resultado relation
 * @method     ChildResultadoDetalleQuery innerJoinResultado($relationAlias = null) Adds a INNER JOIN clause to the query using the Resultado relation
 *
 * @method     ChildResultadoDetalleQuery joinWithResultado($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Resultado relation
 *
 * @method     ChildResultadoDetalleQuery leftJoinWithResultado() Adds a LEFT JOIN clause and with to the query using the Resultado relation
 * @method     ChildResultadoDetalleQuery rightJoinWithResultado() Adds a RIGHT JOIN clause and with to the query using the Resultado relation
 * @method     ChildResultadoDetalleQuery innerJoinWithResultado() Adds a INNER JOIN clause and with to the query using the Resultado relation
 *
 * @method     \PreguntaQuery|\ResultadoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildResultadoDetalle findOne(ConnectionInterface $con = null) Return the first ChildResultadoDetalle matching the query
 * @method     ChildResultadoDetalle findOneOrCreate(ConnectionInterface $con = null) Return the first ChildResultadoDetalle matching the query, or a new ChildResultadoDetalle object populated from the query conditions when no match is found
 *
 * @method     ChildResultadoDetalle findOneByAluId(int $alu_id) Return the first ChildResultadoDetalle filtered by the alu_id column
 * @method     ChildResultadoDetalle findOneByPreId(int $pre_id) Return the first ChildResultadoDetalle filtered by the pre_id column
 * @method     ChildResultadoDetalle findOneByExaId(int $exa_id) Return the first ChildResultadoDetalle filtered by the exa_id column
 * @method     ChildResultadoDetalle findOneBySeleccion(int $seleccion) Return the first ChildResultadoDetalle filtered by the seleccion column
 * @method     ChildResultadoDetalle findOneByCorrecto(boolean $correcto) Return the first ChildResultadoDetalle filtered by the correcto column *

 * @method     ChildResultadoDetalle requirePk($key, ConnectionInterface $con = null) Return the ChildResultadoDetalle by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultadoDetalle requireOne(ConnectionInterface $con = null) Return the first ChildResultadoDetalle matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResultadoDetalle requireOneByAluId(int $alu_id) Return the first ChildResultadoDetalle filtered by the alu_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultadoDetalle requireOneByPreId(int $pre_id) Return the first ChildResultadoDetalle filtered by the pre_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultadoDetalle requireOneByExaId(int $exa_id) Return the first ChildResultadoDetalle filtered by the exa_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultadoDetalle requireOneBySeleccion(int $seleccion) Return the first ChildResultadoDetalle filtered by the seleccion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultadoDetalle requireOneByCorrecto(boolean $correcto) Return the first ChildResultadoDetalle filtered by the correcto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResultadoDetalle[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildResultadoDetalle objects based on current ModelCriteria
 * @method     ChildResultadoDetalle[]|ObjectCollection findByAluId(int $alu_id) Return ChildResultadoDetalle objects filtered by the alu_id column
 * @method     ChildResultadoDetalle[]|ObjectCollection findByPreId(int $pre_id) Return ChildResultadoDetalle objects filtered by the pre_id column
 * @method     ChildResultadoDetalle[]|ObjectCollection findByExaId(int $exa_id) Return ChildResultadoDetalle objects filtered by the exa_id column
 * @method     ChildResultadoDetalle[]|ObjectCollection findBySeleccion(int $seleccion) Return ChildResultadoDetalle objects filtered by the seleccion column
 * @method     ChildResultadoDetalle[]|ObjectCollection findByCorrecto(boolean $correcto) Return ChildResultadoDetalle objects filtered by the correcto column
 * @method     ChildResultadoDetalle[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ResultadoDetalleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ResultadoDetalleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\ResultadoDetalle', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildResultadoDetalleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildResultadoDetalleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildResultadoDetalleQuery) {
            return $criteria;
        }
        $query = new ChildResultadoDetalleQuery();
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
     * @param array[$alu_id, $pre_id, $exa_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildResultadoDetalle|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ResultadoDetalleTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ResultadoDetalleTableMap::DATABASE_NAME);
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
     * @return ChildResultadoDetalle A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT alu_id, pre_id, exa_id, seleccion, correcto FROM resultado_detalle WHERE alu_id = :p0 AND pre_id = :p1 AND exa_id = :p2';
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
            /** @var ChildResultadoDetalle $obj */
            $obj = new ChildResultadoDetalle();
            $obj->hydrate($row);
            ResultadoDetalleTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1]), (null === $key[2] || is_scalar($key[2]) || is_callable([$key[2], '__toString']) ? (string) $key[2] : $key[2])]));
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
     * @return ChildResultadoDetalle|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ResultadoDetalleTableMap::COL_ALU_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ResultadoDetalleTableMap::COL_PRE_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ResultadoDetalleTableMap::COL_ALU_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ResultadoDetalleTableMap::COL_PRE_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(ResultadoDetalleTableMap::COL_EXA_ID, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the alu_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAluId(1234); // WHERE alu_id = 1234
     * $query->filterByAluId(array(12, 34)); // WHERE alu_id IN (12, 34)
     * $query->filterByAluId(array('min' => 12)); // WHERE alu_id > 12
     * </code>
     *
     * @see       filterByResultado()
     *
     * @param     mixed $aluId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByAluId($aluId = null, $comparison = null)
    {
        if (is_array($aluId)) {
            $useMinMax = false;
            if (isset($aluId['min'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_ALU_ID, $aluId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aluId['max'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_ALU_ID, $aluId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoDetalleTableMap::COL_ALU_ID, $aluId, $comparison);
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
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByPreId($preId = null, $comparison = null)
    {
        if (is_array($preId)) {
            $useMinMax = false;
            if (isset($preId['min'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_PRE_ID, $preId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($preId['max'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_PRE_ID, $preId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoDetalleTableMap::COL_PRE_ID, $preId, $comparison);
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
     * @see       filterByResultado()
     *
     * @param     mixed $exaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByExaId($exaId = null, $comparison = null)
    {
        if (is_array($exaId)) {
            $useMinMax = false;
            if (isset($exaId['min'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $exaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exaId['max'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $exaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $exaId, $comparison);
    }

    /**
     * Filter the query on the seleccion column
     *
     * Example usage:
     * <code>
     * $query->filterBySeleccion(1234); // WHERE seleccion = 1234
     * $query->filterBySeleccion(array(12, 34)); // WHERE seleccion IN (12, 34)
     * $query->filterBySeleccion(array('min' => 12)); // WHERE seleccion > 12
     * </code>
     *
     * @param     mixed $seleccion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterBySeleccion($seleccion = null, $comparison = null)
    {
        if (is_array($seleccion)) {
            $useMinMax = false;
            if (isset($seleccion['min'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_SELECCION, $seleccion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($seleccion['max'])) {
                $this->addUsingAlias(ResultadoDetalleTableMap::COL_SELECCION, $seleccion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoDetalleTableMap::COL_SELECCION, $seleccion, $comparison);
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
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByCorrecto($correcto = null, $comparison = null)
    {
        if (is_string($correcto)) {
            $correcto = in_array(strtolower($correcto), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ResultadoDetalleTableMap::COL_CORRECTO, $correcto, $comparison);
    }

    /**
     * Filter the query by a related \Pregunta object
     *
     * @param \Pregunta $pregunta The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByPregunta($pregunta, $comparison = null)
    {
        if ($pregunta instanceof \Pregunta) {
            return $this
                ->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $pregunta->getExaId(), $comparison)
                ->addUsingAlias(ResultadoDetalleTableMap::COL_PRE_ID, $pregunta->getId(), $comparison);
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
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
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
     * Filter the query by a related \Resultado object
     *
     * @param \Resultado $resultado The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function filterByResultado($resultado, $comparison = null)
    {
        if ($resultado instanceof \Resultado) {
            return $this
                ->addUsingAlias(ResultadoDetalleTableMap::COL_EXA_ID, $resultado->getExaId(), $comparison)
                ->addUsingAlias(ResultadoDetalleTableMap::COL_ALU_ID, $resultado->getAluId(), $comparison);
        } else {
            throw new PropelException('filterByResultado() only accepts arguments of type \Resultado');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Resultado relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function joinResultado($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Resultado');

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
            $this->addJoinObject($join, 'Resultado');
        }

        return $this;
    }

    /**
     * Use the Resultado relation Resultado object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResultadoQuery A secondary query class using the current class as primary query
     */
    public function useResultadoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResultado($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Resultado', '\ResultadoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildResultadoDetalle $resultadoDetalle Object to remove from the list of results
     *
     * @return $this|ChildResultadoDetalleQuery The current query, for fluid interface
     */
    public function prune($resultadoDetalle = null)
    {
        if ($resultadoDetalle) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ResultadoDetalleTableMap::COL_ALU_ID), $resultadoDetalle->getAluId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ResultadoDetalleTableMap::COL_PRE_ID), $resultadoDetalle->getPreId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(ResultadoDetalleTableMap::COL_EXA_ID), $resultadoDetalle->getExaId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the resultado_detalle table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ResultadoDetalleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ResultadoDetalleTableMap::clearInstancePool();
            ResultadoDetalleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ResultadoDetalleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ResultadoDetalleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ResultadoDetalleTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ResultadoDetalleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ResultadoDetalleQuery
