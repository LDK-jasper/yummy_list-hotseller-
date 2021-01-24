<?php
/*

    +---------------------------------------------------------------+
    | 생성일 : 2021-01-24
    | 파일 설명 : 매장 관련
    +---------------------------------------------------------------+
    | 생성이력
    | 2021-01-24 [insStore]        : 매장 등록 - 이덕규
    | 2021-01-24 [reviewIns]       : 매장 리뷰 등록 - 이덕규
    | 2021-01-24 [selSearch]       : 검색 기능 - 이덕규
    +---------------------------------------------------------------+
    | 수정이력
    +---------------------------------------------------------------+
    
    
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
	}

    // 매장 등록
    function insStore(){
        $this->load->library("form_validation");
        $this->load->model("Store_m");
        $storeModel = new Store_m;

        $this->form_validation->set_rules("store-name", "매장명", "required");
        $this->form_validation->set_rules("store-kind", "매장 분류", "required");
        $this->form_validation->set_rules("store-addr", "매장 주소", "required");

        if($this->form_validation->run() == FALSE){
            echo "<script>";
            echo "alert('필수 사항이 누락되었습니다.');";
            echo "location.href='javascript:history.back();'";
            echo "</script>";
        }
        $param = new stdClass();
        $param->memberIDX = $this->session->userdata('MEMBER_IDX');  // 업주 IDX
        $param->storeName = $this->input->POST("store-name");       // 매장명
        $param->storeKind = $this->input->POST("store-kind");       // 매장 분류
        $param->storeAddr = $this->input->POST("store-addr");       // 매장 주소
        $param->storePhone = $this->input->POST("store-phone");     // 매장 전화번호
        $param->storeMenu = $this->input->POST("store-menu");       // 매장 메뉴
        $param->storeTag = $this->input->POST("store-tag");         // 매장 태그

        $result = $storeModel->storeIns($param);      // 매장 등록

        if($result > 0){
            echo "<script>";
            echo "alert('등록이 완료되었습니다.');";
            echo "location.href='/Main/ownerInfo'";
            echo "</script>";
        }else{
            echo "<script>";
            echo "alert('다시 시도하여 주시기 바랍니다.');";
            echo "location.href='javascript:history.back();'";
            echo "</script>";
        }

    }

    // 리뷰 등록
    function reviewIns(){        
        $this->load->model("Store_m");
        $storeModel = new Store_m;

        $content = str_replace("\r\n","<br/>",$this->input->POST("content"));   // 리뷰 개행 변환
        $content = str_replace("\n","<br/>",$this->input->POST("content"));   // 리뷰 개행 변환
        $content = addslashes($content); // addslashes
        $storeIDX = $this->input->POST("storeIDX");   // 리뷰 내용
        $param = new stdClass();
        $param->content   = $content;
        $param->storeIDX  = $storeIDX;
        $param->memberIDX = $this->session->userdata('MEMBER_IDX');  // 유저 IDX

        $resultData = $storeModel->insReview($param);
        $result = ($resultData > 0 ? true : false); // 리턴 타입
        
        echo json_encode(array("msg" => $result));
    }
}
