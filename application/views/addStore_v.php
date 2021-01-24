<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>매장 등록</title>
    <link rel="stylesheet" href="/inc/css.css">
</head>
<body>

    <h3>매장 등록</h3>
    
    <div>
        <form action="/Store/insStore" method="POST">
            <ul class="non-dot p-0">
                <li><input type="text" name="store-name" placeholder="매장명" required> 필수</li>
            </ul>
            <ul class="non-dot p-0">
                <li><input type="text" name="store-kind" placeholder="매장 분류" required> 필수</li>
            </ul>
            <ul class="non-dot p-0">
                <li><input type="text" name="store-addr" placeholder="매장 주소" required> 필수</li>
            </ul>
            <ul class="non-dot p-0">
                <li><input type="text" name="store-phone" placeholder="매장 전화번호"></li>
            </ul>
            <ul class="non-dot p-0">
                <li><input type="text" name="store-menu" placeholder="매장 메뉴"></li>
            </ul>
            <ul class="non-dot p-0">
                <li><input type="text" name="store-tag" placeholder="매장 태그"></li>
            </ul>
            <ul class="non-dot p-0">
                <li>
                    <button type="button" onclick="javascript:history.back();">돌아가기</button>
                    <button type="submit">등록</button>
                </li>
            </ul>
            
        </form>
    </div>
    
</body>
</html>