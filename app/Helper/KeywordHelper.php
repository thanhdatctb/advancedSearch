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
        $data = DB::table("table_keyword_count")->select()
            ->where("key_word", "=", $keyWord)
            ->where("domain", "=", $domain)
            ->get();
        $count = $data->count();
        DB::table("table_keyword")->insert([
            "key_word" => $keyWord,
            "search_at" => date("Y/m/d H:i:s"),
            "domain" => $domain,
        ]);
        if ($count) {
            $keyWord_count = $data->last()->count;
            DB::table("table_keyword_count")
                ->where("key_word", "=", $keyWord)
                ->where("domain", "=", $domain)
                ->update([
                    "count" => $keyWord_count + 1,
                ]);
        } else {
            DB::table("table_keyword_count")->insert([
                "key_word" => $keyWord,
                "count" => 1,
                "domain" => $domain,
            ]);
        }
    }

    public function viewAll($param)
    {
        $keywordsData = DB::table("table_keyword_count")
            ->where("domain", "=", $param["domain"])
            ->select()->get();
        $keywords = array();
        foreach ($keywordsData as $keywordData) {
            $keyword = new Keyword();
            $keyword->setKeyword($keywordData->key_word);
            $keyword->setCount($keywordData->count);
            array_push($keywords, $keyword);
        }
        return $keywords;
    }

    public function getLimitKeyword($limit, $param)
    {
        return Keyword::where("domain", "=", $param["domain"])
            ->where("key_word","!=","")
            ->orderBy("count", "DESC")
            ->take($limit)->get();
    }

    public function getTotalKeyword($param)
    {
        return Keyword::where("domain", "=", $param["domain"])->sum("count");
    }

    public function getTodayKeywordCount($param, $keyword)
    {
        return KeywordDetail::where("key_word","=",$keyword)->whereDate("search_at", Carbon::today())->count();
    }
}
