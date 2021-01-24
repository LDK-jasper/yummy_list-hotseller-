<?php
/*
    +---------------------------------------------------------------+
    | 생성일 : 2020-09-08
    | 파일 설명 : 유저 관련
    +---------------------------------------------------------------+
    | 생성이력
    | 2020-09-08 [storeIns]        : 매장 등록 - 이덕규
    | 2020-09-08 [getStoreList]    : 매장 리스트 - 이덕규
    | 2020-09-08 [getStoreInfo]    : 1개의 매장 정보 - 이덕규
    | 2020-09-08 [getReviewList]   : 매장 리스트 - 이덕규
    | 2020-09-08 [insReview]       : 매장 리뷰 등록 - 이덕규
    +---------------------------------------------------------------+
*/
class Store_m extends Ci_model {

    function __construct()
    {
        parent::__construct();
    }

    // 매장 등록
    function storeIns($param){
        $Isql = "
            insert into tb_store(o_idx, s_name, s_kind, s_addr, s_phone, s_menu, s_tag, s_regDate)
            values('".$param->memberIDX."', '".$param->storeName."', '".$param->storeKind."', '".$param->storeAddr."', 
            '".$param->storePhone."', '".$param->storeMenu."', '".$param->storeTag."', now())
        ";
        $this->db->query($Isql);
        return $this->db->insert_id();      // insert된 idx 리턴
    }

    // 매장 리스트
    function getStoreList($param = ""){
        $addAnd = "";     // and절 추가
        if($param != "" && isset($param->memberIDX)){      // 업주 IDX 추가
            $addAnd = " and o_idx = ".$param->memberIDX;
        }else if($param != "" && isset($param->searchType)){ // 검색 기능
            $addAnd = " and ".$param->searchType." like '%".$param->searchInput."%' ";
        }

        $Ssql = "
            select s.*, count(r.u_idx) as count from tb_store as s
            left outer join tb_review as r
                on s.s_idx = r.s_idx
                    where 1=1
        ".$addAnd."
            group by s.s_idx
        ";
        
        return $this->db->query($Ssql)->result();
    }

    function getStoreInfo($param){
        $Ssql = "
            select * from tb_store
                where s_idx = ".$param->storeIDX;
        return $this->db->query($Ssql)->row();
    }

    // 리뷰 리스트
    function getReviewList($param){
        
        $sql = "set names utf8mb4 ;";   // 이모지
        $this->db->query($sql);

        $Ssql = "
            select u.*, r.r_content, r_regDate from hotseller.tb_user as u
            join hotseller.tb_review as r
                on u.u_idx = r.u_idx 
            where r.s_idx = ".$param->storeIDX."
            order by r_regDate
        ";
                
        return $this->db->query($Ssql)->result();
    }

    // 리뷰 등록
    function insReview($param){

        $sql = "set names utf8mb4 ;";   // 이모지
        $this->db->query($sql);

        $Isql = "
            insert into tb_review(s_idx, u_idx, r_content, r_regDate)
            values('".$param->storeIDX."', '".$param->memberIDX."', '".$param->content."', now())
        ";
        $this->db->query($Isql);
        return $this->db->insert_id();      // insert된 idx 리턴
        // return $Isql;

    }
    

}
?>