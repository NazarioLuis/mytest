<?php

namespace Base;

use \Examen as ChildExamen;
use \ExamenQuery as ChildExamenQuery;
use \Exception;
use \PDO;
use Map\ExamenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'examen' table.
 *
 * 
 *
 * @method     ChildExamenQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildExamenQuery orderByMatId($order = Criteria::ASC) Order by the mat_id column
 * @method     ChildExamenQuery orderByPerId($order = Criteria::ASC) Order by the per_id column
 * @method     ChildExamenQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 * @method     ChildExamenQuery orderByFormativa($order = Criteria::ASC) Order by the formativa column
 *
 * @method     ChildExamenQuery groupById() Group by the id column
 * @method     ChildExamenQuery groupByMatId() Group by the mat_id column
 * @method     ChildExamenQuery groupByPerId() Group by the per_id column
 * @method     ChildExamenQuery groupByFecha() Group by the fecha column
 * @method     ChildExamenQuery groupByFormativa() Group by the formativa column
 *
 * @method     ChildExamenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExamenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExamenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExamenQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildExamenQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildExamenQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildExamenQuery leftJoinMateria($relationAlias = null) Adds a LEFT JOIN clause to the query using the Materia relation
 * @method     ChildExamenQuery rightJoinMateria($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Materia relation
 * @method     ChildExamenQuery innerJoinMateria($relationAlias = null) Adds a INNER JOIN clause to the query using the Materia relation
 *
 * @method     ChildExamenQuery joinWithMateria($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Materia relation
 *
 * @method     ChildExamenQuery leftJoinWithMateria() Adds a LEFT JOIN clause and with to the query using the Materia relation
 * @method     ChildExamenQuery rightJoinWithMateria() Adds a RIGHT JOIN clause and with to the query using the Materia relation
 * @method     ChildExamenQuery innerJoinWithMateria() Adds a INNER JOIN clause and with to the query using the Materia relation
 *
 * @method     ChildExamenQuery leftJoinPeriodo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Periodo relation
 * @method     ChildExamenQuery rightJoinPeriodo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Periodo relation
 * @method     ChildExamenQuery innerJoinPeriodo($relationAlias = null) Adds a INNER JOIN clause to the query using the Periodo relation
 *
 * @method     ChildExamenQuery joinWithPeriodo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Periodo relation
 *
 * @method     ChildExamenQuery leftJoinWithPeriodo() Adds a LEFT JOIN clause and with to the query using the Periodo relation
 * @method     ChildExamenQuery rightJoinWithPeriodo() Adds a RIGHT JOIN clause and with to the query using the Periodo relation
 * @method     ChildExamenQuery innerJoinWithPeriodo() Adds a INNER JOIN clause and with to the query using the Periodo relation
 *
 * @method     ChildExamenQuery leftJoinPregunta($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pregunta relation
 * @method     ChildExamenQuery rightJoinPregunta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pregunta relation
 * @method     ChildExamenQuery innerJoinPregunta($relationAlias = null) Adds a INNER JOIN clause to the query using the Pregunta relation
 *
 * @method     ChildExamenQuery joinWithPregunta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Pregunta relation
 *
 * @method     ChildExamenQuery leftJoinWithPregunta() Adds a LEFT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildExamenQuery rightJoinWithPregunta() Adds a RIGHT JOIN clause and with to the query using the Pregunta relation
 * @method     ChildExamenQuery innerJoinWithPregunta() Adds a INNER JOIN clause and with to the query using the Pregunta relation
 *
 * @method     ChildExamenQuery leftJoinResultado($relationAlias = null) Adds a LEFT JOIN clause to the query using the Resultado relation
 * @method     ChildExamenQuery rightJoinResultado($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Resultado relation
 * @method     ChildExamenQuery innerJoinResultado($relationAlias = null) Adds a INNER JOIN clause to the query using the Resultado relation
 *
 * @method     ChildExamenQuery joinWithResultado($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Resultado relation
 *
 * @method     ChildExamenQuery leftJoinWithResultado() Adds a LEFT JOIN clause and with to the query using the Resultado relation
 * @method     ChildExamenQuery rightJoinWithResultado() Adds a RIGHT JOIN clause and with to the query using the Resultado relation
 * @method     ChildExamenQuery innerJoinWithResultado() Adds a INNER JOIN clause and with to the query using the Resultado relation
 *
 * @method     \MateriaQuery|\PeriodoQuery|\PreguntaQuery|\ResultadoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExamen findOne(ConnectionInterface $con = null) Return the first ChildExamen matching the query
 * @method     ChildExamen findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExamen matching the query, or a new ChildExamen object populated from the query conditions when no match is found
 *
 * @method     ChildExamen findOneById(int $id) Return the first ChildExamen filtered by the id column
 * @method     ChildExamen findOneByMatId(int $mat_id) Return the first ChildExamen filtered by the mat_id column
 * @method     ChildExamen findOneByPerId(int $per_id) Return the first ChildExamen filtered by the per_id column
 * @method     ChildExamen findOneByFecha(string $fecha) Return the first ChildExamen filtered by the fecha column
 * @method     ChildExamen findOneByFormativa(boolean $formativa) Return the first ChildExamen filtered by the formativa column *

 * @method     ChildExamen requirePk($key, ConnectionInterface $con = null) Return the ChildExamen by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamen requireOne(ConnectionInterface $con = null) Return the first ChildExamen matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamen requireOneById(int $id) Return the first ChildExamen filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamen requireOneByMatId(int $mat_id) Return the first ChildExamen filtered by the mat_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamen requireOneByPerId(int $per_id) Return the first ChildExamen filtered by the per_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamen requireOneByFecha(string $fecha) Return the first ChildExamen filtered by the fecha column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamen requireOneByFormativa(boolean $formativa) Return the first ChildExamen filtered by the formativa column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamen[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExamen objects based on current ModelCriteria
 * @method     ChildExamen[]|ObjectCollection findById(int $id) Return ChildExamen objects filtered by the id column
 * @method     ChildExamen[]|ObjectCollection findByMatId(int $mat_id) Return ChildExamen objects filtered by the mat_id column
 * @method     ChildExamen[]|ObjectCollection findByPerId(int $per_id) Return ChildExamen objects filtered by the per_id column
 * @method     ChildExamen[]|ObjectCollection findByFecha(string $fecha) Return ChildExamen objects filtered by the fecha column
 * @method     ChildExamen[]|ObjectCollection findByFormativa(boolean $formativa) Return ChildExamen objects filtered by the formativa column
 * @method     ChildExamen[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExamenQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ExamenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Examen', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExamenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExamenQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExamenQuery) {
            return $criteria;
        }
        $query = new ChildExamenQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildExamen|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExamenTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExamenTableMap::DATABASE_NAME);
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
     * @return ChildExamen A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, mat_id, per_id, fecha, formativa FROM examen WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildExamen $obj */
            $obj = new ChildExamen();
            $obj->hydrate($row);
            ExamenTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildExamen|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExamenTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExamenTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ExamenTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ExamenTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamenTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the mat_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMatId(1234); // WHERE mat_id = 1234
     * $query->filterByMatId(array(12, 34)); // WHERE mat_id IN (12, 34)
     * $query->filterByMatId(array('min' => 12)); // WHERE mat_id > 12
     * </code>
     *
     * @see       filterByMateria()
     *
     * @param     mixed $matId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByMatId($matId = null, $comparison = null)
    {
        if (is_array($matId)) {
            $useMinMax = false;
            if (isset($matId['min'])) {
                $this->addUsingAlias(ExamenTableMap::COL_MAT_ID, $matId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($matId['max'])) {
                $this->addUsingAlias(ExamenTableMap::COL_MAT_ID, $matId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamenTableMap::COL_MAT_ID, $matId, $comparison);
    }

    /**
     * Filter the query on the per_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPerId(1234); // WHERE per_id = 1234
     * $query->filterByPerId(array(12, 34)); // WHERE per_id IN (12, 34)
     * $query->filterByPerId(array('min' => 12)); // WHERE per_id > 12
     * </code>
     *
     * @see       filterByPeriodo()
     *
     * @param     mixed $perId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByPerId($perId = null, $comparison = null)
    {
        if (is_array($perId)) {
            $useMinMax = false;
            if (isset($perId['min'])) {
                $this->addUsingAlias(ExamenTableMap::COL_PER_ID, $perId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perId['max'])) {
                $this->addUsingAlias(ExamenTableMap::COL_PER_ID, $perId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamenTableMap::COL_PER_ID, $perId, $comparison);
    }

    /**
     * Filter the query on the fecha column
     *
     * Example usage:
     * <code>
     * $query->filterByFecha('2011-03-14'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha('now'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha(array('max' => 'yesterday')); // WHERE fecha > '2011-03-13'
     * </code>
     *
     * @param     mixed $fecha The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(ExamenTableMap::COL_FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(ExamenTableMap::COL_FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamenTableMap::COL_FECHA, $fecha, $comparison);
    }

    /**
     * Filter the query on the formativa column
     *
     * Example usage:
     * <code>
     * $query->filterByFormativa(true); // WHERE formativa = true
     * $query->filterByFormativa('yes'); // WHERE formativa = true
     * </code>
     *
     * @param     boolean|string $formativa The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function filterByFormativa($formativa = null, $comparison = null)
    {
        if (is_string($formativa)) {
            $formativa = in_array(strtolower($formativa), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ExamenTableMap::COL_FORMATIVA, $formativa, $comparison);
    }

    /**
     * Filter the query by a related \Materia object
     *
     * @param \Materia|ObjectCollection $materia The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamenQuery The current query, for fluid interface
     */
    public function filterByMateria($materia, $comparison = null)
    {
        if ($materia instanceof \Materia) {
            return $this
                ->addUsingAlias(ExamenTableMap::COL_MAT_ID, $materia->getId(), $comparison);
        } elseif ($materia instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamenTableMap::COL_MAT_ID, $materia->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMateria() only accepts arguments of type \Materia or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Materia relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function joinMateria($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Materia');

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
            $this->addJoinObject($join, 'Materia');
        }

        return $this;
    }

    /**
     * Use the Materia relation Materia object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \MateriaQuery A secondary query class using the current class as primary query
     */
    public function useMateriaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMateria($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Materia', '\MateriaQuery');
    }

    /**
     * Filter the query by a related \Periodo object
     *
     * @param \Periodo|ObjectCollection $periodo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamenQuery The current query, for fluid interface
     */
    public function filterByPeriodo($periodo, $comparison = null)
    {
        if ($periodo instanceof \Periodo) {
            return $this
                ->addUsingAlias(ExamenTableMap::COL_PER_ID, $periodo->getId(), $comparison);
        } elseif ($periodo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamenTableMap::COL_PER_ID, $periodo->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPeriodo() only accepts arguments of type \Periodo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Periodo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function joinPeriodo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Periodo');

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
            $this->addJoinObject($join, 'Periodo');
        }

        return $this;
    }

    /**
     * Use the Periodo relation Periodo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PeriodoQuery A secondary query class using the current class as primary query
     */
    public function usePeriodoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPeriodo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Periodo', '\PeriodoQuery');
    }

    /**
     * Filter the query by a related \Pregunta object
     *
     * @param \Pregunta|ObjectCollection $pregunta the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamenQuery The current query, for fluid interface
     */
    public function filterByPregunta($pregunta, $comparison = null)
    {
        if ($pregunta instanceof \Pregunta) {
            return $this
                ->addUsingAlias(ExamenTableMap::COL_ID, $pregunta->getExaId(), $comparison);
        } elseif ($pregunta instanceof ObjectCollection) {
            return $this
                ->usePreguntaQuery()
                ->filterByPrimaryKeys($pregunta->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPregunta() only accepts arguments of type \Pregunta or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pregunta relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
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
     * @param \Resultado|ObjectCollection $resultado the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamenQuery The current query, for fluid interface
     */
    public function filterByResultado($resultado, $comparison = null)
    {
        if ($resultado instanceof \Resultado) {
            return $this
                ->addUsingAlias(ExamenTableMap::COL_ID, $resultado->getExaId(), $comparison);
        } elseif ($resultado instanceof ObjectCollection) {
            return $this
                ->useResultadoQuery()
                ->filterByPrimaryKeys($resultado->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByResultado() only accepts arguments of type \Resultado or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Resultado relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
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
     * @param   ChildExamen $examen Object to remove from the list of results
     *
     * @return $this|ChildExamenQuery The current query, for fluid interface
     */
    public function prune($examen = null)
    {
        if ($examen) {
            $this->addUsingAlias(ExamenTableMap::COL_ID, $examen->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the examen table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExamenTableMap::clearInstancePool();
            ExamenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExamenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ExamenTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ExamenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ExamenQuery
