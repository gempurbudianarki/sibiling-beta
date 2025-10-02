<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportLegacyDataSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('sql/data_final.sql');
        $sql  = File::get($path);

        // Normalisasi line endings
        $sql = str_replace("\r\n", "\n", $sql);

        // 1) Bersihin tanggal invalid
        $sql = preg_replace("/'0000-00-00\s+\d{2}:\d{2}:\d{2}'/m", "NULL", $sql);
        $sql = str_replace("'0000-00-00'", "NULL", $sql);

        // 2) Bersihin nilai kosong di kolom angka → NULL
        $sql = preg_replace("/, ''(,|\))/", ", NULL$1", $sql);

        // 3) Default password dosen kalau kosong, hanya untuk kolom pswd_dos (kolom kedua)
        $defaultHash = password_hash('password123', PASSWORD_BCRYPT);

        // 4) Bersihkan nilai '-' di kolom id_prodi dosen (kolom ke-11)
        $defaultIdProdi = 'NULL'; // Replace with NULL for integer columns

        // Replace the two fragile callbacks with a single robust processor for multi-row VALUES(...)
        $sql = preg_replace_callback(
            "/INSERT INTO `dosen`([^;]+);/m",
            function ($matches) use ($defaultHash) {
                $block = $matches[0]; // whole INSERT ...; block

                // Find the VALUES block (everything from VALUES to the end of this statement)
                if (!preg_match('/VALUES\s*(.+)$/is', $block, $vm)) {
                    return $block;
                }
                // keep the exact substring captured so we can replace it safely without regex
                $valuesBlock = $vm[1]; // e.g. "(...),(...),(...)" possibly spanning lines

                // Match each parenthesized tuple while allowing quoted strings inside
                preg_match_all('/\((?:[^()\'"]+|\'(?:\\\\.|[^\'])*\'|"(?:\\\\.|[^"])*")*\)/s', $valuesBlock, $tupleMatches);
                if (empty($tupleMatches[0])) {
                    return $block;
                }

                // helper to split values on commas not inside quotes
                $splitRespectingQuotes = function (string $s): array {
                    $values = [];
                    $current = '';
                    $len = strlen($s);
                    $inQuote = null;
                    for ($i = 0; $i < $len; $i++) {
                        $ch = $s[$i];
                        if ($inQuote !== null) {
                            // inside quoted string
                            $current .= $ch;
                            if ($ch === $inQuote) {
                                // check for escaped quote (backslash)
                                $backslashes = 0;
                                $j = $i - 1;
                                while ($j >= 0 && $s[$j] === '\\') { $backslashes++; $j--; }
                                if ($backslashes % 2 === 0) {
                                    // not escaped
                                    $inQuote = null;
                                }
                            }
                        } else {
                            if ($ch === "'" || $ch === '"') {
                                $inQuote = $ch;
                                $current .= $ch;
                            } elseif ($ch === ',') {
                                $values[] = $current;
                                $current = '';
                            } else {
                                $current .= $ch;
                            }
                        }
                    }
                    $values[] = $current;
                    return $values;
                };

                $newTuples = [];
                foreach ($tupleMatches[0] as $tuple) {
                    // strip surrounding parentheses
                    $inner = substr($tuple, 1, -1);
                    $cols = $splitRespectingQuotes($inner);

                    // Trim values while preserving quotes when reassembling
                    // 1) pswd_dos is column index 1 (second column)
                    if (isset($cols[1])) {
                        $trimmed = trim($cols[1]);
                        if ($trimmed === "''" || $trimmed === '' || strtoupper($trimmed) === 'NULL') {
                            $cols[1] = "'" . $defaultHash . "'";
                        }
                    }

                    // 2) id_prodi is column index 10 (11th column)
                    if (isset($cols[10])) {
                        $val = trim($cols[10]);
                        // treat '-' or '' as invalid for integer column => NULL (no quotes)
                        if ($val === "'-'" || $val === '-' || $val === "''") {
                            $cols[10] = 'NULL';
                        }
                    }

                    // Rebuild tuple
                    $newTuples[] = '(' . implode(',', $cols) . ')';
                }

                $newValuesBlock = implode(',', $newTuples);
                // Replace the old values block (first occurrence) with the new one using a safe substring replace
                $pos = strpos($block, $valuesBlock);
                if ($pos !== false) {
                    $block = substr_replace($block, $newValuesBlock, $pos, strlen($valuesBlock));
                }

                return $block;
            },
            $sql
        );

        DB::beginTransaction();
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Longgarkan stat_mhs dulu
            DB::statement("ALTER TABLE mahasiswa MODIFY stat_mhs VARCHAR(5) NULL");

            // Import SQL
            DB::unprepared($sql);

            // Mapping huruf → angka
            DB::statement("
                UPDATE mahasiswa
                SET stat_mhs = CASE UPPER(stat_mhs)
                    WHEN 'A' THEN '1'
                    WHEN 'N' THEN '0'
                    WHEN 'R' THEN '2'
                    WHEN 'L' THEN '3'
                    ELSE stat_mhs
                END
                WHERE stat_mhs IS NOT NULL
                  AND stat_mhs REGEXP '^[A-Za-z]+$';
            ");

            // Bersihin last_login / last_active bodong
            DB::statement("UPDATE dosen SET last_login=NULL WHERE last_login='0000-00-00 00:00:00'");
            DB::statement("UPDATE dosen SET last_active=NULL WHERE last_active='0000-00-00 00:00:00'");

            // Balikin stat_mhs ke integer
            DB::statement("ALTER TABLE mahasiswa MODIFY stat_mhs TINYINT UNSIGNED NULL");

            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            throw $e;
        }
    }
}
