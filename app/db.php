<?php
function db(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        global $config;
        $d = $config['db'];
        $dsn = "mysql:host={$d['host']};port={$d['port']};dbname={$d['name']};charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $d['user'], $d['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            $detail = $config['debug'] ? htmlspecialchars($e->getMessage()) : '';
            exit("<h1>Database is not reachable</h1><p>Check that MySQL is running and the settings in config/config.php are correct.</p><p>$detail</p>");
        }
    }
    return $pdo;
}

/** Run a prepared query and return the statement. */
function q(string $sql, array $params = []): PDOStatement
{
    $st = db()->prepare($sql);
    $st->execute($params);
    return $st;
}
