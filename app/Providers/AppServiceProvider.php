<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        View::composer(['layouts.app', 'profile.want_to_read'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $wantToReadCount = DB::table('bookstatus')
                    ->where('user_id', $userId)
                    ->where('status', 1)
                    ->count();

                $view->with('wantToReadCount', $wantToReadCount);
            }
        });

        View::composer(['layouts.app', 'profile.readnow'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $readingNowCount = DB::table('bookstatus')
                    ->where('user_id', $userId)
                    ->where('status', 2)
                    ->count();

                $view->with('readingNowCount', $readingNowCount);
            }
        });

        View::composer(['layouts.app', 'profile.completed'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $finishedBooksCount = DB::table('bookstatus')
                    ->where('user_id', $userId)
                    ->where('status', 3)
                    ->count();

                $view->with('finishedBooksCount', $finishedBooksCount);
            }
        });

        View::composer(['layouts.app', 'profile.uncompleted'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $notFinishedBooksCount = DB::table('bookstatus')
                    ->where('user_id', $userId)
                    ->where('status', 4)
                    ->count();

                $view->with('notFinishedBooksCount', $notFinishedBooksCount);
            }
        });

        View::composer(['layouts.app', 'profile.liked'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $likedBooksCount = DB::table('bookslikes')
                    ->where('user_id', $userId)
                    ->count();

                $view->with('likedBooksCount', $likedBooksCount);
            }
        });

        View::composer(['layouts.app', 'profile.starred'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $starredBooksCount = DB::table('librate')
                    ->where('UserIdNew', $userId)
                    ->count();

                $view->with('starredBooksCount', $starredBooksCount);
            }
        });

        View::composer(['layouts.app', 'profile.commented'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $commentedBooksCount = DB::table('libreviews')
                    ->where('user_id', $userId)
                    ->count();

                $view->with('commentedBooksCount', $commentedBooksCount);
            }
        });

        View::composer(['layouts.app', 'profile.downloaded'], function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $downloadedBooksCount = DB::table('downloads')
                    ->where('user_id', $userId)
                    ->count();

                $view->with('downloadedBooksCount', $downloadedBooksCount);
            }
        });

    }
}
