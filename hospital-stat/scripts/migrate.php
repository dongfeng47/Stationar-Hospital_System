<?php
require_once __DIR__ . '/../config/database.php';

try {
    echo "Выполняется миграция...\n";

   
    $migrateFile = __DIR__ . '/../SQL/migrate.sql';
    if (file_exists($migrateFile)) {
        $pdo->exec(file_get_contents($migrateFile));
        echo "Таблицы успешно созданы.\n";
    } else {
        echo "Файл migrate.sql не найден!\n";
    }

   
    $seedFile = __DIR__ . '/../SQL/seed.sql';
    if (file_exists($seedFile)) {
        $pdo->exec(file_get_contents($seedFile));
        echo "Тестовые данные успешно добавлены.\n";
    } else {
        echo "Файл seed.sql не найден! Пропускаем добавление данных.\n";
    }

    echo "Миграция завершена успешно!\n";

   
    echo "Откройте проект в браузере: http://localhost/hospital-stat/\n";

} catch (PDOException $e) {
    echo "Ошибка миграции: " . $e->getMessage() . "\n";
}
