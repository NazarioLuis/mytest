<?php

namespace Base;

use \Materia as ChildMateria;
use \MateriaQuery as ChildMateriaQuery;
use \Exception;
use \PDO;
use Map\MateriaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'materia' table.
 *
 * 
 *
 * @method     ChildMateriaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMateriaQuery orderByCarId($order = Criteria::ASC) Order by the car_id column
 * @method     ChildMateriaQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildMateriaQuery orderByObservacion($order = Criteria::ASC) Order by the observacion column
 *
 * @method     ChildMateriaQuery groupById() Group by the id column
 * @method     ChildMateriaQuery groupByCarId() Group by the car_id column
 * @method     ChildMateriaQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildMateriaQuery groupByObservacion() Group by the observacion column
 *
 * @method     ChildMateriaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMateriaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMateriaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMateriaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMateriaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMateriaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMateriaQuery leftJoinCarrera($relationAlias = null) Adds a LEFT JOIN clause to the query using the Carrera relation
 * @method     ChildMateriaQuery rightJoinCarrera($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Carrera relation
 * @method     ChildMateriaQuery innerJoinCarrera($relationAlias = null) Adds a INNER JOIN clause to the query using the Carrera relation
 *
 * @method     ChildMateriaQuery joinWithCarrera($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Carrera relation
 *
 * @method     ChildMateriaQuery leftJoinWithCarrera() Adds a LEFT JOIN clause and with to the query using the Carrera relation
 * @method     ChildMateriaQuery rightJoinWithCarrera() Adds a RIGHT JOIN clause and with to the query using the Carrera relation
 * @method     ChildMateriaQuery innerJoinWithCarrera() Adds a INNER JOIN clause and with to the query using the Carrera relation
 *
 * @method     ChildMateriaQuery leftJoinExamen($relationAlias = null) Adds a LEFT JOIN clause to the query using the Examen relation
 * @method     ChildMateriaQuery rightJoinExamen($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Examen relation
 * @method     ChildMateriaQuery innerJoinExamen($relationAlias = null) Adds a INNER JOIN clause to the query using the Examen relation
 *
 * @method     ChildMateriaQuery joinWithExamen($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Examen relation
 *
 * @method     ChildMateriaQuery leftJoinWithExamen() Adds a LEFT JOIN clause and with to the query using the Examen relation
 * @method     ChildMateriaQuery rightJoinWithExamen() Adds a RIGHT JOIN clause and with to the query using the Examen relation
 * @method     ChildMateriaQuery innerJoinWithExamen() Adds a INNER JOIN clause and with to the query using the Examen relation
 *
 * @method     \CarreraQuery|\ExamenQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMateria findOne(ConnectionInterface $con = null) Return the first ChildMateria matching the query
 * @method     ChildMateria findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMateria matching the query, or a new ChildMateria object populated from the query conditions when no match is found
 *
 * @method     ChildMateria findOneById(int $id) Return the first ChildMateria filtered by the id column
 * @method     ChildMateria findOneByCarId(int $car_id) Return the first ChildMateria filtered by the car_id column
 * @method     ChildMateria findOneByDescripcion(string $descripcion) Return the first ChildMateria filtered by the descripcion column
 * @method     ChildMateria findOneByObservacion(string $observacion) Return the first ChildMateria filtered by the observacion column *

 * @method     ChildMateria requirePk($key, ConnectionInterface $con = null) Return the ChildMateria by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMateria requireOne(ConnectionInterface $con = null) Return the first ChildMateria matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMateria requireOneById(int $id) Return the first ChildMateria filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMateria requireOneByCarId(int $car_id) Return the first ChildMateria filtered by the car_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMateria requireOneByDescripcion(string $descripcion) Return the first ChildMateria filtered by the descripcion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMateria requireOneByObservacion(string $observacion) Return the first ChildMateria filtered by the observacion column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMateria[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMateria objects based on current ModelCriteria
 * @method     ChildMateria[]|ObjectCollection findById(int $id) Return ChildMateria objects filtered by the id column
 * @method     ChildMateria[]|ObjectCollection findByCarId(int $car_id) Return ChildMateria objects filtered by the car_id column
 * @method     ChildMateria[]|ObjectCollection findByDescripcion(string $descripcion) Return ChildMateria objects filtered by the descripcion column
 * @method     ChildMateria[]|ObjectCollection findByObservacion(string $observacion) Return ChildMateria objects filtered by the observacion column
 * @method     ChildMateria[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MateriaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\MateriaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Materia', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMateriaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMateriaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMateriaQuery) {
            return $criteria;
        }
        $query = new ChildMateriaQuery();
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
     * @return ChildMateria|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MateriaTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MateriaTableMap::DATABASE_NAME);
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
     * @return ChildMateria A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, car_id, descripcion, observacion FROM materia WHERE id = :p0';
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
            /** @var ChildMateria $obj */
            $obj = new ChildMateria();
            $obj->hydrate($row);
            MateriaTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildMateria|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MateriaTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MateriaTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MateriaTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MateriaTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MateriaTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the car_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCarId(1234); // WHERE car_id = 1234
     * $query->filterByCarId(array(12, 34)); // WHERE car_id IN (12, 34)
     * $query->filterByCarId(array('min' => 12)); // WHERE car_id > 12
     * </code>
     *
     * @see       filterByCarrera()
     *
     * @param     mixed $carId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByCarId($carId = null, $comparison = null)
    {
        if (is_array($carId)) {
            $useMinMax = false;
            if (isset($carId['min'])) {
                $this->addUsingAlias(MateriaTableMap::COL_CAR_ID, $carId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($carId['max'])) {
                $this->addUsingAlias(MateriaTableMap::COL_CAR_ID, $carId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MateriaTableMap::COL_CAR_ID, $carId, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descripcion)) {
                $descripcion = str_replace('*', '%', $descripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MateriaTableMap::COL_DESCRIPCION, $descripcion, $comparison);
    }

    /**
     * Filter the query on the observacion column
     *
     * Example usage:
     * <code>
     * $query->filterByObservacion('fooValue');   // WHERE observacion = 'fooValue'
     * $query->filterByObservacion('%fooValue%'); // WHERE observacion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $observacion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByObservacion($observacion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($observacion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $observacion)) {
                $observacion = str_replace('*', '%', $observacion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MateriaTableMap::COL_OBSERVACION, $observacion, $comparison);
    }

    /**
     * Filter the query by a related \Carrera object
     *
     * @param \Carrera|ObjectCollection $carrera The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByCarrera($carrera, $comparison = null)
    {
        if ($carrera instanceof \Carrera) {
            return $this
                ->addUsingAlias(MateriaTableMap::COL_CAR_ID, $carrera->getId(), $comparison);
        } elseif ($carrera instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MateriaTableMap::COL_CAR_ID, $carrera->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCarrera() only accepts arguments of type \Carrera or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Carrera relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function joinCarrera($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Carrera');

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
            $this->addJoinObject($join, 'Carrera');
        }

        return $this;
    }

    /**
     * Use the Carrera relation Carrera object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CarreraQuery A secondary query class using the current class as primary query
     */
    public function useCarreraQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCarrera($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Carrera', '\CarreraQuery');
    }

    /**
     * Filter the query by a related \Examen object
     *
     * @param \Examen|ObjectCollection $examen the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMateriaQuery The current query, for fluid interface
     */
    public function filterByExamen($examen, $comparison = null)
    {
        if ($examen instanceof \Examen) {
            return $this
                ->addUsingAlias(MateriaTableMap::COL_ID, $examen->getMatId(), $comparison);
        } elseif ($examen instanceof ObjectCollection) {
            return $this
                ->useExamenQuery()
                ->filterByPrimaryKeys($examen->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildMateriaQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildMateria $materia Object to remove from the list of results
     *
     * @return $this|ChildMateriaQuery The current query, for fluid interface
     */
    public function prune($materia = null)
    {
        if ($materia) {
            $this->addUsingAlias(MateriaTableMap::COL_ID, $materia->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the materia table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MateriaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MateriaTableMap::clearInstancePool();
            MateriaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(MateriaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MateriaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            MateriaTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            MateriaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MateriaQuery
