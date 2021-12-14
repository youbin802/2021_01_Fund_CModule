<?php
namespace Gondr\Library;
class Pagination {
    public $pagePerChapter=5;
    public $articlePerPage=10;
    public $next= true;
    public $prev= true;
    public $start =1;
    public $end =10;
    public $page=1;
    public $totalPage;

    public function __construct($total,$page) {
        $this->totalPage= ceil($total/$this->articlePerPage);
        $this->end = ceil($page/$this->pagePerChapter)*$this->pagePerChapter;
        $this->start = $this->end - $this->pagePerChapter +1;

        if($this->end >= $this->totalPage) {
            $this->end = $this->totalPage;
            $this->next= false;
        }

        if($this->start==1) {
            $this->prev= false;
        }
    }
}