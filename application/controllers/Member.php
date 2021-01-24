<?php
/*

    +---------------------------------------------------------------+
    | 생성일 : 2021-01-24
    | 파일 설명 : 멤버 관련
    +---------------------------------------------------------------+
    | 생성이력
    | 2021-01-24 [memberLogin]   : 멤버 로그인 - 이덕규
    | 2021-01-24 [memberJoin]    : 멤버 회원가입 - 이덕규
    | 2021-01-24 [memberChkID]   : 멤버 아이디 중복 체크 - 이덕규
    | 2021-01-24 [sessionSet]    : 세션 등록 - 이덕규
    | 2021-01-24 [logOut]        : 멤버 로그아웃 - 이덕규
    +---------------------------------------------------------------+
    | 수정이력
    +---------------------------------------------------------------+
    
    
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
	}

    // 멤버 로그인
    function memberLogin(){
        $this->load->library("encrypt");
        $this->load->library("form_validation");
        $this->load->model("Member_m");
        $memberModel = new Member_m;
        
        // form 체크
        $this->form_validation->set_rules("member-id", "아이디", "required");
        $this->form_validation->set_rules("member-pw", "비밀번호", "required");

        if($this->form_validation->run() == FALSE){
            echo "<script>";
            echo "alert('아이디 또는 비밀번호를 입력하여 주시기 바랍니다.')";
            echo "location.href='/Main/login'";
            echo "</script>";
        }

        
        $memberID = $this->input->POST("member-id");    // 멤버 ID
        $memberPW = $this->input->POST("member-pw");    // 멤버 PW
        $memberTY = $this->input->POST("login-type");   // 로그인 타입(user = 일반 회원 / owner = 업주)

        $param = new stdClass();
        $param->memberID = addslashes($memberID);
        $param->memberPW = addslashes($this->encrypt->encode($memberPW, "lake_h_^&"));
        $param->memberTY = $memberTY;
        $param->col = substr($memberTY, 0, 1);      // 컬럼 구분


        $result = $memberModel->memberLogin($param);  // 유저 정보
        if($result){  // 로그인 성공
            if((isset($result->o_idx) && $param->memberPW != $result->o_pw) &&
                (isset($result->u_idx) && $param->memberPW != $result->u_pw))
               {
                echo "<script>";
                echo "alert('아이디 또는 비밀번호를 확인 주시기 바랍니다.[1]');";
                echo "location.href='/Main/login';";
                echo "</script>";
                return;
            }
            $param->memberIDX = (isset($result->o_idx) ? $result->o_idx : $result->u_idx);   // 일반 IDX 또는 업주 IDX
            $param->memberID = stripslashes($param->memberID);          // addslashes 제거
            $this->sessionSet($param);
            echo "<script>";
            echo "location.href='/Main'";
            echo "</script>";

        }else{ // 로그인 실패
            echo "<script>";
            echo "alert('아이디 또는 비밀번호를 확인 주시기 바랍니다.[2]');";
            echo "location.href='/Main/login';";
            echo "</script>";
        }
    }

    // 멤버 회원가입
    function memberJoin(){
        $this->load->library("encrypt");
        $this->load->library("form_validation");
        $this->load->model("Member_m");
        $memberModel = new Member_m;
        
        // form 체크
        $this->form_validation->set_rules("register-type", "회원가입 타입", "required");
        $this->form_validation->set_rules("register-id", "아이디", "required");
        $this->form_validation->set_rules("register-pw", "비밀번호", "required");

        if($this->form_validation->run() == FALSE){
            echo "<script>";
            echo "alert('아이디 또는 비밀번호를 입력하여 주시기 바랍니다.')";
            echo "location.href='/Main/login'";
            echo "</script>";
        }

        $memberID = $this->input->POST("register-id");    // 멤버 ID
        $memberPW = $this->input->POST("register-pw");    // 멤버 PW
        $memberTY = $this->input->POST("register-type");   // 로그인 타입(user = 일반 회원 / owner = 업주)

        $param = new stdClass();
        $param->memberID = addslashes($memberID);
        $param->memberPW = addslashes($this->encrypt->encode($memberPW, "lake_h_^&"));     // 비밀번호 암호화
        $param->memberTY = $memberTY;
        $param->col = substr($memberTY, 0, 1);      // 컬럼 구분

        $chkID = count($memberModel->memberChkID($param));   // 아이디 중복 체크
        if($chkID){
            echo "<script>";
            echo "alert('존재하는 아이디 입니다.');";
            echo "location.href='javascript:history.back()';";
            echo "</script>";
            return;
        }
        $result = $memberModel->memberRegister($param);  // 회원가입
        if($result > 0){
            
            $param->memberIDX = $result;
            $param->memberID = stripslashes($param->memberID);          // addslashes 제거
            $this->sessionSet($param);
            echo "<script>";
            echo "location.href='/Main';";
            echo "</script>";
            return;
        }else{
            echo "<script>";
            echo "alert('다시 시도하여 주시기 바랍니다.');";
            echo "location.href='javascript:history.back()';";
            echo "</script>";
            return;
        }
    }

    // 멤버 아이디 중복 체크
    function memberChkID(){
        $this->load->model("Member_m");
        $memberModel = new Member_m;
        $param = new stdClass();
        $param->memberTY = $this->input->POST("registerType");      // 회원 타입(user = 일반 회원 / owner = 업주)
        $param->memberID = $this->input->POST("registerID");          // 회원 ID
        $param->col = substr($this->input->POST("registerType"), 0, 1);      // 컬럼 구분

        $result = count($memberModel->memberChkID($param));
        
        echo json_encode(array("msg" => $result));
    }

   


    // 세션 등록
    function sessionSet($param){
        $sessionData = array(
            'MEMBER_IDX'        => $param->memberIDX,           // 멤버 IDX
            'MEMBER_ID'         => $param->memberID,            // 멤버 ID
            'MEMBER_TY'         => $param->memberTY             // 멤버 유형(o = 업주 / u = 유저)
        );
        $this->session->set_userdata($sessionData);
    }

    // 로그아웃
    function logOut(){
        session_destroy();
        echo "<script>";
        echo "location.href='/Main';";
        echo "</script>";
    }



}
