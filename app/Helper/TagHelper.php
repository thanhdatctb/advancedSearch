<?php


namespace App\Helper;


use Exception;
use Illuminate\Support\Facades\DB;

class TagHelper
{
    public function insertTag($context, $type, $tag, $foreignId)
    {
        $tableName = "aaaaa";
        switch ($type) {
            case "product":
            {
                $tableName = "table_product_tags";
                break;
            }
            case "category":
            {
                $tableName = "table_category_tags";
                break;
            }
            case "blog":
            {
                $tableName = "table_blog_tags";
                break;
            }
            default:
                {
                    $tableName = "defaul";
                    throwException(new Exception("Type is not valid"));
                    break;
                }

        }
        return DB::table($tableName)->insert([
            "foreign_id" => $foreignId,
            "tag" => $tag,
            "context" => $context
        ]);
    }
}
