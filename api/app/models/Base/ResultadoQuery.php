<?php

namespace Base;

use \Resultado as ChildResultado;
use \ResultadoQuery as ChildResultadoQuery;
use \Exception;
use \PDO;
use Map\ResultadoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'resultado' table.
 *
 * 
 *
 * @method     ChildResultadoQuery orderByExaId($order = Criteria::ASC) Order by the exa_id column
 * @method     ChildResultadoQuery orderByAluId($order = Criteria::ASC) Order by the alu_id column
 *
 * @method     ChildResultadoQuery groupByExaId() Group by the exa_id column
 * @method     ChildResultadoQuery groupByAluId() Group by the alu_id column
 *
 * @method     ChildResultadoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildResultadoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildResultadoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildResultadoQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildResultadoQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildResultadoQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildResultadoQuery leftJoinAlumno($relationAlias = null) Adds a LEFT JOIN clause to the query using the Alumno relation
 * @method     ChildResultadoQuery rightJoinAlumno($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Alumno relation
 * @method     ChildResultadoQuery innerJoinAlumno($relationAlias = null) Adds a INNER JOIN clause to the query using the Alumno relation
 *
 * @method     ChildResultadoQuery joinWithAlumno($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Alumno relation
 *
 * @method     ChildResultadoQuery leftJoinWithAlumno() Adds a LEFT JOIN clause and with to the query using the Alumno relation
 * @method     ChildResultadoQuery rightJoinWithAlumno() Adds a RIGHT JOIN clause and with to the query using the Alumno relation
 * @method     ChildResultadoQuery innerJoinWithAlumno() Adds a INNER JOIN clause and with to the query using the Alumno relation
 *
 * @method     ChildResultadoQuery leftJoinExamen($relationAlias = null) Adds a LEFT JOIN clause to the query using the Examen relation
 * @method     ChildResultadoQuery rightJoinExamen($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Examen relation
 * @method     ChildResultadoQuery innerJoinExamen($relationAlias = null) Adds a INNER JOIN clause to the query using the Examen relation
 *
 * @method     ChildResultadoQuery joinWithExamen($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Examen relation
 *
 * @method     ChildResultadoQuery leftJoinWithExamen() Adds a LEFT JOIN clause and with to the query using the Examen relation
 * @method     ChildResultadoQuery rightJoinWithExamen() Adds a RIGHT JOIN clause and with to the query using the Examen relation
 * @method     ChildResultadoQuery innerJoinWithExamen() Adds a INNER JOIN clause and with to the query using the Examen relation
 *
 * @method     ChildResultadoQuery leftJoinResultadoDetalle($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResultadoDetalle relation
 * @method     ChildResultadoQuery rightJoinResultadoDetalle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResultadoDetalle relation
 * @method     ChildResultadoQuery innerJoinResultadoDetalle($relationAlias = null) Adds a INNER JOIN clause to the query using the ResultadoDetalle relation
 *
 * @method     ChildResultadoQuery joinWithResultadoDetalle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ResultadoDetalle relation
 *
 * @method     ChildResultadoQuery leftJoinWithResultadoDetalle() Adds a LEFT JOIN clause and with to the query using the ResultadoDetalle relation
 * @method     ChildResultadoQuery rightJoinWithResultadoDetalle() Adds a RIGHT JOIN clause and with to the query using the ResultadoDetalle relation
 * @method     ChildResultadoQuery innerJoinWithResultadoDetalle() Adds a INNER JOIN clause and with to the query using the ResultadoDetalle relation
 *
 * @method     \AlumnoQuery|\ExamenQuery|\ResultadoDetalleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildResultado findOne(ConnectionInterface $con = null) Return the first ChildResultado matching the query
 * @method     ChildResultado findOneOrCreate(ConnectionInterface $con = null) Return the first ChildResultado matching the query, or a new ChildResultado object populated from the query conditions when no match is found
 *
 * @method     ChildResultado findOneByExaId(int $exa_id) Return the first ChildResultado filtered by the exa_id column
 * @method     ChildResultado findOneByAluId(int $alu_id) Return the first ChildResultado filtered by the alu_id column *

 * @method     ChildResultado requirePk($key, ConnectionInterface $con = null) Return the ChildResultado by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultado requireOne(ConnectionInterface $con = null) Return the first ChildResultado matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResultado requireOneByExaId(int $exa_id) Return the first ChildResultado filtered by the exa_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildResultado requireOneByAluId(int $alu_id) Return the first ChildResultado filtered by the alu_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildResultado[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildResultado objects based on current ModelCriteria
 * @method     ChildResultado[]|ObjectCollection findByExaId(int $exa_id) Return ChildResultado objects filtered by the exa_id column
 * @method     ChildResultado[]|ObjectCollection findByAluId(int $alu_id) Return ChildResultado objects filtered by the alu_id column
 * @method     ChildResultado[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ResultadoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ResultadoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Resultado', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildResultadoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildResultadoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildResultadoQuery) {
            return $criteria;
        }
        $query = new ChildResultadoQuery();
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
     * @param array[$exa_id, $alu_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildResultado|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ResultadoTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ResultadoTableMap::DATABASE_NAME);
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
     * @return ChildResultado A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT exa_id, alu_id FROM resultado WHERE exa_id = :p0 AND alu_id = :p1';
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
            /** @var ChildResultado $obj */
            $obj = new ChildResultado();
            $obj->hydrate($row);
            ResultadoTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildResultado|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ResultadoTableMap::COL_EXA_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ResultadoTableMap::COL_ALU_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByExamen()
     *
     * @param     mixed $exaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByExaId($exaId = null, $comparison = null)
    {
        if (is_array($exaId)) {
            $useMinMax = false;
            if (isset($exaId['min'])) {
                $this->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $exaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exaId['max'])) {
                $this->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $exaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $exaId, $comparison);
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
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByAluId($aluId = null, $comparison = null)
    {
        if (is_array($aluId)) {
            $useMinMax = false;
            if (isset($aluId['min'])) {
                $this->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $aluId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($aluId['max'])) {
                $this->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $aluId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $aluId, $comparison);
    }

    /**
     * Filter the query by a related \Alumno object
     *
     * @param \Alumno|ObjectCollection $alumno The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByAlumno($alumno, $comparison = null)
    {
        if ($alumno instanceof \Alumno) {
            return $this
                ->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $alumno->getId(), $comparison);
        } elseif ($alumno instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $alumno->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildResultadoQuery The current query, for fluid interface
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
     * Filter the query by a related \Examen object
     *
     * @param \Examen|ObjectCollection $examen The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByExamen($examen, $comparison = null)
    {
        if ($examen instanceof \Examen) {
            return $this
                ->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $examen->getId(), $comparison);
        } elseif ($examen instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $examen->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByExamen() only accepts arguments of type \Examen or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Examen relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function joinExamen($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Examen');

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
            $this->addJoinObject($join, 'Examen');
        }

        return $this;
    }

    /**
     * Use the Examen relation Examen object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ExamenQuery A secondary query class using the current class as primary query
     */
    public function useExamenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExamen($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Examen', '\ExamenQuery');
    }

    /**
     * Filter the query by a related \ResultadoDetalle object
     *
     * @param \ResultadoDetalle|ObjectCollection $resultadoDetalle the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildResultadoQuery The current query, for fluid interface
     */
    public function filterByResultadoDetalle($resultadoDetalle, $comparison = null)
    {
        if ($resultadoDetalle instanceof \ResultadoDetalle) {
            return $this
                ->addUsingAlias(ResultadoTableMap::COL_EXA_ID, $resultadoDetalle->getExaId(), $comparison)
                ->addUsingAlias(ResultadoTableMap::COL_ALU_ID, $resultadoDetalle->getAluId(), $comparison);
        } else {
            throw new PropelException('filterByResultadoDetalle() only accepts arguments of type \ResultadoDetalle');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ResultadoDetalle relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function joinResultadoDetalle($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ResultadoDetalle');

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
            $this->addJoinObject($join, 'ResultadoDetalle');
        }

        return $this;
    }

    /**
     * Use the ResultadoDetalle relation ResultadoDetalle object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ResultadoDetalleQuery A secondary query class using the current class as primary query
     */
    public function useResultadoDetalleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinResultadoDetalle($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ResultadoDetalle', '\ResultadoDetalleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildResultado $resultado Object to remove from the list of results
     *
     * @return $this|ChildResultadoQuery The current query, for fluid interface
     */
    public function prune($resultado = null)
    {
        if ($resultado) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ResultadoTableMap::COL_EXA_ID), $resultado->getExaId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ResultadoTableMap::COL_ALU_ID), $resultado->getAluId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the resultado table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ResultadoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ResultadoTableMap::clearInstancePool();
            ResultadoTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ResultadoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ResultadoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            ResultadoTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            ResultadoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ResultadoQuery
