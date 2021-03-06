CHANGELOG
======================

v2.7.20 (20.11.2020)
-----
- [bugfix] invaliding spacing while using Fragments in JOIN ON statements by @iamsaint
- [bugfix] disable parameter registration when value is Fragment by @thenotsoft

v2.7.19 (10.11.2020)
-----
- added the ability to pass parameters into fragments
- added the ability to use fragments and expressions as part of select query columns

v2.7.18 (14.10.2020)
-----
- added the ability to fetch data as StdClass by @guilhermeaiolfi

v2.7.17 (02.09.2020)
-----
- added the ability to modify the database logger context by @Alexsisukin
- added distinctOn method to Postgres Select Query

v2.7.16 (28.08.2020)
-----
- fixes bug with invalid transaction level when transaction can't be started
- set isolation level after beginning the transaction for Postgres

v2.7.15 (17.06.2020)
-----
- handle Docker specific connection exceptions (broken pipe)

v2.7.14 (23.04.2020)
-----
- fixed bug with invalid compilation of multi-group-by statements by @yiiliveext

v2.7.13 (04.04.2020)
-----
- improved legacy config resolution (invalid `options` parsing)

v2.7.12 (31.03.2020)
-----
- default `json` type for Postgres fallbacks to text to unify with other drivers

v2.7.11 (12.03.2020)
-----
- Add PostgreSQL `timestamptz` mapping for `timestamp with time zone` by @rauanmayemir

v2.7.10 (18.02.2020)
-----
- catch postgres EOF exceptions on amazon as connection exception

v2.7.9 (18.02.2020)
-----
- added the ability to pass parameters into Expression in operators and values

v2.7.8 (18.02.2020)
-----
- added the ability to pass parameters into Expression

v2.7.7 (11.02.2020)
-----
- minor refactor in PostgresInsertQuery

v2.7.6 (07.02.2020)
-----
- added the support to force the returning key in Postgres insert queries

v2.7.5 (03.02.2020)
-----
- [bugfix] fixed invalid index introspection on legacy SQLite drivers

v2.7.4 (30.01.2020)
-----
- [bugfix] fixed `syncTable` behavious for SQLite tables with sorted indexes @rauanmayemir

v2.7.3 (29.01.2020)
-----
- added the ability to specify index direction by @rauanmayemir

v2.7.2 (18.01.2020)
-----
- [bugfix] invalid size detection for int, bigint, tinyint columns under latest MySQL 8.0+

2.7.1 (14.01.2020)
-----
- added AbstractColumn::getSize() typecasting
- added the ability to serialize and de-serialize fragments and expressions

2.7.0 (13.01.2020)
-----
- added sql compiler caching, up to 5x times faster query generation
- added prepared statement caching
- refactor of SchemaHandler
- refactor of Query builders
- added ComparatorInterface
- deprecated MySQL 5.5 support

2.6.10 (26.12.2019)
-----
- [bugfix] invalid change detection for nullable and zeroed default values
- do not allow default values for text and blob columns of MySQL

2.6.9 (26.12.2019)
-----
- added support for Postgres 12 updated constrain schemas

2.6.8 (24.12.2019)
-----
- [bufgix] proper abstract type detection for primary UUID columns for SQLite driver

2.6.7 (23.12.2019)
-----
- [bufgix] proper exception type for syntax errors in MariaDB (previously was ConnectionException)

2.6.6 (11.12.2019)
-----
- allow drivers to handle low level error exceptions
- qualify "Connection reset by peer" as connection exception
- fixed interpolation of named parameters

2.6.5 (11.12.2019)
-----
- added support for SELECT FOR UPDATE statements

2.6.4 (21.11.2019)
-----
- disabled int typecasting for aggregate selections
- minor inspection driven improvements

2.6.3 (20.11.2019)
-----
- improved connection exception handling for Postgres

2.6.2 (14.11.2019)
-----
- added native support for UUID type

2.6.1 (05.11.2019)
-----
- force the database disconned in case of connection error

2.6.0 (08.10.2019)
-----
- minimum PHP version is set as 7.2
- added internal method to get declared column type
- added support for `jsonb` in Postgres driver

2.5.1 (14.09.2019)
-----
- statement cache is turned off by default
- cacheStatement flag can be passed from Database

2.5.0 (14.09.2019)
-----
- Drivers now able to reuse prepared statements inside the transaction scope
- minor performance improvemenet on larger transactions

2.4.5 (28.08.2019)
-----
- improved SQLite multi-insert query fallback
- all query builders can be used without driver as standalone objects
- memory and performance optimizations for query builders
- simplified parameter flattening logic, parameters are now assembled via compiler

2.4.2 (26.08.2019)
-----
- IS NULL and IS NOT NULL normalized across all database drivers

2.4.1 (13.08.2019)
-----
- CS: @invisible renamed to @internal

2.4.0 (29.07.2019)
-----
- added support for composite FKs

2.3.1 (15.07.2019)
-----
- handle MySQL server has gone away messages when PDO exception code is invalid

2.3.0 (10.05.2019)
-----
- the Statement class has been decoupled from PDO

2.2.5 (08.05.2019)
-----
- proper table alias resolution when the joined table name is similar to the alias of another table

2.2.3 (24.04.2019)
-----
- PSR-12
- added incomplete sort for Reflector

2.2.2 (16.04.2019)
-----
- added DatabaseProviderInterface

2.2.1 (08.04.2019)
-----
- extended syntax for IS NULL and NOT NULL for SQLite

2.2.0 (29.04.2019)
-----
- drivers can now automatically reconnect in case of connection interruption

2.1.8 (21.02.2019)
-----
- phpType method renamed to getType
- getType renamed to getInternalType

2.1.7 (11.02.2019)
-----
- simpler pagination logic
- simplified pagination interfaces
- simplified logger interfaces
- less dependencies

2.0.0 (21.09.2018)
-----
- massive refactor
- decoupling from Spiral\Component
- no more additional dependencies on ContainerInterface
- support for read/write database connections
- more flexible configuration
- less dependencies between classes
- interfaces have been exposed for table, column, index and foreignKeys
- new interface for driver, database, table, compiler and handler
- immutable quoter
- more tests
- custom exceptions for connection and constrain exceptions

1.0.1 (15.06.2018)
-----
- MySQL driver can reconnect now

1.0.0 (02.03.2018)
-----
* Improved handling of renamed indexes associated with renamed columns

0.9.1 (07.02.2017)
-----
* Pagination split into separate package

0.9.0 (03.02.2017)
-----
* DBAL, Pagination and Migration component split from component repository
