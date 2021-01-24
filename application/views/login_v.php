<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>

    <form method="POST" action="/Member/memberLogin">    
        <div>
            <label><input name="login-type" value="user"  type="radio" checked>일반 회원</label>
            <label><input name="login-type" value="owner" type="radio">업주<label>
        </div>

        <div>
            <input name="member-id" id="member-id" placeholder="ID" required/>
            <input name="member-pw" id="member-pw" type="password" placeholder="PASSWORD" required/>
        </div>
        <div>
            <button type="submit">로그인</button>
            <button type="button" onClick="location.href='/Main/register'">회원가입</button>
        </div>
    </form>
</body>
</html>