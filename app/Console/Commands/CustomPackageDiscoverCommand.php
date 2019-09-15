<?php

namespace App\Console\Commands;

use App\Bootstrap\PackageManifest;
use Illuminate\Console\Command;

class CustomPackageDiscoverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:discover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild the cached package manifest';

    /**
     * Execute the console command.
     *
     * @param \App\Bootstrap\PackageManifest $manifest
     * @return void
     */
    public function handle(PackageManifest $manifest)
    {
        $manifest->build();

        foreach (array_keys($manifest->manifest) as $package) {
            $this->line("Discovered Package: <info>{$package}</info>");
        }

        $this->info('Package manifest generated successfully.');
    }
}
