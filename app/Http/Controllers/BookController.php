<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BookController extends Controller
{

    public function download()
    {
        //
    }

    public function getBooks($ids)
    {
        return DB::table('libbook')
            ->select('libbook.BookId', 'libbook.Title', 'libbook.FileType', 'libbook.Lang', 'libbook.Pages', 'libbook.Modified', 'libbannotations.Body')
            ->whereIn('libbook.BookId', $ids)
            ->orderBy('libbook.BookId', 'DESC')
            ->leftJoin('libbannotations', 'libbannotations.BookId', '=', 'libbook.BookId')
            ->get();
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
        $bookIds = DB::table('libbook')
            ->orderBy('BookId', 'desc')
            ->paginate(10, ['BookId']);

        $bookIdsToArray = $bookIds->pluck('BookId')->toArray();
//        dd($bookIdsToArray);
        $books = $this->getBooks($bookIdsToArray);

//        $totalBooks = DB::table('libbook')->count();

        return view('index', [
            'books' => $books,
            'pagination' => $bookIds
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
                'lbp.File AS BookImg',
                'ljb.realId AS RealId',
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
//                'lap.file'
            )
            ->get();




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


        return view('book', [
            'book' => $results[0],
            'comments' => $comments,
        ]);


    }

    public function search()
    {
        $search = request()->search;
        $searchBooks = $this->findBook($search);

        return view('search', [
            'books' => $searchBooks,
        ]);

    }

    public function findBook($search)
    {
        return Book::whereRaw("MATCH(Title) AGAINST(? IN BOOLEAN MODE)", [$search])
            ->orderByRaw("MATCH(Title) AGAINST(? IN BOOLEAN MODE) DESC", [$search])
            ->take(100)
            ->paginate(10);
    }

    public function genres()
    {
        $genres = DB::table('libgenrelist')
            ->select('GenreMeta', 'GenreDesc', 'GenreCode')
            ->orderBy('GenreMeta')
            ->orderBy('GenreDesc')
            ->get()
            ->groupBy('GenreMeta');

        return view('genres', [
            'genres' => $genres
        ]);
    }

    public function genre($genreCode)
    {
        $allIds = DB::table('libgenre')
            ->join('libgenrelist', 'libgenre.GenreId', '=', 'libgenrelist.GenreId')
            ->where('libgenrelist.GenreCode', '=', $genreCode)
            ->orderBy('libgenre.Id')
            ->pluck('libgenre.BookId')
            ->toArray();

        $bookIds = DB::table('libbook')
            ->whereIn('BookId', $allIds)
            ->orderBy('BookId', 'desc')
            ->paginate(10);

        $booksResult = $this->getBooks($bookIds->pluck('BookId')->toArray());

        $title = DB::table('libgenrelist')
            ->whereIn('GenreCode', [$genreCode])
            ->first();


        return view('genre', [
            'books' => $booksResult,
            'pagination' => $bookIds,
            'title' => $title->GenreDesc
        ]);
    }

    public function authors()
    {

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


        return view('author', [
            'author' => $author,
            'pagination' => $bookIds,
            'books' => $booksResult
        ]);

    }

    public function series()
    {
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


        return view('oneSeries', [
            'series' => $series,
            'thisSeries' => $thisSeries
        ]);
    }
}
