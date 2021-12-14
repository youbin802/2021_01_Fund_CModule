<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="./js/jquery-3.4.1.js"></script>
    <style>
    .item-group {
    border:1px solid #000;
}
.item {
    padding:10px;
    border:2px solid #d44e4e;
}
#popup {
    position: fixed;
    width:100%;
    height:100%;
    left:0;
    top:0;
    background-color: rgba(0,0,0,0.3);
    z-index: 100;
    display:none;

}
#popup form{
    display:flex;
    flex-direction:column;
    width:300px;
    position:relative;
    top:50%;
    left:50%;
}
#popup.active {
    display:flex;
}
canvas {
    background-color:#fff;
}
#sign {
    display:none;
}
    </style>
</head>
<body>
<h2>펀드보기</h2>
<div class="item-group">
        <?php foreach ($list as $b): ?>
        <div class="item">
        <span><?= $b->number?></span>
        <span><?= $b->name?></span>
        <span><a href="profil?user=<?= $b->iname ?>"><?= $b->iname?></a></span>
        <span><?= $b->endDate?></span>
        <span><?= $b->total?></span>
        <span><?= $b->current?></span>
        <span><?= $b->owner?></span>
        <span><?= $b->percent?></span>
        <button><a href="inv?number=<?=$b->number ?>">상세보기</a></button>
       <?php if(isset($_SESSION['user'])): ?>
        <?php if(strtotime(date('Y-m-d h:i:s')) <= strtotime($b->endDate)): ?>
        <button onclick="del('<?=$b->number ?>','<?=$b->name ?>','<?=$b->total ?>');">투자하기</button>
        <?php else: ?> 
        <span>모집완료</span>
        <?php endif;?>
        <?php if($_SESSION['user']->name == $b->iname && $_SESSION['user']->email == $b->owner  && $b->total<=$b->current):?>
       <form action="/end" method="post">
       <input type="hidden" name="number" value="<?=$b->number ?>">
        <button>완료</button>
        </form>
        <?php endif; ?>
        <?php if($_SESSION['user']->name == $b->iname && $b->recru):?>
            <form action="/fundthis" method="get">
        <input type="hidden" name="number" value="<?= $b->number?>">
        <button>모집해제</button>
        </form>
        <?php endif; ?>
        <?php endif; ?>
        </div>
        <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($pg->prev) : ?>
                            <li class="page-item"><a class="page-link" href="/look?p=<?= $pg->start - 1 ?>"><<</a></li>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = $pg->start; $i <= $pg->end; $i++) : ?>
                            <li class="page-item "><a class="page-link" href="/look?p=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                        <?php if ($pg->next) : ?>
                            <li class="page-item"><a class="page-link" href="/look?p=<?= $pg->end + 1 ?>">>></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
<!-- 펀드번호, 창업펀드명, 투자자명, 금액, 사인 -->
        <div id="popup">
        <form action="popup" method="post">
            <input type="text"  readonly id="number" name="number">
            <input type="text" readonly id="name" name="name">
            <input type="text" value=<?=$_SESSION['user']->name ?> readonly name="iname">
            <input type="number" placeholder="금액" id="price" name="price"> 
            <canvas width="200" height="100" id="canvas" name="canvas"></canvas>
            <input type="text" name="signURL" id="signURL" >
            <select id="selwidth">
                <option value="1">얇게</option>
                <option value="3">중간</option>
                <option value="5">굵게</option>
            </select>
            <button type="submit" id="submit" onclick="go()">투자</button>
            <button type="button" onclick="cl()">취소</button>
        </form>
        </div>
        <script language='javascript'>
        const log = console.log;
            let canvas = $("canvas")[0];
            let ctx = canvas.getContext("2d"); 

        function del(number, name,total) {
            document.querySelector("#popup").classList.add("active");
            let num= number;
            document.querySelector("#number").value=num;
            document.querySelector("#name").value=name;
            $(document).on("input", "#price", (e) => {
            let max=total;
            let value = e.currentTarget.value;
            value = removeComma(value);
            log(value);
            value = (value.replaceAll(/[^0-9]/g, "") * 1).toLocaleString();
            if (removeComma(value) * 1 >= max) {
                value = max;
                value = (value.toString().replaceAll(/[^0-9]/g, "") * 1).toLocaleString();
            }
            e.currentTarget.value = value;
        });
    }


    function removeComma(str) {
        return str.split(',').join('');
    }
        function cl() {
            document.querySelector("#popup").classList.remove("active");
        }
        
        ctx.lineCap = "round";
        let drawing = false;
        $("#sign").val('false');
        let x = 0;
        let y = 0;
        let URL;
        $("canvas").on("mousedown", function (e) {
            drawing = true;
            x = e.offsetX;
            y = e.offsetY;
        });
        $("canvas").on("mousemove", function (e) {
            if (drawing) {
                $("#sign").val('true');
                ctx.moveTo(x, y);
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
                x = e.offsetX;
                     y = e.offsetY;
            }
        });
        $("canvas").on("mouseover", function(e) {
            drawing = false;
        });
        $("#selwidth").on("change", function (e) {
            ctx.lineWidth= e.target.value;
        });
        </script>
</body>
</html>