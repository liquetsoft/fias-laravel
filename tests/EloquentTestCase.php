<?php

declare(strict_types=1);

namespace Liquetsoft\Fias\Laravel\LiquetsoftFiasBundle\Tests;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

/**
 * Базовый класс для всех тестов, которые используют базу данных.
 */
abstract class EloquentTestCase extends BaseCase
{
    /**
     * @var Manager|null
     */
    private static $capsule = null;

    /**
     * СОздает новое соединение с базой данных для eloquent.
     */
    public static function setUpBeforeClass(): void
    {
        $capsule = new Manager();
        $capsule->addConnection(
            [
                'driver' => getenv('DB_DRIVER'),
                'host' => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'database' => getenv('DB_NAME'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => '',
            ]
        );
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        DB::swap($capsule);
    }

    /**
     * Проверяет, что в указанной таблице есть строка с указанными колонками.
     *
     * @param string $table
     * @param array  $fields
     */
    public function assertDatabaseHasRow(string $table, array $fields): void
    {
        $message = sprintf(
            "Can't find '%s' row in '%s' table.",
            json_encode($fields, \JSON_UNESCAPED_UNICODE),
            $table
        );

        $isRowExists = Manager::table($table)->where($fields)->exists();

        $this->assertThat($isRowExists, $this->isTrue(), $message);
    }

    /**
     * Проверяет, что в указанной таблице нет строки с указанными колонками.
     *
     * @param string $table
     * @param array  $fields
     */
    public function assertDatabaseDoesNotHaveRow(string $table, array $fields): void
    {
        $message = sprintf(
            "Row '%s' exists in '%s' table.",
            json_encode($fields, \JSON_UNESCAPED_UNICODE),
            $table
        );

        $isRowExists = Manager::table($table)->where($fields)->exists();

        $this->assertThat($isRowExists, $this->isFalse(), $message);
    }

    /**
     * Создает таблицу по указанным полям и имени.
     *
     * @param string  $tableName
     * @param array[] $columns
     */
    public function prepareTableForTesting(string $tableName, array $columns): void
    {
        Manager::schema()->dropIfExists($tableName);
        Manager::schema()->create(
            $tableName,
            function (Blueprint $table) use ($columns): void {
                foreach ($columns as $columnName => $columnDescription) {
                    $this->createColumn($table, $columnName, $columnDescription);
                }
            }
        );
    }

    /**
     * Создает тестовые данные в таблице.
     *
     * @param string  $tableName
     * @param array[] $rows
     */
    public function prepareDataForTesting(string $tableName, array $rows): void
    {
        Manager::table($tableName)->insert($rows);
    }

    /**
     * Создает колонку в таблице.
     *
     * @param Blueprint $table
     * @param string    $name
     * @param array     $description
     *
     * @throws InvalidArgumentException
     */
    private function createColumn(Blueprint $table, string $name, array $description): void
    {
        $type = $description['type'] ?? null;

        if ($type === 'integer') {
            $column = $table->unsignedInteger($name);
        } elseif ($type === 'datetime') {
            $column = $table->datetime($name);
        } else {
            $column = $table->string($name, (int) ($description['type'] ?? 255));
        }

        $column->nullable((bool) ($description['nullable'] ?? false));

        if (isset($description['default'])) {
            $column->default($description['default']);
        }

        if (!empty($description['primary'])) {
            $column->primary();
        } elseif (!empty($description['index'])) {
            $column->index();
        }
    }
}
