<?php

namespace App\Http\Controllers;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getBooks($ids)
    {
        return DB::table('libbook')
            ->select('libbook.BookId', 'libbook.Title', 'libbook.FileType', 'libbook.Lang', 'libbook.Pages', 'libbook.Modified', 'libbannotations.Body')
            ->whereIn('libbook.BookId', $ids)
            ->orderBy('libbook.BookId', 'DESC')
            ->leftJoin('libbannotations', 'libbannotations.BookId', '=', 'libbook.BookId')
            ->get();
    }

    protected function clean($input)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($input);
    }
}
