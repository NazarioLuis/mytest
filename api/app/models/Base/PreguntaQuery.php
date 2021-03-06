<?php

namespace Base;

use \Pregunta as ChildPregunta;
use \PreguntaQuery as ChildPreguntaQuery;
use \Exception;
use \PDO;
use Map\PreguntaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'pregunta' table.
 *
 * 
 *
 * @method     ChildPreguntaQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPreguntaQuery orderByExaId($order = Criteria::ASC) Order by the exa_id column
 * @method     ChildPreguntaQuery orderByTexto($order = Criteria::ASC) Order by the texto column
 *
 * @method     ChildPreguntaQuery groupById() Group by the id column
 * @method     ChildPreguntaQuery groupByExaId() Group by the exa_id column
 * @method     ChildPreguntaQuery groupByTexto() Group by the texto column
 *
 * @method     ChildPreguntaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPreguntaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPreguntaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPreguntaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPreguntaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPreguntaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPreguntaQuery leftJoinExamen($relationAlias = null) Adds a LEFT JOIN clause to the query using the Examen relation
 * @method     ChildPreguntaQuery rightJoinExamen($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Examen relation
 * @method     ChildPreguntaQuery innerJoinExamen($relationAlias = null) Adds a INNER JOIN clause to the query using the Examen relation
 *
 * @method     ChildPreguntaQuery joinWithExamen($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Examen relation
 *
 * @method     ChildPreguntaQuery leftJoinWithExamen() Adds a LEFT JOIN clause and with to the query using the Examen relation
 * @method     ChildPreguntaQuery rightJoinWithExamen() Adds a RIGHT JOIN clause and with to the query using the Examen relation
 * @method     ChildPreguntaQuery innerJoinWithExamen() Adds a INNER JOIN clause and with to the query using the Examen relation
 *
 * @method     ChildPreguntaQuery leftJoinRespuesta($relationAlias = null) Adds a LEFT JOIN clause to the query using the Respuesta relation
 * @method     ChildPreguntaQuery rightJoinRespuesta($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Respuesta relation
 * @method     ChildPreguntaQuery innerJoinRespuesta($relationAlias = null) Adds a INNER JOIN clause to the query using the Respuesta relation
 *
 * @method     ChildPreguntaQuery joinWithRespuesta($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Respuesta relation
 *
 * @method     ChildPreguntaQuery leftJoinWithRespuesta() Adds a LEFT JOIN clause and with to the query using the Respuesta relation
 * @method     ChildPreguntaQuery rightJoinWithRespuesta() Adds a RIGHT JOIN clause and with to the query using the Respuesta relation
 * @method     ChildPreguntaQuery innerJoinWithRespuesta() Adds a INNER JOIN clause and with to the query using the Respuesta relation
 *
 * @method     ChildPreguntaQuery leftJoinResultadoDetalle($relationAlias = null) Adds a LEFT JOIN clause to the query using the ResultadoDetalle relation
 * @method     ChildPreguntaQuery rightJoinResultadoDetalle($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ResultadoDetalle relation
 * @method     ChildPreguntaQuery innerJoinResultadoDetalle($relationAlias = null) Adds a INNER JOIN clause to the query using the ResultadoDetalle relation
 *
 * @method     ChildPreguntaQuery joinWithResultadoDetalle($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ResultadoDetalle relation
 *
 * @method     ChildPreguntaQuery leftJoinWithResultadoDetalle() Adds a LEFT JOIN clause and with to the query using the ResultadoDetalle relation
 * @method     ChildPreguntaQuery rightJoinWithResultadoDetalle() Adds a RIGHT JOIN clause and with to the query using the ResultadoDetalle relation
 * @method     ChildPreguntaQuery innerJoinWithResultadoDetalle() Adds a INNER JOIN clause and with to the query using the ResultadoDetalle relation
 *
 * @method     \ExamenQuery|\RespuestaQuery|\ResultadoDetalleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPregunta findOne(ConnectionInterface $con = null) Return the first ChildPregunta matching the query
 * @method     ChildPregunta findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPregunta matching the query, or a new ChildPregunta object populated from the query conditions when no match is found
 *
 * @method     ChildPregunta findOneById(int $id) Return the first ChildPregunta filtered by the id column
 * @method     ChildPregunta findOneByExaId(int $exa_id) Return the first ChildPregunta filtered by the exa_id column
 * @method     ChildPregunta findOneByTexto(string $texto) Return the first ChildPregunta filtered by the texto column *

 * @method     ChildPregunta requirePk($key, ConnectionInterface $con = null) Return the ChildPregunta by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPregunta requireOne(ConnectionInterface $con = null) Return the first ChildPregunta matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPregunta requireOneById(int $id) Return the first ChildPregunta filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPregunta requireOneByExaId(int $exa_id) Return the first ChildPregunta filtered by the exa_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPregunta requireOneByTexto(string $texto) Return the first ChildPregunta filtered by the texto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPregunta[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPregunta objects based on current ModelCriteria
 * @method     ChildPregunta[]|ObjectCollection findById(int $id) Return ChildPregunta objects filtered by the id column
 * @method     ChildPregunta[]|ObjectCollection findByExaId(int $exa_id) Return ChildPregunta objects filtered by the exa_id column
 * @method     ChildPregunta[]|ObjectCollection findByTexto(string $texto) Return ChildPregunta objects filtered by the texto column
 * @method     ChildPregunta[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PreguntaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PreguntaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Pregunta', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPreguntaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPreguntaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPreguntaQuery) {
            return $criteria;
        }
        $query = new ChildPreguntaQuery();
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
     * @param array[$id, $exa_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPregunta|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PreguntaTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])])))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PreguntaTableMap::DATABASE_NAME);
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
     * @return ChildPregunta A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, exa_id, texto FROM pregunta WHERE id = :p0 AND exa_id = :p1';
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
            /** @var ChildPregunta $obj */
            $obj = new ChildPregunta();
            $obj->hydrate($row);
            PreguntaTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildPregunta|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PreguntaTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PreguntaTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PreguntaTableMap::COL_EXA_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PreguntaTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PreguntaTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreguntaTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByExaId($exaId = null, $comparison = null)
    {
        if (is_array($exaId)) {
            $useMinMax = false;
            if (isset($exaId['min'])) {
                $this->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $exaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($exaId['max'])) {
                $this->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $exaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $exaId, $comparison);
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PreguntaTableMap::COL_TEXTO, $texto, $comparison);
    }

    /**
     * Filter the query by a related \Examen object
     *
     * @param \Examen|ObjectCollection $examen The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByExamen($examen, $comparison = null)
    {
        if ($examen instanceof \Examen) {
            return $this
                ->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $examen->getId(), $comparison);
        } elseif ($examen instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $examen->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
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
     * Filter the query by a related \Respuesta object
     *
     * @param \Respuesta|ObjectCollection $respuesta the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByRespuesta($respuesta, $comparison = null)
    {
        if ($respuesta instanceof \Respuesta) {
            return $this
                ->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $respuesta->getExaId(), $comparison)
                ->addUsingAlias(PreguntaTableMap::COL_ID, $respuesta->getPreId(), $comparison);
        } else {
            throw new PropelException('filterByRespuesta() only accepts arguments of type \Respuesta');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Respuesta relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function joinRespuesta($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Respuesta');

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
            $this->addJoinObject($join, 'Respuesta');
        }

        return $this;
    }

    /**
     * Use the Respuesta relation Respuesta object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \RespuestaQuery A secondary query class using the current class as primary query
     */
    public function useRespuestaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRespuesta($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Respuesta', '\RespuestaQuery');
    }

    /**
     * Filter the query by a related \ResultadoDetalle object
     *
     * @param \ResultadoDetalle|ObjectCollection $resultadoDetalle the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPreguntaQuery The current query, for fluid interface
     */
    public function filterByResultadoDetalle($resultadoDetalle, $comparison = null)
    {
        if ($resultadoDetalle instanceof \ResultadoDetalle) {
            return $this
                ->addUsingAlias(PreguntaTableMap::COL_EXA_ID, $resultadoDetalle->getExaId(), $comparison)
                ->addUsingAlias(PreguntaTableMap::COL_ID, $resultadoDetalle->getPreId(), $comparison);
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
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
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
     * @param   ChildPregunta $pregunta Object to remove from the list of results
     *
     * @return $this|ChildPreguntaQuery The current query, for fluid interface
     */
    public function prune($pregunta = null)
    {
        if ($pregunta) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PreguntaTableMap::COL_ID), $pregunta->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PreguntaTableMap::COL_EXA_ID), $pregunta->getExaId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the pregunta table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreguntaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PreguntaTableMap::clearInstancePool();
            PreguntaTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PreguntaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PreguntaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            
            PreguntaTableMap::removeInstanceFromPool($criteria);
        
            $affectedRows += ModelCriteria::delete($con);
            PreguntaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PreguntaQuery
