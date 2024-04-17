<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function dashboard()
    {
        SEOTools::setTitle(config('seo.dashboard.title'));
        SEOTools::setDescription(config('seo.dashboard.title'));
        SEOTools::opengraph()->setUrl(config('seo.dashboard.og_url'));
        SEOTools::setCanonical(route('dashboard'));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.dashboard.twitter_title'));

        return view('profile.dashboard');
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        SEOTools::setTitle(config('seo.edit.title'));

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function readNow()
    {
        SEOTools::setTitle(config('seo.read_now.title'));

        $user = request()->user();

        $bookIds = DB::table('bookstatus')
            ->where('user_id', $user->id)
            ->where('status', 2)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();

        $books = $this->getBooks($bookIdsToArray);


        return view('profile.readnow', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function wantToRead()
    {
        SEOTools::setTitle(config('seo.want_to_read.title'));

        $user = request()->user();

        $bookIds = DB::table('bookstatus')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();

        $books = $this->getBooks($bookIdsToArray);

        return view('profile.want_to_read', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function completed()
    {
        SEOTools::setTitle(config('seo.completed.title'));

        $user = request()->user();

        $bookIds = DB::table('bookstatus')
            ->where('user_id', $user->id)
            ->where('status', 3)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();

        $books = $this->getBooks($bookIdsToArray);

        return view('profile.completed', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function uncompleted()
    {
        SEOTools::setTitle(config('seo.uncompleted.title'));


        $user = request()->user();

        $bookIds = DB::table('bookstatus')
            ->where('user_id', $user->id)
            ->where('status', 4)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();

        $books = $this->getBooks($bookIdsToArray);

        return view('profile.uncompleted', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function liked()
    {
        SEOTools::setTitle(config('seo.liked.title'));


        $user = request()->user();

        $bookIds = DB::table('bookslikes')
            ->where('user_id', $user->id)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();
        $books = $this->getBooks($bookIdsToArray);
//        dd($books);

        return view('profile.liked', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function starred()
    {
        SEOTools::setTitle(config('seo.starred.title'));

        $user = request()->user();

        $bookIds = DB::table('librate')
            ->where('UserIdNew', $user->id)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('BookId')->toArray();
        $books = $this->getBooks($bookIdsToArray);

        return view('profile.starred', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);
    }

    public function commented()
    {
        SEOTools::setTitle(config('seo.commented.title'));

        $user = request()->user();

        $bookIds = DB::table('libreviews')
            ->where('user_id', $user->id)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('BookId')->toArray();
        $books = $this->getBooks($bookIdsToArray);

        return view('profile.commented', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);


    }

    public function downloaded()
    {
        SEOTools::setTitle(config('seo.downloaded.title'));

        $user = request()->user();

        $bookIds = DB::table('downloads')
            ->where('user_id', $user->id)
            ->paginate(10);

        $bookIdsToArray = $bookIds->pluck('book_id')->toArray();
        $books = $this->getBooks($bookIdsToArray);



        return view('profile.downloaded', [
            'user' => $user,
            'books' => $books,
            'pagination' => $bookIds
        ]);

    }
}
