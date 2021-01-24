<?php
/*
    +---------------------------------------------------------------+
    | 생성일 : 2020-09-08
    | 파일 설명 : 유저 관련
    +---------------------------------------------------------------+
    | 생성이력
    | 2020-09-08 [memberLogin]      : 멤버 로그인 - 이덕규
    | 2020-09-08 [memberChkID]      : 멤버 아이디 중복 체크 - 이덕규
    | 2020-09-08 [memberRegister]   : 멤버 회원가입 - 이덕규
    +---------------------------------------------------------------+
*/
class Member_m extends Ci_model {

    function __construct()
    {
        parent::__construct();
        // $this->load->database();
    }

    // 멤버 로그인
    function memberLogin($param){
        $Ssql = "
            select * from tb_".$param->memberTY."
                where ".$param->col."_id = '".$param->memberID."'
        ";
        return $this->db->query($Ssql)->row();
    }

    // 멤버 아이디 중복 체크
    function memberChkID($param){
        $Ssql = "
            select * from tb_".$param->memberTY."
                where ".$param->col."_id = '".$param->memberID."'
        ";
        return $this->db->query($Ssql)->row();
    }

    // 멤버 회원가입
    function memberRegister($param){
        $Isql = "
            insert into tb_".$param->memberTY."(".$param->col."_id, ".$param->col."_pw, ".$param->col."_regDate)
            values('".$param->memberID."', '".$param->memberPW."', now())
        ";
        $this->db->query($Isql);
        return $this->db->insert_id();      // insert된 idx 리턴
    }
    

}
?>