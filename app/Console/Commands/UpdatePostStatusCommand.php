<?php

namespace App\Console\Commands;

use App\Enums\PostStatus;
use App\Model\Post;
use Illuminate\Console\Command;

class UpdatePostStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:update-post-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update post status according to schedule';

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
        $numbersOfAffectedPost = Post::expired()->published()->update([
            'status' => PostStatus::Expired
        ]);

        $this->info('Updated Post: ' . $numbersOfAffectedPost);
    }
}
