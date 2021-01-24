<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>매장 상세보기</title>
    <link rel="stylesheet" href="/inc/css.css">
</head>
<body>

    <h3 class="t-c"><?php echo $viewData->storeInfo->s_name; // 매장명?></h3>
    <div>
        <button type="button" onclick="javascript:history.back();">돌아가기</button>
    </div>
    <div>
        <ul class="non-dot p-0">
            <li>매장명&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $viewData->storeInfo->s_name?></li>
        </ul>
        <ul class="non-dot p-0">
            <li>매장 분류 : <?php echo $viewData->storeInfo->s_kind ?> </li>
        </ul>
        <ul class="non-dot p-0">
            <li>매장 주소 : <?php echo $viewData->storeInfo->s_addr ?> </li>
        </ul>
        <ul class="non-dot p-0">
            <li>매장 번호 : <?php echo $viewData->storeInfo->s_phone ?> </li>
        </ul>
        <ul class="non-dot p-0">
            <li>매장 메뉴 : <?php echo $viewData->storeInfo->s_menu ?> </li>
        </ul>
        <ul class="non-dot p-0">
            <li>매장 태그 : <?php echo $viewData->storeInfo->s_tag ?> </li>
        </ul>

        <div>
            <fieldset>
                <legend>리뷰 <?php echo count($viewData->reviewList)?>개</legend>
                <?php foreach($viewData->reviewList as $key => $val){?>
                    <ul class="non-dot border-b pb-15">
                        <li><?php echo $val->u_id; // 유저 ID?> (<?php echo $val->r_regDate; // 등록일?>) <br/><?php echo $val->r_content; // 리뷰 내용 ?></li>
                    </ul>
                <?php } ?>
            </fieldset>
        </div>
        <?php if($viewData->memberTY == "user"){ // 유저일 경우 ?>
            <textarea id="review-content" cols="50" rows="10" placeholder="리뷰 남기기"></textarea>
            <button type="button" onclick="fnc_insReview()">등록</button>
        <?php } ?>
        <div>
            
        </div>
    </div>

    <script>

        function fnc_insReview(){
            let con = document.getElementById("review-content").value;
            let storeIDX = <?php echo $viewData->storeInfo->s_idx?>;
            if(con.trim() == ""){
                alert("내용을 입력하여 주시기 바랍니다.");
                return;
            }
            let xhr = new XMLHttpRequest();
            let sendData = `content=${con}&storeIDX=${storeIDX}`;
            xhr.open("POST", "/Store/reviewIns", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(sendData);
            xhr.onload = function () {
                // xhr 객체의 status 값을 검사한다.
                if (xhr.status === 200) {
                    // 서버로 부터 받은 데이터를 처리할 코드
                    if(JSON.parse(xhr.response)["msg"] == true){
                        alert("등록이 완료되었습니다.");
                        location.reload();
                        return;
                    }
                }else{
                    alert("다시 시도하여 주시기 바랍니다.");
                    return;
                }
            }
        }

    </script>
</body>
</html>