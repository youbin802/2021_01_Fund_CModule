    <style>
    p {
        border:1px solid #ddd;
        padding:10px;
    }
    .inv {
        padding:10px;
    }
    </style>
</head>
<body>
<div class="profil-container">
<div class="userBox">
    <i class="fa fa-user fa-3x" style="color:#555"></i>
    <div class="more-group">
<?php foreach ($userlist as $b): ?>
    <span><?= $b->name ?></span>
    <div class="more">
<span>pay</span>
    <span><?= $b->price ?></span>
    <span>email</span>
    <span><?= $b->email ?></span>
    </div>
    <?php endforeach ?>
    </div>
    </div>
    <div class="user-side">
    <h4>등록한 펀드</h4>
    <div class="inv">
    <?php foreach ($fund as $b): ?>
    <span>I<?= $b->number ?></span>
    <span><?= $b->name ?></span>
    <span><?= $b->total ?></span>
    <span><?= $b->current ?></span>
    <span><?= $b->endDate ?></span>
    <span><?= $b->owner ?></span>
    <?php endforeach ?>
    </div>
<h4>투자목록</h4>
    <div class="inv">
    <?php foreach ($inv as $b): ?>
    <span>I<?= $b->number ?></span>
    <span><?= $b->name ?></span>
    <span><?= $b->pay ?></span>
    <span><?= $b->email ?></span>
    <?php endforeach ?>
    </div>
    <h4>사업</h4>
    <div class="inv">
    <?php foreach ($biz as $b): ?>
    <span>I<?= $b->number ?></span>
    <span><?= $b->name ?></span>
    <span><?= $b->total ?></span>
    <span><?= $b->email ?></span>
    <span><?= $b->iname ?></span>
    <?php endforeach ?>
    </div>
    </div>
    </div>
</body>
</html>
<!-- 이메일,이름,보유금액 -->