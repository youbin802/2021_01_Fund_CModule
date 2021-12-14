<style>
    p {
        border: 1px solid #ddd;
        padding: 10px;
    }

    .item-group {
        border: 1px solid #000;
    }

    .item {
        padding: 10px;
        border: 2px solid #d44e4e;
    }
</style>

<body>
    <div>
        <div class="item-group">
            <?php foreach ($list as $b) : ?>
                <div class="item">
                    <span><?= $b->number ?></span>
                    <span><?= $b->name ?></span>
                    <span><?= $b->endDate ?></span>
                    <span><?= $b->total ?></span>
                    <span><?= $b->current ?></span>
                    <span><?= $b->owner ?></span>
                    <span><?= $b->percent ?></span>
                    <div class="progress" data-number=<?= $b->number ?>>
                        <div data-number=<?= $b->number ?> class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <button><a href="inv?number=<?= $b->number ?>">상세보기</a></button>
                </div>
            <?php endforeach; ?>
        </div>
        <script>
            let fund_data = JSON.parse(`<?= json_encode($list) ?>`);
            percent = <?= $b->percent ?>;
            let find = fund_data.find(x => x.percent);
            let bar = document.querySelector(".progress");

            document.querySelectorAll(".progress-bar").forEach((div, idx) => {
                let percent = fund_data[idx].percent;
                new Fund(div, percent);
            });

            // function getJson() {
            //     return JSON.parse(`<?= json_encode($list) ?>`);
            // }
        </script>
        <!-- <script src="dsaasdasd.js"></script> -->

    </div>