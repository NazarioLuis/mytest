<?php

namespace Base;

use \Inscripcion as ChildInscripcion;
use \InscripcionQuery as ChildInscripcionQuery;
use \Exception;
use \PDO;
use Map\InscripcionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'inscripcion' table.
 *
 * 
 *
 * @method     ChildInscripcionQuery orderByPerId($order = Criteria::ASC) Order by the per_id column
 * @method     ChildInscripcionQuery orderByAluId($order = Criteria::ASC) Order by the alu_id column
 * @method     ChildInscripcionQuery orderByOrden($order = Criteria::ASC) Order by the orden column
 *
 * @method     ChildInscripcionQuery groupByPerId() Group by the per_id column
 * @method     ChildInscripcionQuery groupByAluId() Group by the alu_id column
 * @method     ChildInscripcionQuery groupByOrden() Group by the orden column
 *
 * @method     ChildInscripcionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInscripcionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInscripcionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInscripcionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInscripcionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInscripcionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInscripcionQuery leftJoinAlumno($relationAlias = null) Adds a LEFT JOIN clause to the query using the Alumno relation
 * @method     ChildInscripcionQuery rightJoinAlumno($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Alumno relation
 * @method     ChildInscripcionQuery innerJoinAlumno($relationAlias = null) Adds a INNER JOIN clause to the query using the Alumno relation
 *
 * @method     ChildInscripcionQuery joinWithAlumno($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Alumno relation
 *
 * @method     ChildInscripcionQuery leftJoinWithAlumno() Adds a LEFT JOIN clause and with to the query using the Alumno relation
 * @method     ChildInscripcionQuery rightJoinWithAlumno() Adds a RIGHT JOIN clause and with to the query using the Alumno relation
 * @method     ChildInscripcionQuery innerJoinWithAlumno() Adds a INNER JOIN clause and with to the query using the Alumno relation
 *
 * @method     ChildInscripcionQuery leftJoinPeriodo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Periodo relation
 * @method     ChildInscripcionQuery rightJoinPeriodo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Periodo relation
 * @method     ChildInscripcionQuery innerJoinPeriodo($relationAlias = null) Adds a INNER JOIN clause to the query using the Periodo relation
 *
 * @method     ChildInscripcionQuery joinWithPeriodo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Periodo relation
 *
 * @method     ChildInscripcionQuery leftJoinWithPeriodo() Adds a LEFT JOIN clause and with to the query using the Periodo relation
 * @method     ChildInscripcionQuery rightJoinWithPeriodo() Adds a RIGHT JOIN clause and with to the query using the Periodo relation
 * @method     ChildInscripcionQuery innerJoinWithPeriodo() Adds a INNER JOIN clause and with to the query using the Periodo relation
 *
 * @method     \AlumnoQuery|\PeriodoQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInscripcion findOne(ConnectionInterface $con = null) Return the first ChildInscripcion matching the query
 * @method     ChildInscripcion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInscripcion matching the query, or a new ChildInscripcion object populated from the query conditions when no match is found
 *
 * @method     ChildInscripcion findOneByPerId(int $per_id) Return the first ChildInscripcion filtered by the per_id column
 * @method     ChildInscripcion findOneByAluId(int $alu_id) Return the first ChildInscripcion filtered by the alu_id column
 * @method     ChildInscripcion findOneByOrden(int $orden) Return the first ChildInscripcion filtered by the orden column *

 * @method     ChildInscripcion requirePk($key, ConnectionInterface $con = null) Return the ChildInscripcion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInscripcion requireOne(ConnectionInterface $con = null) Return the first ChildInscripcion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInscripcion requireOneByPerId(int $per_id) Return the first ChildInscripcion filtered by the per_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInscripcion requireOneByAluId(int $alu_id) Return the first ChildInscripcion filtered by the alu_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInscripcion requireOneByOrden(int $orden) Return the first ChildInscripcion filtered by the orden column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInscripcion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInscripcion objects based on current ModelCriteria
 * @method     ChildInscripcion[]|ObjectCollection findByPerId(int $per_id) Return ChildInscripcion objects filtered by the per_id column
 * @method     ChildInscripcion[]|ObjectCollection findByAluId(int $alu_id) Return ChildInscripcion objects filtered by the alu_id column
 * @method     ChildInscripcion[]|ObjectCollection findByOrden(int $orden) Return ChildInscripcion objects filtered by the orden column
 * @method     ChildInscripcion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InscripcionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\InscripcionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Inscripcion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInscripcionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInscripcionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInscripcionQuery) {
            return $criteria;
        }
        $query = new ChildInscripcionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$per_id, $alu_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildInscripcion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = InscripcionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InscripcionTableMap::DATABASE_NAME);
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
     * @return ChildInscripcion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT per_id, alu_id, orden FROM inscripcion WHERE per_id = :p0 AND alu_id = :p1';
        try {
            $stmt = $con->prepare($sql);            
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);            
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildInscripcion $obj */
            $obj = new ChildInscripcion();
            $obj->hydrate($row);
            InscripcionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildInscripcion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(InscripcionTableMap::COL_PER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(InscripcionTableMap::COL_PER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(InscripcionTableMap::COL_ALU_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByPerId($perId = null, $comparison = null)
    {
        if (is_array($perId)) {
            $useMinMax = false;
            if (isset($perId['min'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_PER_ID, $perId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($perId['max'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_PER_ID, $perId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InscripcionTableMap::COL_PER_ID, $perId, $comparison);
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
     * @see       filterByAlumno()
     *
     * @param     mixed $aluId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByAluId($aluId = null, $comparison = null)
    {
        if (is_array($aluId)) {
            $useMinMax = false;
            if (isset($aluId['min'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $aluId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aluId['max'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $aluId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $aluId, $comparison);
    }

    /**
     * Filter the query on the orden column
     *
     * Example usage:
     * <code>
     * $query->filterByOrden(1234); // WHERE orden = 1234
     * $query->filterByOrden(array(12, 34)); // WHERE orden IN (12, 34)
     * $query->filterByOrden(array('min' => 12)); // WHERE orden > 12
     * </code>
     *
     * @param     mixed $orden The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByOrden($orden = null, $comparison = null)
    {
        if (is_array($orden)) {
            $useMinMax = false;
            if (isset($orden['min'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_ORDEN, $orden['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orden['max'])) {
                $this->addUsingAlias(InscripcionTableMap::COL_ORDEN, $orden['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InscripcionTableMap::COL_ORDEN, $orden, $comparison);
    }

    /**
     * Filter the query by a related \Alumno object
     *
     * @param \Alumno|ObjectCollection $alumno The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByAlumno($alumno, $comparison = null)
    {
        if ($alumno instanceof \Alumno) {
            return $this
                ->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $alumno->getId(), $comparison);
        } elseif ($alumno instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InscripcionTableMap::COL_ALU_ID, $alumno->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAlumno() only accepts arguments of type \Alumno or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Alumno relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function joinAlumno($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Alumno');

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
            $this->addJoinObject($join, 'Alumno');
        }

        return $this;
    }

    /**
     * Use the Alumno relation Alumno object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \AlumnoQuery A secondary query class using the current class as primary query
     */
    public function useAlumnoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAlumno($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Alumno', '\AlumnoQuery');
    }

    /**
     * Filter the query by a related \Periodo object
     *
     * @param \Periodo|ObjectCollection $periodo The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInscripcionQuery The current query, for fluid interface
     */
    public function filterByPeriodo($periodo, $comparison = null)
    {
        if ($periodo instanceof \Periodo) {
            return $this
                ->addUsingAlias(InscripcionTableMap::COL_PER_ID, $periodo->getId(), $comparison);
        } elseif ($periodo instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InscripcionTableMap::COL_PER_ID, $periodo->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildInscripcion $inscripcion Object to remove from the list of results
     *
     * @return $this|ChildInscripcionQuery The current query, for fluid interface
     */
    public function prune($inscripcion = null)
    {
        if ($inscripcion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(InscripcionTableMap::COL_PER_ID), $inscripcion->getPerId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(InscripcionTableMap::COL_ALU_ID), $inscripcion->getAluId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the inscripcion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InscripcionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InscripcionTableMap::clearInstancePool();
            InscripcionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InscripcionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InscripcionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            InscripcionTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            InscripcionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InscripcionQuery
