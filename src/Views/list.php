    <style>
        .inv-group {
            display: flex;
            flex-direction: column;
        }

        .inv {
            width: 100%;
            height: 100px;
            border: 10px solid #ddd;
            display: flex;
        }

        button {
            height: 30px;
        }

        .progress {
            width: 6%;
        }

        p {
            width: 150px;
        }
    </style>
    </head>

    <body>
        <h2>투자자목록</h2>
        <form action="/list" method="get" id="option_form">
            <select name="select" class="form-select" aria-label="Default select example" id="taskOption" onchange="selectChange();">
                <option value="1" <?= $mod == 1 ? 'selected' : '' ?>>펀드별</option>
                <option value="2" <?= $mod == 2 ? 'selected' : '' ?>>개인별</option>
                <option value="3" <?= $mod == 3 ? 'selected' : '' ?>>최근등록순</option>
            </select>
            <input type="submit" style="display:none;" value="submit the form" id="submit">
        </form>
        <div class="inv-group">
            <?php foreach ($b as $c) : ?>
                <div class="inv">
                    <p ><?= $c->number ?></p>
                    <p><?= $c->reg_date ?></p>
                    <p><?= $c->fundname ?></p>
                    <p><?= $c->email ?></p>
                    <p><a href="profil?user=<?= $c->name ?>"><?= $c->name ?></a></p>
                    <p><?= $c->pay ?></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div>
                    </div>
                    <button class="fund_btn" data-email="<?= $c->email ?>">투자펀딩계약서</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php if ($pg->prev) : ?>
                            <li class="page-item"><a class="page-link" href="/list?p=<?= $pg->start - 1 ?>"><<</a></li>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = $pg->start; $i <= $pg->end; $i++) : ?>
                            <li class="page-item "><a class="page-link" href="/list?p=<?= $i ?>&select=<?= $mod?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                        <?php if ($pg->next) : ?>
                            <li class="page-item"><a class="page-link" href="/list?p=<?= $pg->end + 1 ?>">>></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
            <script>
                let investor_data = JSON.parse(`<?= json_encode($b) ?>`);
                let fundImage = new Image();
                fundImage.src = "/image/funding.png";

                $(".fund_btn").on("click", (e) => {
                    console.log("d");
                    const email = e.currentTarget.dataset.email;
                    let find_data = investor_data.find(x => x.email == email);
                    let signImage = new Image();
                    signImage.src = find_data.sign;
                    signImage.addEventListener('load', () => {
                        const c = document.createElement("canvas");
                        c.width = 600;
                        c.height = 400;
                        const ctx = c.getContext("2d");
                        ctx.drawImage(fundImage, 0, 0, 600, 400);
                        ctx.fillText(find_data.number, 240, 150);
                        ctx.fillText(find_data.fundname, 240, 180);
                        ctx.fillText(find_data.name, 240, 210);
                        ctx.fillText(find_data.pay, 240, 240);
                        ctx.drawImage(signImage, 230, 310, 250, 100);

                        const href = c.toDataURL();
                        console.log(href);
                        const a = document.createElement("a");
                        a.href = href;
                        a.download = "download";
                        a.click();

                    });
                });

                $("#taskOption").on("change", () => {
                    let form = $("#option_form");
                    
                    // let form = $("#option_form").sub
                    // console.log(form);
                    // form.submit();
                });

                function selectChange(){
                    $("#submit").click();
                }
            </script>