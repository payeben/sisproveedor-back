<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup de la base de datos';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Configuración
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $backupPath = storage_path('backups');
        $fileName = 'backup-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';

        // Crear el directorio de backups si no existe
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Comando para realizar el backup
        $command = "mysqldump -h {$dbHost} -u {$dbUser} " . ($dbPass ? "-p'{$dbPass}' " : "") . "{$dbName} > {$backupPath}/{$fileName}";

        $result = null;
        $output = null;
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("Backup creado exitosamente: {$fileName}");
        } else {
            $this->error("Error al crear el backup.");
        }
    }
}
