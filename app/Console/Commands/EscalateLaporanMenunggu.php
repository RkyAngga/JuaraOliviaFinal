<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EscalateLaporanMenunggu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:escalate-laporan-menunggu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $laporans = \App\Models\LaporanPengaduan::where('status', 'Menunggu')
            ->where('waktu_menunggu_expired', '<', now())
            ->where('escalated_to_pusat', 0)
            ->get();

        foreach ($laporans as $laporan) {
            $laporan->escalated_to_pusat = 1;
            $laporan->save();
            // Tambahkan tracking jika perlu
        }
    }
}
