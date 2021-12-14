<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .list-group {
            display:flex;
            flex-direction:column;
        }
        .list {
            border:1px solid #ddd;
            padding:5px;
        }

    </style>
</head>
<body>
    <h2>관리자 페이지</h2>
    <h4>펀드목록</h4>
    <div class="list-group">
        <?php foreach($b as $c) :?>
            <div class="list">
            <form action="/admin" method="post">
            <input type="hidden" name="number" value="<?= $c->number?>">
            <span><?= $c->number?></span>
            <span><?= $c->name?></span>
            <span><?= $c->iname?></span>
            <span><?= $c->endDate?></span>
            <span><?= $c->total?></span>
            <span><?= $c->current?></span>
            <span><?= $c->owner?></span>
            <button>해제</button>
            </div>
            </form>
        <?php endforeach; ?>
    </div>
    <h4>사업리스트</h4>
    <div class="list-group">
        <?php foreach($bizlist as $c) :?>
            <div class="list">
            <span><?= $c->number?></span>
            <span><?= $c->name?></span>
            <span><?= $c->iname?></span>
            <span><?= $c->total?></span>
            <span><?= $c->email?></span>
            </div>
        <?php endforeach; ?>
    </div>
    <h4>유저</h4>
    <span>회원수<?= $cnt ?></span>
    <span>평균 소지금액<?= $ave ?></span>
    <h4>펀드 정보 리스트</h4>
    <h5>모집완료된 펀드 수<?= $re ?></h5>
    <h5>기한 만료된 펀드 수</h5>
    <h5>모집중인 펀드 수</h5>
</body>
</html>