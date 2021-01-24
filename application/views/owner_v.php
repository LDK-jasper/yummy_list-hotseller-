<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>업주 관리 페이지</title>
    <link rel="stylesheet" href="/inc/css.css">
</head>
<body>

    <h3 class="t-c">업주 관리 페이지</h3>
    <div>
        <div>
            <button onclick="location.href='/Main'">돌아가기</button>
            <button onclick="location.href='/Main/addStore'">매장 등록</button>
        </div>
        <div class="data-list non-border">
            <fieldset class="h-400">
                <legend>등록한 매장</legend>
                <ul class="f-b non-dot">
                    <li>가게 이름</li>
                    <li>분류</li>
                    <li>주소</li>
                    <li>전화번호</li>
                    <li>메뉴</li>
                    <li>해시태그</li>
                    <li>리뷰</li>
                </ul>
                <?php foreach($viewData->storeList as $key => $val){?>
                    <a href="/Main/detailStore?idx=<?php echo $val->s_idx; // 매장 idx?>">
                        <ul class="non-dot">
                            <li><?php echo $val->s_name; // 매장명?></li>
                            <li><?php echo $val->s_kind; // 매장 분류?></li>
                            <li><?php echo $val->s_addr; // 매장 주소?></li>
                            <li><?php echo $val->s_phone; // 매장 전화번호?></li>
                            <li><?php echo $val->s_menu; // 매장 메뉴?></li>
                            <li><?php echo $val->s_tag; // 매장 태그?></li>
                            <li><?php echo $val->count; // 리뷰 수량?></li>
                        </ul>
                    </a>
                <?php } ?>
            </fieldset>
        </div>
    </div>
    
    
</body>
</html>