<?php
namespace Gondr\App;
class Route {
    private static $actions= [];
    public static function __callStatic($name, $args) {
        $req= strtolower($_SERVER['REQUEST_METHOD']);
        if($req==$name) {
            self::$actions[]= $args;
        }
    }

    public static function init() {
        $path= explode("?", $_SERVER['REQUEST_URI']);
        $path= $path[0];
        foreach(self::$actions as $a) {
            if($a[0] === $path) {
                $action = explode("@", $a[1]);
                $controllername = "Gondr\\Controller\\" . $action[0];
                $c = new $controllername();
                $c->{$action[1]}();
                return;
            }
        }echo "없는 주소입니다.";
    }
}