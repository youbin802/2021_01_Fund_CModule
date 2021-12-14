<?php
require_once("./db.php");
require_once("./Lib.php");
header("Content-Type:text/html;charset=utf-8");

$db= new DB();
$number= $_POST['number'];
$name= $_POST['name'];
$price= $_POST['price'];
$iname= $_POST['iname'];
$sign= $_POST['sign'];

if(trim($number)=="" || trim($name)=="" || trim($iname)=="" ||trim($price)=="" || $sign=='false') {
    Lib::msgAndBack($canvas);
    exit;
}

$sql="SELECT * FROM fund  WHERE number=?";
$fund= $db->fetch($sql,[$number]);

if($price > $fund->total) {
    Lib::msgAndBack("total값 넘었어");
    exit;
}
$email= $_SESSION['user']->email;
$current = $fund->current + $price;

$i ="SELECT * FROM inves WHERE number=? and email=? and name=?";
$inv =$db->fetchAll($i,[$number, $_SESSION['user']->email, $iname]);
if($inv) {
    $p ="UPDATE inves SET pay=? WHERE number=?";
    $re = $db->execute($p,[$current, $number]);
}else {
    $sql="INSERT INTO inves (number,email,pay,name,fundname) VALUES(?,?,?,?,?)";
    $re = $db->execute($sql,[$number, $email, $price, $iname, $name]);
}
$d ="UPDATE fund SET current=? WHERE number=?";
$result = $db->execute($d, [$current, $number]);
if($result && $re) {
    Lib::msgAndGo("성공적으로 투자완료",'look.php');
}else {
    Lib::msgAndBack("에러삐융");
    exit;
}
