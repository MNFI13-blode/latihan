<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserSyncService;

class SyncUsersFromApi extends Command
{
    // ================= COMMAND CONFIG =================
    protected $signature = 'sync:users';
    protected $description = 'Sync users from API';

    public function handle(UserSyncService $service)
    {
        // ================= START SYNC =================
        $this->info('Syncing users...');
        try {
            // Panggil service untuk sync data
            $result = $service->sync();
            // Tampilkan hasil di console
            $this->info("✅ Sync berhasil!");
            $this->line("Created: {$result['created']}");
            $this->line("Updated: {$result['updated']}");
            $this->line("Total API: {$result['total']}");
            $this->line("Last Sync: {$result['last_sync']}");
        } catch (\Exception $e) {
            // Tampilkan error di console
            $this->error("❌ Error: " . $e->getMessage());
        }
    }
}