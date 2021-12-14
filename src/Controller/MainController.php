<?php

namespace Gondr\Controller;

use Gondr\App\DB;
use Gondr\Library\Lib;
use Gondr\Library\Pagination;
use Gondr\Library\endDate;

class MainController extends MasterController
{
    public function index()
    {
        $db = new DB();

        $d = "SELECT * FROM fund ORDER BY percent DESC LIMIT 0,4";
        $list = $db->fetchAll($d);
        $this->render("main", ['list' => $list]);
    }

    public function login()
    {
        $this->render("login");
    }

    public function loginProcess()
    {
        $id = $_POST['id'];
        $password = $_POST['password'];
        $password = $_POST['password'];
        if (trim($id) === "" || trim($password) === "") {
            Lib::msgAndBack("필수값을 입력하세요");
            exit;
        }

        $db = new DB();
        $sql = "SELECT * FROM users WHERE id=? AND password=?";
        $result = $db->fetch($sql, [$id, $password]);

        if ($result) {
            $_SESSION['user'] = $result;
            Lib::msgAndGo("로그인완료", "/");
        } else {
            Lib::msgAndBack("불일치");
        }
    }


    public function join()
    {
        $this->render("join");
    }

    public function joinProcess()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $passwordc = $_POST['passwordc'];
        $email = $_POST['email'];

        $ch1 = preg_match('/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[a-z]{1,2}\.[a-z]{1,3}$/', $email);
        $ch2 = preg_match("/[0-9a-zA-Z][~!@#$%^&*()_+|<>?:{}]/", $password);
        if ($ch1 == false) {
            Lib::msgAndBack("이메일 형식에 알맞지 않습니다.");
            exit;
        }

        if ($ch2 == false) {
            Lib::msgAndBack("비밀번호는 영문, 특문, 숫자를 포함해야 합니다.");
            exit;
        }

        if (trim($id) === "" || trim($name) === "" || trim($email) === "" || trim($password) === "" || trim($passwordc) === "") {
            Lib::msgAndBack("필수값을 입력하세요");
            exit;
        }

        if ($password !== $passwordc) {
            Lib::msgAndBack("비밀번호 불일치");
            exit;
        }
        $db = new DB();
        $sql = "INSERT INTO users (id, name, password,price,email) VALUES(?,?,?,50000,?)";
        $result = $db->execute($sql, [$id, $name, $password, $email]);

        if ($result) {
            Lib::msgAndGo("성공적으로 회원가입 완료", "/login");
            exit;
        } else {
            Lib::msgAndBack("DB연결실패");
        }
    }

    public function look()
    {
        $db = new DB();
        
        $page = 1;
        if (isset($_GET['p']) && is_numeric($_GET['p'])) {
            $page = $_GET['p'] * 1;
        }
        $cnt = $db->fetch("SELECT count(*) AS cnt FROM fund")->cnt;
        $pg = new Pagination($cnt, $page);
        $sql = "SELECT * FROM users WHERE name=?";
        $endDate;
        $start = ($page - 1) * 10;
        $d = "SELECT * FROM fund ORDER BY name DESC LIMIT {$start},10";
        $flag = false;
        $check = "모집해제";
        $list = $db->fetchAll($d);
        foreach ($list as $b) {
            $endDate = $b->endDate;
            if (endDate::flag($endDate)) {
                $r = "UPDATE fund SET endCheck=? WHERE endDate=?";
                $re = $db->execute($r, [$check, $b->endDate]);
            }
        }
        $this->render("look", ['list' => $list, 'flag' => $flag, 'pg' => $pg]);
    }

    public function wrtie()
    {
        $db = new DB();
        $sql = "SELECT * FROM fund";
        $b = $db->fetchAll($sql);
        $arr = [];
        $arr_two = [];
        $max = 1;
        $Rnumber;
        $Randnum;
        foreach ($b as $d) {
            $Rnumber = substr((string)$d->number, 0, 4);
            array_push($arr, $d->number);
        }
        if (!isset($Rnumber)) {
            $Rnumber = 'A000';
        }

        for ($i = 0; $i < count($arr); $i++) {
            $StrNum = substr((string)$arr[$i], 4);
            array_push($arr_two, $StrNum);
        }
        $flag = true;
        for ($i = 0; $i < count($arr_two); $i++) {
            if (isset($arr_two[1])) {
                $max = $arr_two[0];
                if ($arr_two[$i] > $max) {
                    $max = $arr_two[$i] + 1;
                }
            } else {
                $flag = false;
            }
        }
        if (!$flag) {
            $max = $max + 1;
        }


        $Randnum = $Rnumber . $max;

        $this->render("wrtie", ['Randnum' => $Randnum]);
    }

    public function wrtieProcess()
    {
        $img = $_FILES['image'];
        $number = $_POST['number'];
        $name = $_POST['name'];
        $endDate = $_POST['endDate'];
        $flag = false;
        if (endDate::flag($endDate)) {
            Lib::msgAndBack("시간을 조절해");
            exit;
        }
        // $timeZone = new \DateTime($endDate, new \DateTimeZone('KST'));
        // $dt = $timeZone->format("Y-m-d h:i:s");

        // date_default_timezone_set('Asia/Seoul');
        // $re = date($endDate);
        // $today = date("Y-m-d h:i:s");
        // if(strtotime($today) > strtotime($dt)) {
        //     Lib::msgAndBack("시간을 조절해");
        //     exit; 
        // }
        $total = $_POST['total'];
        $more = $_POST['more'];
        $target = __DIR__ . '/upload/' . $img['name'];
        move_uploaded_file($img['tmp_name'], $target);
        $db = new DB();
        $sql = "INSERT INTO fund (number, name, endDate, total, owner, iname,image ,`idx`, `reg_date`) VALUES (?,?,?,?,?,?,?, null ,NOW())";
        if (trim($img['tmp_name']) == "" || trim($number) == "" || trim($name) == "" || trim($endDate) == "" || trim($total) == "" || trim($more) == "") {
            Lib::msgAndBack("누락");
            exit;
        }
        $param = [$number, $name, $endDate, $total, $_SESSION['user']->email, $_SESSION['user']->name, $img['name']];
        $result = $db->execute($sql, $param);
        if ($result) {
            Lib::msgAndGo("등록 완료", "look");
        } else {
            Lib::msgAndBack("에러 나는데?");
        }
    }
    // {
    //     $db = new DB();
        
    //     $page = 1;
    //     if (isset($_GET['p']) && is_numeric($_GET['p'])) {
    //         $page = $_GET['p'] * 1;
    //     }
    //     $cnt = $db->fetch("SELECT count(*) AS cnt FROM fund")->cnt;
    //     $pg = new Pagination($cnt, $page);
    //     $sql = "SELECT * FROM users WHERE name=?";
    //     $endDate;
    //     $start = ($page - 1) * 10;
    //     $d = "SELECT * FROM fund ORDER BY name DESC LIMIT {$start},10";
    //     $flag = false;
    //     $check = "모집해제";
    //     $list = $db->fetchAll($d);
    //     foreach ($list as $b) {
    //         $endDate = $b->endDate;
    //         if (endDate::flag($endDate)) {
    //             $r = "UPDATE fund SET endCheck=? WHERE endDate=?";
    //             $re = $db->execute($r, [$check, $b->endDate]);
    //         }
    //     }
    //     $this->render("look", ['list' => $list, 'flag' => $flag, 'pg' => $pg]);
    // }
    public function list()
    {
        $db = new DB();
        $sql;
        $b;
        $page = 1;
        if (isset($_GET['p']) && is_numeric($_GET['p'])) {
            $page = $_GET['p'] * 1;
        }
        $start = ($page - 1) * 5;
        $cnt = $db->fetch("SELECT count(*) AS cnt FROM inves")->cnt;
        $pg = new Pagination($cnt, $page);
        if(isset($_GET['select'])) {
            $select= $_GET['select'];
            if($select==1) {
                $sql = "SELECT * FROM inves ORDER BY number DESC LIMIT {$start},5";
                $b = $db->fetchAll($sql);
            }else if($select==2){
                $sql="SELECT * FROM inves ORDER BY name DESC LIMIT {$start},5";   
                $b= $db->fetchAll($sql);
            }else {
                $sql="SELECT * FROM inves ORDER BY `reg_date` DESC LIMIT {$start},5";
                $b= $db->fetchAll($sql);
            }
        }


        $this->render("list", ['b' => $b, 'pg' => $pg , 'mod' => $select]);
    }

    public function downloadProcess()
    {
        $db = new DB();
        $num = $_POST['number'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = "SELECT * FROM inves WHERE number=? and name=? and email=?";
        $r = $db->fetchAll($sql, [$num, $name, $email]);
        $this->render("list", ['r' => $r]);
    }



    public function admin()
    {
        $db = new DB();
        $sql = "SELECT * FROM fund";
        $b = $db->fetchAll($sql);

        $biz = "SELECT * FROM bizlist";
        $bizlist = $db->fetchAll($biz);

        $cd = "SELECT * FROM users";
        $user = $db->fetchAll($cd);
        $cnt = 0;
        $price = 0;
        foreach ($user as $popo) {
            $cnt++;
            $price = $price + $popo->price;
        }
        $ave = round($price / $cnt, 2);

        $r = "SELECT count(*) AS cnt FROM bizlist";
        $re = $db->fetch($r);
        $this->render("admin", ['b' => $b, 'bizlist' => $bizlist, 'cnt' => $cnt, 'ave' => $ave, 're' => $re->cnt]);
    }

    public function releProcess()
    {

        $db = new DB();
        $num = $_POST['number'];

        $i = "SELECT * FROM inves WHERE number=?";
        $inv = $db->fetchAll($i, [$num]);

        $p = "SELECT * FROM users WHERE name=? and email=?";

        foreach ($inv as $b) {
            $pay = $db->fetch($p, [$b->name, $b->email]);
            $price = $pay->price + $b->pay;
            $u = "UPDATE users SET price=? WHERE name=? and email=?";
            $user = $db->execute($u, [$price, $b->name, $b->email]);
        }

        $sql = "DELETE FROM fund WHERE number=?";
        $result = $db->execute($sql, [$num]);

        if ($result && $user) {
            Lib::msgAndGo("해제 완료, 금액 반환 완료", "admin");
        } else {
            Lib::msgAndBack("글렀다 니는");
        }
    }

    public function profil()
    {

        $db = new DB();
        $name = $_GET['user'];
        $sql = "SELECT * FROM users WHERE name=?";
        $userlist = $db->fetchAll($sql, [$name]);
        foreach ($userlist as $b) {
            $email = $b->email;
        }
        $b = "SELECT * FROM inves WHERE name=? and email=?";
        $inv = $db->fetchAll($b, [$name, $email]);

        $br = "SELECT * FROM bizlist WHERE iname=? and email=?";
        $biz = $db->fetchAll($br, [$name, $email]);

        $f = "SELECT * FROM fund WHERE owner=? and iname=?";
        $fund = $db->fetchAll($f, [$email, $name]);
        $this->render("profil", ['userlist' => $userlist, 'inv' => $inv, 'biz' => $biz, 'fund' => $fund]);
    }

    public function inv()
    {
        $db = new DB();
        $number = $_GET['number'];
        $sql = "SELECT * FROM inves WHERE number=?";
        $invlist = $db->fetchAll($sql, [$number]);

        $d = "SELECT * FROM fund WHERE number=?";
        $list = $db->fetch($d, [$number]);
        $num = $list->number;

        $this->render("inv", ["invlist" => $invlist, "list" => $list]);
    }

    public function popupProcess()
    {
        $db = new DB();
        $number = $_POST['number'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $iname = $_POST['iname'];
        $sign = $_POST['signURL'];



        if (trim($number) == "" || trim($name) == "" || trim($iname) == "" || trim($price) == "" || $sign == 'false') {
            Lib::msgAndBack("누락되었습니다.");
            exit;
        }

        $sql = "SELECT * FROM fund  WHERE number=?";
        $fund = $db->fetch($sql, [$number]);

        if ($price > $fund->total) {
            Lib::msgAndBack("total값 넘었어");
            exit;
        }

        $percent = ($fund->current / $fund->total) *100;
        $email = $_SESSION['user']->email;
        $current = $fund->current + $price;

        $i = "SELECT * FROM inves WHERE number=? and email=? and name=?";
        $inv = $db->fetchAll($i, [$number, $_SESSION['user']->email, $iname]);
        if ($inv) {
            $p = "UPDATE inves SET pay= ?, sign= ? WHERE number= ?";
            $re = $db->execute($p, [$current, $sign, $number]);
        } else {
            $sql = "INSERT INTO inves (number,email,pay,name,fundname,sign, idx, reg_date) VALUES(?,?,?,?,?,?,null, NOW())";
            $re = $db->execute($sql, [$number, $email, $price, $iname, $name, $sign]);
        }
        $d = "UPDATE fund SET current=? , percent=? WHERE number=?";
        $result = $db->execute($d, [$current,$percent, $number]);
        if ($result && $re) {
            Lib::msgAndGo("성공적으로 투자완료", 'look');
        } else {
            Lib::msgAndBack("에러");
            exit;
        }
    }

    public function endProcess()
    {
        $db = new DB();
        $number = $_POST['number'];

        $ram = "SELECT * FROM fund WHERE number=?";
        $ramRe = $db->fetch($ram, [$number]);
        $b = "INSERT INTO bizlist(number, name, total, iname, email) VALUES(?,?,?,?,?)";
        $biz = $db->execute($b, [$ramRe->number, $ramRe->name, $ramRe->total, $ramRe->iname, $ramRe->owner]);

        $price = $ramRe->total + $_SESSION['user']->price;
        $u = "UPDATE users SET price=? WHERE name=? and email=?";
        $user = $db->execute($u, [$price, $ramRe->iname, $ramRe->owner]);

        $sql = "DELETE FROM fund WHERE number=?";
        $result = $db->execute($sql, [$number]);

        if ($result && $biz && $user) {
            Lib::msgAndGo("모집 완료로 인한 삭제 되었습니다.", "look");
        } else {
            Lib::msgAndBack("오류");
        }
    }


    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            Lib::msgAndGo("로그아웃 완료", '/');
        } else {
            Lib::msgAndGo("안돼 돌아가", '/');
        }
    }

    public function roleProcess()
    {
        $db = new DB();
        $num = $_GET['number'];

        $i = "SELECT * FROM inves WHERE number=?";
        $inv = $db->fetchAll($i, [$num]);

        $p = "SELECT * FROM users WHERE name=? and email=?";

        foreach ($inv as $b) {
            $pay = $db->fetch($p, [$b->name, $b->email]);
            $price = $pay->price + $b->pay;
            $u = "UPDATE users SET price=? WHERE name=? and email=?";
            $user = $db->execute($u, [$price, $b->name, $b->email]);
        }


        $sql = "DELETE FROM fund WHERE number=?";
        $result = $db->execute($sql, [$num]);

        if ($result && $user) {
            Lib::msgAndGo("해제 완료, 금액 반환 완료", "look");
        } else {
            Lib::msgAndBack("글렀다 니는");
        }
    }
}
