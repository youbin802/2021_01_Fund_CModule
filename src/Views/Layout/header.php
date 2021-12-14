<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>메인화면</title>
    <link rel="stylesheet" href="fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/travel.css">
    <script src="/js/jquery-3.4.1.js"></script>
    <script src="/js/fund.js"></script>
</head>

<body>
        <div class="row">
            <div class="col-12">
                <div class="logo">logo</div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">메인화면</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/look">펀드보기</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/wrtie">펀드등록</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/list?select=1&p=1">투자자목록</a>
                    </li>
                    <?php if(!isset($_SESSION['user'])) :?>
                    <li class="nav-item">
                        <a class="nav-link" href="/join">회원가입</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">로그인</a>
                    </li>
                    <?php else :?>
                    <?php if($_SESSION['user']->name=="관리자") :?>
                        <li class="nav-item">
                        <a class="nav-link" href="/admin"><?= htmlentities($_SESSION['user']->name)?></a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/profil?user=<?= htmlentities($_SESSION['user']->name)?>"><?= htmlentities($_SESSION['user']->name)?></a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">로그아웃</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
            <div class="container">