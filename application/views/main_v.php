<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="/inc/css.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>맛집</title>
</head>
<body>
    <h3 class="t-c">맛집 리뷰</h3>
    <div class="content">
        <?php if(isset($viewData->memberIDX)){ // 로그인 여부?>
        <div>
            [<?php echo $viewData->memberID;?>]님 환영합니다.(<?php echo $viewData->memberTY == "owner" ? "업주" : "일반 회원";?>)
            <?php if($viewData->memberTY == "owner"){ // 업주일 경우?>
                <button type="button" onclick="location.href='/Main/ownerInfo'">관리 페이지</button>
            <?php } ?>
            <button type="button" onclick="location.href='/Member/logOut'">로그아웃</button>
        </div>
        
        <?php }else{ ?>
        <div><button onClick="location.href='/Main/login'">로그인</button></div>
        <?php } ?>
        <div class="t-c">
            <form action="/Main" method="GET">
                <select id="searchType" name="searchType">
                    <option value="s_name">매장 이름</option>
                    <option value="s_kind">매장 분류</option>
                    <option value="s_addr">매장 주소</option>
                    <option value="s_phone">매장 번호</option>
                    <option value="s_menu">매장 메뉴</option>
                    <option value="s_tag">매장 태그</option>
                </select>
                <input placeholder="검색" name="searchInput" value="<?php echo $viewData->searchInput; // 검색 내용?>"/><button>검색</button>
            </form>
        </div>
        <div class="data-list non-dot">
            <ul class="f-b">
                <li>가게 이름</li>
                <li>분류</li>
                <li>주소</li>
                <li>전화번호</li>
                <li>메뉴</li>
                <li>해시태그</li>
                <li>리뷰</li>
            </ul>
            <?php foreach($viewData->getStoreList as $key => $val){  // 매장 리스트 출력?>
                <a href="/Main/detailStore?idx=<?php echo $val->s_idx; // 매장 idx?>">
                    <ul>
                        <li><?php echo $val->s_name; // 매장 이름?></li>
                        <li><?php echo $val->s_kind; // 매장 분류?></li>
                        <li><?php echo $val->s_addr; // 매장 주소?></li>
                        <li><?php echo $val->s_phone; // 매장 전화번호?></li>
                        <li><?php echo $val->s_menu; // 매장 메뉴?></li>
                        <li><?php echo $val->s_tag; // 매장 태그?></li>
                        <li><?php echo $val->count; // 리뷰 수량?>개</li>
                    </ul>
                </a>
            <?php } ?>
        </div>

        <script>
            document.getElementById("searchType").value = "<?php echo ($viewData->searchType == "" ? "s_name" : $viewData->searchType); ?>";
        </script>
        
    </div>
</body>
</html>