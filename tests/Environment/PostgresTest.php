<?php
declare(strict_types=1);

namespace Tests\Environment;

use PDO;
use PHPUnit\Framework\TestCase;

class PostgresTest extends TestCase
{
    public function test_connect_to_postgresql_with_pdo()
    {
        $db_host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_DATABASE'];
        $db_user = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];

        $pdo = new PDO(
            "pgsql:host=" . $db_host . ";dbname=" . $db_name . ";",
            $db_user,
            $db_password
        );
        $this->assertInstanceOf(PDO::class, $pdo);
    }
}
