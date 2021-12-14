</head>
<body>
    <div class="join-container flex-center">
    <form action="/join" method="post">
    <span>아이디</span><input type="text" required  name="id" id="id">
    <label for="name">이름</label>
    <input type="text" name="name" id="name">
    <label for="password">비밀번호</label>
    <input type="text" name="password" id="password">
    <label for="passwordc">비밀번호 확인</label>
    <input type="text" name="passwordc" id="passwordc">
    <label for="email">이메일</label>
    <input type="text" name="email" id="email">
    <button id="btn">가입하기</button>
    </form>
    </div>
    <script>
        $("#id").on("input", function(e) {
            console.log(e.target.value);
        })
    </script>

