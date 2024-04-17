<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateBooksInGenreCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-books-in-genre-count';

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
        \App\Jobs\BooksInGenreCount::dispatch();
        $this->info('BooksInGenreCount has been dispatched.');
    }
}
