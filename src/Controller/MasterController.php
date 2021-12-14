<?php
namespace Gondr\Controller;
class MasterController {
    public function render($view, $data=[]) {
        extract($data);
        require_once(__VIEWS ."/layout/header.php");
        require_once(__VIEWS ."/{$view}.php");
        require_once(__VIEWS . "/layout/footer.php"); 
    }
}