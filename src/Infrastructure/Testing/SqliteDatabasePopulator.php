<?php declare(strict_types=1);

/*
 * This file is part of the CVeeHub application.
 *
 * © Stefan Petcu <contact@stefanpetcu.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace CVeeHub\Infrastructure\Testing;

use PDO;
use PDOStatement;

class SqliteDatabasePopulator
{
    private const INSERT_STATEMENT = 'INSERT INTO %s (%s) VALUES (%s);';

    private $pdo;

    private $table;

    /** @var  array */
    private $data;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        // Display exceptions.
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function setTable(string $table)
    {
        $this->table = $this->backQuote($table);

        return $this;
    }

    /**
     * @param array $data an array with the format [colName => colValue, ...]
     *
     * @return SqliteDatabasePopulator
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function save(): bool
    {
        $statement = $this->pdo->prepare($this->insertQueryString());

        $this->bindParams($statement);

        return $statement->execute();
    }

    private function bindParams(PDOStatement $statement)
    {
        foreach ($this->data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
    }

    private function insertQueryString(): string
    {
        return sprintf(self::INSERT_STATEMENT, $this->table, $this->columnsNames(), $this->valuesPlaceholders());
    }

    /**
     * Returns a string containing the quoted column names of the table.
     */
    private function columnsNames(): string
    {
        return implode(
            ', ',
            array_map(
                function (string $colName): string {
                    return $this->backQuote($colName);
                },
                array_keys($this->data)
            )
        );
    }

    /**
     * Returns a string containing the placeholders for the INSERT-ed values.
     */
    private function valuesPlaceholders(): string
    {
        return implode(
            ', ',
            array_map(
                function (string $colName): string {
                    return ":$colName";
                },
                array_keys($this->data)
            )
        );
    }

    /**
     * Adds back quotes around the thing.
     *
     * @param mixed $thing
     *
     * @return string
     */
    private function backQuote($thing): string
    {
        return $thing;
    }
}
