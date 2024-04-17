<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BooksInGenreCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $countGenres = DB::table('libgenrelist')->count();
        $lastGenreId = DB::table('libgenrelist')->max('GenreId');
        Log::info("Задание выполнено!");
        Log::info("всего записей в таблице ". $lastGenreId);


        for ($i = 1; $i <= $lastGenreId; $i++) {

            $countBooksInGenre = DB::table('libgenre')
                ->where('GenreId', $i)
                ->count();

            DB::table('libgenrelist')
                ->where('GenreId', $i)
                ->update(['count' => $countBooksInGenre]);

            Log::info('всего записей с жанром = '. $i .' = '. $countBooksInGenre);
        }

    }
}
