<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Database\Driver;

use PDO;
use Psr\Log\LoggerAwareInterface;
use Spiral\Database\Driver\Traits\BuilderTrait;
use Spiral\Database\Driver\Traits\PDOTrait;
use Spiral\Database\Driver\Traits\ProfilingTrait;
use Spiral\Database\Driver\Traits\TransactionTrait;
use Spiral\Database\Exception\DriverException;
use Spiral\Database\Exception\QueryException;
use Spiral\Database\Schema\AbstractTable;

/**
 * Driver abstraction is responsible for DBMS specific set of functions and used by Databases to
 * hide implementation specific functionality. Extends PDODriver and adds ability to create driver
 * specific query builders and schemas (basically operates like a factory).
 */
abstract class AbstractDriver implements DriverInterface, LoggerAwareInterface
{
    use ProfilingTrait, PDOTrait, BuilderTrait, TransactionTrait;

    // One of DatabaseInterface types, must be set on implementation.
    protected const TYPE = null;

    // Driver specific class names.
    protected const TABLE_SCHEMA_CLASS = '';
    protected const COMMANDER          = '';
    protected const QUERY_COMPILER     = '';

    // DateTime format to be used to perform automatic conversion of DateTime objects.
    protected const DATETIME = 'Y-m-d H:i:s';

    /** @var string */
    private $name = '';

    /**
     * Connection configuration described in DBAL config file. Any driver can be used as data source
     * for multiple databases as table prefix and quotation defined on Database instance level.
     *
     * @var array
     */
    protected $options = [
        'profiling'  => false,

        //All datetime objects will be converted relative to this timezone (must match with DB timezone!)
        'timezone'   => 'UTC',

        //DSN
        'connection' => '',
        'username'   => '',
        'password'   => '',
        'options'    => [],
    ];

    /**
     * PDO connection options set.
     *
     * @var array
     */
    protected $pdoOptions = [
        PDO::ATTR_CASE             => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    /**
     * @param string $name
     * @param array  $options
     */
    public function __construct(string $name, array $options)
    {
        $this->name = $name;
        $this->options = $options + $this->options;

        if (!empty($options['options'])) {
            //PDO connection options has to be stored under key "options" of config
            $this->pdoOptions = $options['options'] + $this->pdoOptions;
        }

        if (!empty($this->options['profiling'])) {
            $this->setProfiling(true);
        }
    }

    /**
     * Source name, can include database name or database file.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get driver source database or file name.
     *
     * @return string
     *
     * @throws DriverException
     */
    public function getSource(): string
    {
        if (preg_match('/(?:dbname|database)=([^;]+)/i', $this->options['connection'], $matches)) {
            return $matches[1];
        }

        throw new DriverException('Unable to locate source name');
    }

    /**
     * Database type driver linked to.
     *
     * @return string
     */
    public function getType(): string
    {
        return static::TYPE;
    }

    /**
     * Connection specific timezone, at this moment locked to UTC.
     *
     * @return \DateTimeZone
     */
    public function getTimezone(): \DateTimeZone
    {
        return new \DateTimeZone($this->options['timezone']);
    }

    /**
     * Driver specific database/table identifier quotation.
     *
     * @param string $identifier
     *
     * @return string
     */
    public function identifier(string $identifier): string
    {
        return $identifier == '*' ? '*' : '"' . str_replace('"', '""', $identifier) . '"';
    }

    /**
     * Get Driver specific AbstractTable implementation.
     *
     * @param string $table  Table name without prefix included.
     * @param string $prefix Database specific table prefix, this parameter is not required, but if
     *                       provided all foreign keys will be created using it.
     * @return AbstractTable
     */
    public function getSchema(string $table, string $prefix = ''): AbstractTable
    {
        $schema = static::TABLE_SCHEMA_CLASS;

        return new $schema($this, $table, $prefix);
    }

    /**
     * Get instance of Driver specific QueryCompiler.
     *
     * @param string $prefix Database specific table prefix, used to quote table names and build
     *                       aliases.
     * @return Compiler
     */
    public function getCompiler(string $prefix = ''): CompilerInterface
    {
        $compiler = static::QUERY_COMPILER;

        return new $compiler(new Quoter($this, $prefix));
    }

    /**
     * @return array
     */
    public function __debugInfo()
    {
        return [
            'connection' => $this->options['connection'],
            'connected'  => $this->isConnected(),
            'profiling'  => $this->isProfiling(),
            'source'     => $this->getSource(),
            'options'    => $this->pdoOptions,
        ];
    }

    /**
     * Create instance of configured PDO class.
     *
     * @return PDO
     */
    protected function createPDO(): PDO
    {
        return new PDO(
            $this->options['connection'],
            $this->options['username'],
            $this->options['password'],
            $this->pdoOptions
        );
    }

    /**
     * Convert PDO exception into query or integrity exception.
     *
     * @param \PDOException $exception
     * @param string        $query
     * @return QueryException
     */
    protected function clarifyException(\PDOException $exception, string $query): QueryException
    {
        return new QueryException($exception, $query);
    }

    /**
     * Convert DateTime object into local database representation. Driver will automatically force
     * needed timezone.
     *
     * @param \DateTimeInterface $value
     * @return string
     */
    protected function normalizeTimestamp(\DateTimeInterface $value): string
    {
        //Immutable and prepared??
        $datetime = new \DateTime('now', $this->getTimezone());
        $datetime->setTimestamp($value->getTimestamp());

        return $datetime->format(static::DATETIME);
    }
}