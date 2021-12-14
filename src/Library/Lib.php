<?php
namespace Gondr\Library;
class Lib {
    public static function msgAndBack($msg) {
        echo "<script>";
        echo "alert('{$msg}');";
        echo "history.back();";
        echo "</script>";
        echo "<meta charset='utf-8'>";
    }

    public static function msgAndGo($msg, $url) {
        echo "<script>";
        echo "alert('{$msg}');";
        echo "location.href='{$url}';";
        echo "</script>";
        echo "<meta charset='utf-8'>";
    }
}