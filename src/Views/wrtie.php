<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form {
            display:flex;
            flex-direction:column;
            width:300px;
        }
    </style>
</head>
<body>
    <h2>펀드등록</h2>
    <form action="/wrtie" method="post" enctype="multipart/form-data">
    <input type="text" name="number" id="number" value=<?= $Randnum?>>
    <input type="text" name="name" id="name" >
    <input type="datetime-local" name="endDate" id="endDate">
    <input type="number" name="total" id="total">
    <input type="file" name="image" id="image" class="form-control">
    <input type="text" name="more" id="more">
    <button >제출하기</button>
    </form>
</body>
</html>