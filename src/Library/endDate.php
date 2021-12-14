<?php
namespace Gondr\Library;
class endDate {
    public static function flag($endDate) {
        $now=date("Y-m-d h:i:s a");

        if(strpos($now,"pm")!=false) {
            $h = date('h')+12;
            $now=date("Y-m-d $h:i:s");
        }

        if(strtotime($now) > strtotime($endDate)) {
            $flag = true;
        }else {
            $flag = false;
        }
        return $flag;
    }
}