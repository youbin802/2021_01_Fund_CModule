<?php    
 require_once("db.php");
 $db= new DB();
 $sql="SELECT * FROM fund";
 $dd = $db->fetchAll($sql);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        div {
            border:1px solid #ddd;
        }
    </style>
</head>
<body>
<?php foreach($dd as $d ): ?>
    <div>
    <p><?= $d->number?></p>
    <p><?= $d->name?></p>
    <p><?= $d->endDate?></p>
    <p><?= $d->total?></p>
    <p><?= $d->current?></p>
    <button onclick="pop()">상세보기</button>
    </div>
    <?php endforeach; ?>
</body>
</html>
<!-- 상세보기 버튼을 눌러 들어간 
정보페이지에서 펀드등록자의 이름을 클릭시 해당 
유저의 프로필 페이지로 이동해야 한다. -->