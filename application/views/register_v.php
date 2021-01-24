<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link rel="stylesheet" href="/inc/css.css">
</head>
<body>

    <script>
        let chkID = false;  // 아이디 중복 체크 플래그

        // 아이디 중복 체크 확인 여부
        function fnc_chkID(){
            if(!chkID){
                alert("아이디 중복 체크를 확인하여 주시기 바랍니다.");
                document.getElementById("register-id").focus();
                return false ;
            }
            return true;
        }
        // 아이디 중복 체크
        function fnc_memberChkID(){
            let registerID = document.getElementById("register-id").value;  // 멤버 ID
            let registerType = document.querySelector('input[name="register-type"]:checked').value; // 라디오버튼 체크 값
            let xhr = new XMLHttpRequest();
            let sendData = `registerID=${registerID}&registerType=${registerType}`;
            xhr.open("POST", "/Member/memberChkID", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(sendData);
            xhr.onload = function () {
                // xhr 객체의 status 값을 검사한다.
                if (xhr.status === 200) {
                    // 서버로 부터 받은 데이터를 처리할 코드
                    if(JSON.parse(xhr.response)["msg"] == true){
                        alert("존재하는 아이디 입니다.");
                        document.getElementById("register-id").focus();
                        chkID = false;
                        return;
                    }else{
                        alert("사용 가능합니다.")
                        chkID = true;
                    }
                }else{
                    alert("다시 시도하여 주시기 바랍니다.");
                    return;
                }
            }
        }
    </script>

    <div>
        <form action="/Member/memberJoin" name="register_frm" onsubmit="return fnc_chkID();" method="POST">
            <div>
                <ul class="non-dot p-0">
                    <li>
                        <label><input name="register-type" type="radio" value="user" checked>일반 유저</label>
                        <label><input name="register-type" type="radio" value="owner">업주</label>
                    </li>
                </ul>
                <ul class="non-dot p-0">
                    <li>
                        <input type="text" name="register-id" id="register-id" onkeypress="javascript:chkID = false" placeholder="아이디" required>
                        <button type="button" onclick="fnc_memberChkID();">아이디 중복 체크</button>
                    </li>
                </ul>
                <ul class="non-dot p-0">
                    <li>
                        <input type="password" name="register-pw" placeholder="비밀번호" required>
                    </li>
                </ul>
            </div>
            <div>
                <button type="button" onclick="javascript:history.back()">돌아가기</button>
                <button type="submit">회원가입</button>
            </div>
        </form>
    </div>

    
    
</body>
</html>