<?php

namespace App\Helper;

use App\Model\Keyword;
use App\Model\KeywordDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeywordHelper extends ApiHelper
{
    //
    public function logSerchWord($keyWord, $domain)
    {
        $context = MainHelper::getInfData("domain", $domain)["context"];
        $data = DB::table("table_keyword_count")->select()
            ->where("key_word", "=", $keyWord)
            ->where("context", "=", $context)
            ->get();
        $count = $data->count();
        DB::table("table_keyword")->insert([
            "key_word" => $keyWord,
            "search_at" => date("Y/m/d H:i:s"),
            "context" => $context,
        ]);
        if ($count) {
            $keyWord_count = $data->last()->count;
            DB::table("table_keyword_count")
                ->where("key_word", "=", $keyWord)
                ->where("context", "=", $context)
                ->update([
                    "count" => $keyWord_count + 1,
                ]);
        } else {
            DB::table("table_keyword_count")->insert([
                "key_word" => $keyWord,
                "count" => 1,
                "context" => $context,
            ]);
        }
    }

    public function viewAll($param)
    {
        return DB::table("table_keyword_count")
            ->where("context", "=", $param["context"])
            ->select("key_word", "count")->get();
    }

    public function getLimitKeyword($limit, $param)
    {
        return Keyword::where("context", "=", $param["context"])
            ->where("key_word", "!=", "")
            ->orderBy("count", "DESC")
            ->take($limit)->get();
    }

    public function getTotalKeyword($param)
    {
        return Keyword::where("context", "=", $param["context"])->sum("count");
    }

    public function getTodayKeywordCount($param, $keyword)
    {
        return KeywordDetail::where("key_word", "=", $keyword)->whereDate("search_at", Carbon::today())->count();
    }
}
