<?php

namespace App\Console\Commands;

use App\Enums\PageStatus;
use App\Model\Page;
use Illuminate\Console\Command;

class UpdatePageStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:update-page-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update page status according to schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $numbersOfAffectedPage = Page::expired()->published()->update([
            'status' => PageStatus::Expired
        ]);

        $this->info('Updated Page: ' . $numbersOfAffectedPage);
    }
}
