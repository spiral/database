<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Database\Tests\Driver\SQLServer;

/**
 * @group driver
 * @group driver-sqlserver
 */
class ForeignKeysTest extends \Spiral\Database\Tests\ForeignKeysTest
{
    public const DRIVER = 'sqlserver';
}
