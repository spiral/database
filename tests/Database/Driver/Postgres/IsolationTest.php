<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Database\Tests\Driver\Postgres;

/**
 * @group driver
 * @group driver-postgres
 */
class IsolationTest extends \Spiral\Database\Tests\IsolationTest
{
    public const DRIVER = 'postgres';
}
