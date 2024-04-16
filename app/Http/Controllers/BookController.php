<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{

    public function download($folder, $file, $bookId)
    {

        $userId = auth()->id();

        DB::table('downloads')->updateOrInsert(
            [
                'book_id' => $bookId, // Ключ поиска - book_id
                'user_id' => $userId  // Ключ поиска - user_id
            ],
            [
                'date' => Carbon::now() // Значение для обновления
            ]
        );

//        dd($bookId);
        $secret = 'secret123';
        $format = 'zip';
        $url = 'https://storagebk.com/books/download.php?archive=' . $folder . '&file=' . $file . '&secret=' . $secret . '&format=' . $format;


        $response = Http::get($url);

        if ($response->successful()) {
            // Генерация уникального имени файла для сохранения во временной директории
            $fileName = $file . '-' . uniqid() . '_book.zip';
            $filePath = 'downloads/' . $fileName; // Путь, по которому будет сохранен архив

            // Сохранение содержимого архива в файл
            Storage::disk('local')->put($filePath, $response->body());

            // Определение абсолютного пути к файлу
            $absolutePath = Storage::disk('local')->path($filePath);

            // Отправка файла на скачивание пользователю
            return response()->download($absolutePath, $fileName, ['Content-Type' => 'application/zip'])->deleteFileAfterSend(true);
        }


        // Если скачивание не удалось, возвращаем пользователя обратно с сообщением об ошибке
        return back()->with('error', 'Не удалось скачать файл.');

    }


    public function getAuthors($ids)
    {
        return DB::table('libavtorname')
            ->select('libavtorname.AvtorId', 'libavtorname.FirstName', 'libavtorname.MiddleName', 'libavtorname.LastName',
                DB::raw('(SELECT File FROM libapics WHERE libapics.AvtorId = libavtorname.AvtorId LIMIT 1) as File'),
                DB::raw('(SELECT Body FROM libaannotations WHERE libaannotations.AvtorId = libavtorname.AvtorId LIMIT 1) as Body'))
            ->whereIn('libavtorname.AvtorId', $ids)
            ->groupBy('libavtorname.AvtorId')
            ->orderBy('libavtorname.AvtorId', 'DESC')
            ->get();

//        return DB::table('libavtorname')
//            ->select('libavtorname.AvtorId', 'libavtorname.FirstName', 'libavtorname.MiddleName', 'libavtorname.LastName', 'libapics.File', 'libaannotations.Body')
//            ->whereIn('libavtorname.AvtorId', $ids)
//            ->orderBy('libavtorname.AvtorId', 'DESC')
//            ->leftJoin('libapics', 'libapics.AvtorId', '=', 'libavtorname.AvtorId')
//            ->leftJoin('libaannotations', 'libaannotations.AvtorId', '=', 'libavtorname.AvtorId')
//            ->get();
    }

    public function index()
    {

        SEOTools::setTitle(config('seo.index.title'));
        SEOTools::setDescription(config('seo.index.description'));
        SEOTools::opengraph()->setUrl(config('seo.index.og_url'));
        SEOTools::setCanonical(config('seo.index.url'));
        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.index.twitter_title'));
//        SEOTools::jsonLd()->addImage('https://codecasts.com.br/img/logo.jpg');

        $bookIds = DB::table('libbook')
            ->orderBy('BookId', 'desc')
            ->paginate(10, ['BookId']);

        $bookIdsToArray = $bookIds->pluck('BookId')->toArray();
//        dd($bookIdsToArray);
        $books = $this->getBooks($bookIdsToArray);

//        $comments = DB::table('libreviews')
//            ->leftJoin('libbook', 'libbook.BookId', '=', 'libreviews.BookId')
//            ->orderBy('id', 'desc')
//            ->limit(10)
//            ->get();

        $randomIds = [];
        $range = 682884;

        while (count($randomIds) < 10) {
            $randomIds[] = rand(1, $range);
            $randomIds = array_unique($randomIds);
        }

        $comments = DB::table('libreviews')
            ->leftJoin('libbook', 'libbook.BookId', '=', 'libreviews.BookId')
            ->whereIn('id', $randomIds)
            ->get();


//        dd($comments);

//        $totalBooks = DB::table('libbook')->count();

        return view('index', [
            'books' => $books,
            'pagination' => $bookIds,
            'comments' => $comments
        ]);
    }


    public function show($id)
    {


        $results = DB::table('libbook AS lb')
            ->select(
                'lb.BookId AS BookId',
                'lb.Title AS Title',
                'lb.Title1 AS Title1',
                'lb.Year AS BookYear',
                'lb.FileType AS FileType',
                'lb.Time AS Time',
                'lba.Body AS Description',
                'lgl.GenreDesc AS GenreDesc',
                'lgl.GenreMeta AS GenreMeta',
                'lgl.GenreCode AS GenreCode',
                'lgl.GenreId AS GenreId',
                'lbp.File AS BookImg',
                'ljb.realId AS RealId',
                'libfilename.FileName AS BookFileName',
                'f1.file AS BookFileNameReal1',
                'f1.folder AS BookFolderNameReal1',
                'f2.file AS BookFileNameReal2',
                'f2.folder AS BookFolderNameReal2',
                DB::raw('GROUP_CONCAT(DISTINCT la.AvtorId ORDER BY la.AvtorId) AS AvtorIds'),
                DB::raw('GROUP_CONCAT(DISTINCT lan.FirstName ORDER BY lan.AvtorId) AS FirstNames'),
                DB::raw('GROUP_CONCAT(DISTINCT lan.LastName ORDER BY lan.AvtorId) AS LastNames'),
                DB::raw('GROUP_CONCAT(DISTINCT lan.MiddleName ORDER BY lan.AvtorId) AS MiddleNames'),
                DB::raw('GROUP_CONCAT(DISTINCT lap.File) AS AuthorImages'),
                DB::raw('SUM(lr.rate) AS BookRatingsAll'),
                DB::raw('COUNT(lr.BookId) AS BookRatingsTotal'),
                DB::raw('AVG(lr.Rate) AS AverageRating'),
                DB::raw('SUM(lr.Rate = 5) AS BookRatings5'),
                DB::raw('SUM(lr.Rate = 4) AS BookRatings4'),
                DB::raw('SUM(lr.Rate = 3) AS BookRatings3'),
                DB::raw('SUM(lr.Rate = 2) AS BookRatings2'),
                DB::raw('SUM(lr.Rate = 1) AS BookRatings1'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(libseq.SeqId, ", ", libseq.SeqNumb, ", ", libseq.Level, ", ", libseq.Type, ", ", libseqname.SeqName) ORDER BY libseq.Type ASC SEPARATOR "; ") AS BookSeqAll'),
//                DB::raw('group_concat(DISTINCT CONCAT(lan.firstname, ",", lan.lastname, ",", lan.middlename, ",", lan.avtorid, ",", COALESCE(lap.file, "")) order by la.avtorid separator ";") AS Authors'),
//                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(lan.FirstName, ",", lan.LastName, ",", lan.MiddleName, ",", lan.AvtorId, ",", COALESCE((SELECT lap.File FROM libapics AS lap WHERE lap.AvtorId = lan.AvtorId ORDER BY lap.AvtorId LIMIT 1), "")) ORDER BY lan.AvtorId SEPARATOR ";") AS Authors'),
                DB::raw('GROUP_CONCAT(DISTINCT CONCAT(lan.FirstName, ",", lan.LastName, ",", lan.MiddleName, ",", lan.AvtorId, ",", COALESCE((SELECT lap.File FROM libapics AS lap WHERE lap.AvtorId = lan.AvtorId ORDER BY lap.AvtorId LIMIT 1), "")) ORDER BY la.Pos SEPARATOR ";") AS Authors'),

            )
            ->leftJoin('libbannotations AS lba', 'lb.BookId', '=', 'lba.BookId')
            ->leftJoin('libgenre AS lg', 'lb.BookId', '=', 'lg.BookId')
            ->leftJoin('libgenrelist AS lgl', 'lg.GenreId', '=', 'lgl.GenreId')
            ->leftJoin('libbpics AS lbp', 'lbp.BookId', '=', 'lb.BookId')
            ->leftJoin('libavtor AS la', 'lb.BookId', '=', 'la.BookId')
            ->leftJoin('libavtorname AS lan', 'la.AvtorId', '=', 'lan.AvtorId')
            ->leftJoin('librate AS lr', 'lb.BookId', '=', 'lr.BookId')
            ->leftJoin('libapics AS lap', 'lap.AvtorId', '=', 'la.AvtorId')
            ->leftJoin('libjoinedbooks AS ljb', 'ljb.BadId', '=', 'lb.BookId')
            ->leftJoin('libseq', 'libseq.BookId', '=', 'lb.BookId')
            ->leftJoin('libseqname', 'libseqname.SeqId', '=', 'libseq.SeqId')
            ->leftJoin('libfilename', 'libfilename.BookId', '=', 'lb.BookId')
            ->leftJoin('files as f1', 'f1.file', '=', 'libfilename.FileName')
            ->leftJoin('files as f2', 'f2.file', '=', DB::raw("'" . $id . ".fb2'"))
            ->where('lb.BookId', $id)
//            ->groupBy(
//                'lb.BookId',
//                'lba.Body',
//                'lgl.GenreDesc',
//                'lgl.GenreMeta',
//                'lbp.File',
//                'lap.file'
//            )
//            ->groupBy('lb.BookId')
            ->groupBy(
                'lb.BookId',
                'lba.Body',
                'lgl.GenreDesc',
                'lgl.GenreMeta',
                'lbp.File',
                'f1.folder',
                'f2.folder',
                'lgl.GenreCode',
                'lgl.GenreId'
//                'lap.file'
            )
            ->get();


        $bookTitle = $results[0]->Title ?? '';

        $authorLastName = explode(',', $results[0]->LastNames)[0];
        $authorFirstName = explode(',', $results[0]->FirstNames)[0];
        $authorMiddleName = explode(',', $results[0]->MiddleNames)[0];

        $bookAuthor = $authorLastName . ' ' . $authorFirstName . ' ' . $authorMiddleName;

        $placeholders = ['[название]', '[автор]'];
        $replaceValues = [$bookTitle, $bookAuthor];

        SEOTools::setTitle(str_replace($placeholders, $replaceValues, config('seo.book.title')));
        SEOTools::setDescription(str_replace($placeholders, $replaceValues, config('seo.book.description')));
        SEOTools::opengraph()->setUrl(route('book', $results[0]->BookId));
        SEOTools::setCanonical(route('book', $results[0]->BookId));
        SEOTools::opengraph()->addProperty('type', 'article');
        SEOTools::twitter()->setSite(str_replace($placeholders, $replaceValues, config('seo.book.twitter_title')));

//        https://storagebk.com/books/download.php?archive=
//        d.fb2-009373-367300.zip&
//        file=367271.fb2&
//        secret=secret123&
//        format=zip


        $comments = DB::select("
        SELECT * FROM `flibusta`.`libreviews`
         WHERE `BookId` = :id ORDER BY Time DESC LIMIT 300 OFFSET 0
         ", [
            ':id' => $id
        ]);
//        dd($comments);
//        $comments->Time = (Carbon::parse($comments->Time));

        $userId = auth()->id(); // Получаем идентификатор текущего пользователя


        $bookStatus = DB::table('bookstatus')
            ->where('user_id', $userId)
            ->where('book_id', $id)
            ->first();

        $bookLiked = DB::table('bookslikes')
            ->where('user_id', $userId)
            ->where('book_id', $id)
            ->exists(); // Проверяем, существует ли запись "like"

        $stared = DB::table('librate')
            ->where('BookId', $id)
            ->where('UserIdNew', $userId)
            ->first();

        if (isset($stared->date)) {
            $stared->date = (Carbon::parse($stared->date));
        }

//        dd($results[0]);
//        dd($stared);
        return view('book', [
            'book' => $results[0],
            'comments' => $comments,
            'bookStatus' => $bookStatus,
            'bookLiked' => $bookLiked,
            'stared' => $stared
        ]);


    }

    public function search()
    {

        $search = request()->search;

        if (request()->get('area') === 'book') {
            $searchResults = $this->findBook($search);
        } elseif (request()->get('area') === 'author') {
            $searchResults = $this->findAuthor($search);
        } elseif (request()->get('area') === 'series') {
            $searchResults = $this->findSeries($search);
        } elseif (request()->get('area') === 'genre') {
            $searchResults = $this->findGenres($search);

        }

        SEOTools::setTitle(str_replace('[название]', $search, config('seo.search.title')));
        SEOTools::setDescription(str_replace('[название]',$search, config('seo.search.description')));
        SEOTools::opengraph()->setUrl(config('seo.search.og_url'));
        SEOTools::setCanonical(route('search'));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.search.twitter_title'));


        return view('search', [
            'results' => $searchResults,
        ]);

    }

    public function findBook($search)
    {
        return Book::whereRaw("MATCH(Title) AGAINST(? IN BOOLEAN MODE)", [$search])
            ->orderByRaw("MATCH(Title) AGAINST(? IN BOOLEAN MODE) DESC", [$search])
            ->take(100)
            ->paginate(10);
    }

    public function findAuthor($search)
    {
        return DB::table('libavtorname')
            ->whereRaw("MATCH (FirstName, MiddleName, LastName) AGAINST (? IN BOOLEAN MODE)", [$search])
            ->paginate(50);

    }

    public function findSeries($search)
    {

        return DB::table('libseqname')
            ->whereRaw("BINARY `SeqName` LIKE ?", ["%{$search}%"])
            ->paginate(50);
    }

    public function findGenres($search)
    {
        return DB::table('libgenrelist')
            ->where('GenreDesc', 'LIKE', '%' . $search . '%')
            ->paginate(50);
    }

    public function genres()
    {
        SEOTools::setTitle(config('seo.genres.title'));
        SEOTools::setDescription(config('seo.genres.description'));
        SEOTools::opengraph()->setUrl(config('seo.genres.og_url'));
        SEOTools::setCanonical(route('genres'));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.genres.twitter_title'));

        $genres = DB::table('libgenrelist')
            ->select('GenreMeta', 'GenreDesc', 'GenreCode', 'GenreId', 'count')
            ->orderBy('GenreMeta')
            ->orderBy('GenreDesc')
            ->get()
            ->groupBy('GenreMeta');

        return view('genres', [
            'genres' => $genres
        ]);
    }

    public function genre($genreId)
    {


//        $paginatedBooks = DB::table('libgenre')
//            ->select('libgenre.BookId', 'libgenre.GenreId', 'libbook.Title', 'libbook.FileType', 'libbook.Year', 'libbook.Lang', 'libbook.Pages', 'libbook.Chars',
//                'libbook.Modified', 'libbannotations.Body')
//            ->where('libgenre.GenreId', '=', $genreId)
//            ->leftJoin('libbook', 'libbook.BookId', '=', 'libgenre.BookId')
//            ->leftJoin('libbannotations', 'libgenre.BookId', '=', 'libbannotations.BookId')
//            ->orderBy('libgenre.Id')
//            ->paginate(10);


        $bookIds = DB::table('libgenre')
            ->where('GenreId', $genreId)
            ->orderBy('libgenre.Id', 'desc')
            ->paginate(10, ['BookId']);


        $booksResult = $this->getBooks($bookIds->pluck('BookId')->toArray());
//        dd($booksResult);
//        dd($bookIdsToArray);

//        dd($bookIds);

//        $bookIds = DB::table('libbook')
//            ->whereIn('BookId', $bookIds)
//            ->orderBy('BookId', 'desc')
//            ->paginate(10);

//        dd($bookIds);


        $title = DB::table('libgenrelist')
            ->whereIn('GenreId', [$genreId])
            ->first();
//        SEOTools::setTitle(config('seo.genre.title'));

        SEOTools::setTitle(str_replace('[название]', $title->GenreDesc, config('seo.genre.title')));
        SEOTools::setDescription(str_replace('[название]', $title->GenreDesc, config('seo.genre.description')));
        SEOTools::opengraph()->setUrl(config('seo.genre.og_url'));
        SEOTools::setCanonical(route('genre', $genreId));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.genre.twitter_title'));

//        dd($title);


        return view('genre', [
            'books' => $booksResult,
            'pagination' => $bookIds,
            'title' => $title->GenreDesc
        ]);
    }

    public function authors()
    {

        SEOTools::setTitle(config('seo.authors.title'));
        SEOTools::setDescription(config('seo.authors.description'));
        SEOTools::opengraph()->setUrl(config('seo.authors.og_url'));
        SEOTools::setCanonical(route('authors'));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.authors.twitter_title'));

        $page = request()->get('page', 1);

        $totalAuthors = Cache::remember('total_authors', 1440, function () {
            return DB::table('libavtor')->distinct()->count('AvtorId');
        });

        $uniqueAuthorIds = DB::table('libavtor')
            ->distinct()
            ->forPage($page, 20) // $page должен быть определен или получен от запроса
            ->pluck('AvtorId');

        $authors = $this->getAuthors($uniqueAuthorIds->toArray());

        // Формируем объект пагинации вручную, чтобы использовать кэшированное общее количество
        $pagination = new LengthAwarePaginator(
            $authors,
            $totalAuthors,
            20,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('authors', [
            'authors' => $authors,
            'pagination' => $pagination
        ]);


    }


    public function author($authorId)
    {

        $author = DB::table('libavtorname')
            ->select('libavtorname.AvtorId', 'libavtorname.FirstName', 'libavtorname.MiddleName', 'libavtorname.LastName', 'libapics.File', 'libaannotations.Body',
                'libavtorname.Homepage')
            ->leftJoin('libaannotations', 'libavtorname.AvtorId', '=', 'libaannotations.AvtorId')
            ->leftJoin('libapics', 'libavtorname.AvtorId', '=', 'libapics.AvtorId')
            ->where('libavtorname.AvtorId', '=', $authorId)
            ->first();


//        $countBooks = Db::table('libavtor')
//            ->where('libavtor.AvtorId', '=', $authorId)
//            ->count();


        $allIds = DB::table('libavtor')
            ->where('libavtor.AvtorId', '=', $authorId)
            ->orderBy('libavtor.BookId')
            ->pluck('libavtor.BookId')
            ->toArray();


        $bookIds = DB::table('libbook')
            ->whereIn('BookId', $allIds)
            ->orderBy('BookId', 'desc')
            ->paginate(10);

        $booksResult = $this->getBooks($bookIds->pluck('BookId')->toArray());

//        dd($author->AvtorId);

        $authorFullName = $author->LastName . ' ' . $author->FirstName . ' ' . $author->MiddleName;
        SEOTools::setTitle(str_replace('[название]', $authorFullName, config('seo.author.title')));
        SEOTools::setDescription(str_replace('[название]', $authorFullName, config('seo.author.description')));
        SEOTools::opengraph()->setUrl(config('seo.author.og_url'));
        SEOTools::setCanonical(route('author', $authorId));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.author.twitter_title'));


        return view('author', [
            'author' => $author,
            'pagination' => $bookIds,
            'books' => $booksResult
        ]);

    }

    public function series()
    {
        SEOTools::setTitle(config('seo.series.title'));
        SEOTools::setDescription(config('seo.series.description'));
        SEOTools::opengraph()->setUrl(config('seo.series.og_url'));
        SEOTools::setCanonical(route('series'));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.series.twitter_title'));

        $series = DB::table('libseqname')
            ->paginate(20);

        return view('series', [
            'series' => $series,
        ]);
    }


    public function oneSeries($seriesId)
    {
        $series = DB::table('libseq')
            ->where('libseq.SeqId', '=', $seriesId)
            ->leftJoin('libseqname', 'libseq.SeqId', '=', 'libseqname.SeqId')
            ->leftJoin('libbook', 'libbook.BookId', '=', 'libseq.BookId')
            ->orderBy('libseq.SeqNumb', 'ASC')
            ->get();


        $thisSeries = DB::table('libseqname')
            ->where('SeqId', '=', $seriesId)
            ->first();

//        dd($thisSeries->SeqName);
        SEOTools::setTitle(str_replace('[название]', $thisSeries->SeqName, config('seo.oneSeries.title')));
        SEOTools::setDescription(str_replace('[название]', $thisSeries->SeqName, config('seo.oneSeries.description')));
        SEOTools::opengraph()->setUrl(config('seo.oneSeries.og_url'));
        SEOTools::setCanonical(route('oneSeries', $seriesId));
//        SEOTools::opengraph()->addProperty('type', 'articles');
        SEOTools::twitter()->setSite(config('seo.oneSeries.twitter_title'));



        return view('oneSeries', [
            'series' => $series,
            'thisSeries' => $thisSeries
        ]);
    }

    public function status($bookId)
    {

        $userId = auth()->id(); // Получаем идентификатор текущего пользователя
        $status = request('status'); // Получаем статус из запроса, безопаснее, чем $_POST

        DB::table('bookstatus')->updateOrInsert(
            [
                'user_id' => $userId, // Условие уникальности
                'book_id' => $bookId, // Условие уникальности
            ],
            [
                'status' => $status, // Данные для обновления или вставки
                'date' => now(), // Дата обновляется при каждой операции
            ]
        );


        return back()->with('message', 'Статус книги изменен');

    }

    public function like($bookId)
    {
        $userId = Auth::id(); // Получаем идентификатор текущего авторизованного пользователя

        DB::transaction(function () use ($userId, $bookId) {
            // Проверяем, существует ли уже запись "like" для данного пользователя и книги
            $exists = DB::table('bookslikes')
                ->where('user_id', $userId)
                ->where('book_id', $bookId)
                ->exists();

            if ($exists) {
                // Если запись существует, удаляем её
                DB::table('bookslikes')
                    ->where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->delete();
            } else {
                // Если записи не существует, вставляем новую
                DB::table('bookslikes')->insert([
                    'user_id' => $userId,
                    'book_id' => $bookId,
                    'date' => now() // now() - это хелпер Laravel для получения текущей даты и времени
                ]);
            }
        });

        $exists = DB::table('bookslikes')
            ->where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();

        if ($exists) {
            $message = 'Добавлено в любимые книги';
        } else {
            $message = 'Удалено из любимых книг';
        }


        return back()->with('message', $message);

    }

    public function comment($id)
    {
        $validatedData = request()->validate([
            'comment' => 'required|string|max:2000',
        ]);
        $cleanComment = $this->clean($validatedData['comment']);


        DB::table('libreviews')->insert([
            'Name' => auth()->user()->name,
            'Time' => now(),
            'BookId' => $id,
            'Text' => $cleanComment,
            'user_id' => auth()->id()
        ]);

        return back()->with('message', 'Комментарий добавлен!');

    }

    public function star($id)
    {
//        Log::info('Запрос на рейтинг получен', ['data' => $request->all()]);

        $validatedData = request()->validate([
            'rating' => 'required|int',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Нужно авторизоваться']);

        }
        try {

            DB::table('librate')->updateOrInsert(
                [
                    'BookId' => $id,
                    'UserIdNew' => auth()->id(), // Условие для проверки существования записи
                ],
                [
                    'UserId' => 0, // предполагается, что это значение не меняется, или его нужно обновить на конкретное значение
                    'Rate' => $validatedData['rating'], // новое значение рейтинга
                    'date' => now()
                ]
            );

            Log::info('Запрос на рейтинг:', ['request_data' => $validatedData, 'book_id' => $id]);
        } catch (\Exception $e) {
            Log::error('Ошибка при обработке запроса на рейтинг:', ['error' => $e->getMessage()]);
        }

        return response()->json(['message' => 'Рейтинг успешно обновлён']);


    }
}
