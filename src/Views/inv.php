<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    span {
        display:flex;
        flex-direction:column;
    }
    </style>
</head>
<body>
    <span><a href="profil?user=<?=$list->iname ?>"><?=$list->iname ?></a></span>
<?php foreach ($invlist as $b): ?>
    <span><?= $b->email ?></span>
    <span>νλμ§λΆ</span>
    <?php endforeach ?>
</body>
</html>