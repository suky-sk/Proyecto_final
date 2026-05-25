<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class ConcesionarioDumpSeeder extends Seeder
{
    private const INSERT_ORDER = ['marca', 'usuario', 'coche', 'coche_usuario'];
    private const TRUNCATE_ORDER = ['coche_usuario', 'coche', 'usuario', 'marca'];

    public function run(): void
    {
        $dumpPath = database_path('seeders/data/concesionario.sql');

        if (! is_file($dumpPath)) {
            throw new RuntimeException("No se encontro el dump de datos: {$dumpPath}");
        }

        $statements = $this->extractInsertStatements(file_get_contents($dumpPath));
        $driver = DB::connection()->getDriverName();

        $this->withoutForeignKeyChecks($driver, function () use ($statements, $driver): void {
            foreach (self::TRUNCATE_ORDER as $table) {
                DB::table($table)->truncate();
            }

            foreach (self::INSERT_ORDER as $table) {
                foreach ($statements[$table] as $statement) {
                    DB::unprepared($statement);
                }
            }

            if ($driver === 'mysql') {
                $this->resetAutoIncrementValues();
            }
        });
    }

    /**
     * Extract only app data INSERTs from the phpMyAdmin dump.
     */
    private function extractInsertStatements(string $sql): array
    {
        $statements = array_fill_keys(self::INSERT_ORDER, []);
        $currentTable = null;
        $buffer = [];

        foreach (preg_split('/\r\n|\n|\r/', $sql) as $line) {
            if ($currentTable === null) {
                if (preg_match('/^INSERT INTO `([^`]+)`/', $line, $matches)
                    && in_array($matches[1], self::INSERT_ORDER, true)) {
                    $currentTable = $matches[1];
                    $buffer = [$line];
                }

                continue;
            }

            $buffer[] = $line;

            if (preg_match('/;\s*$/', $line)) {
                $statements[$currentTable][] = implode(PHP_EOL, $buffer);
                $currentTable = null;
                $buffer = [];
            }
        }

        foreach (self::INSERT_ORDER as $table) {
            if ($statements[$table] === []) {
                throw new RuntimeException("El dump no contiene datos para la tabla {$table}.");
            }
        }

        return $statements;
    }

    private function withoutForeignKeyChecks(string $driver, callable $callback): void
    {
        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } else {
            Schema::disableForeignKeyConstraints();
        }

        try {
            $callback();
        } finally {
            if ($driver === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } else {
                Schema::enableForeignKeyConstraints();
            }
        }
    }

    private function resetAutoIncrementValues(): void
    {
        foreach (self::INSERT_ORDER as $table) {
            $nextId = ((int) DB::table($table)->max('id')) + 1;
            DB::statement("ALTER TABLE `{$table}` AUTO_INCREMENT = {$nextId}");
        }
    }
}
