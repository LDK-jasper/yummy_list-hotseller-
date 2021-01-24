<?php
/*

    +---------------------------------------------------------------+
    | 생성일 : 2021-01-24
    | 파일 설명 : 페이지 이동 및 메인
    +---------------------------------------------------------------+
    | 생성이력
    | 2021-01-24 [index]        : 메인 페이지 - 이덕규
    | 2021-01-24 [login]        : 로그인 페이지 - 이덕규
    | 2021-01-24 [register]     : 회원가입 페이지 - 이덕규
    | 2021-01-24 [ownerInfo]    : 업주 관리 페이지 - 이덕규
    | 2021-01-24 [addStore]     : 매장 등록 페이지 - 이덕규
    | 2021-01-24 [detailStore]  : 매장 상세보기 페이지 - 이덕규
    | 2021-01-24 [storeUpdate]  : 매장 정보 수정 페이지 - 이덕규
    +---------------------------------------------------------------+
    | 수정이력
    +---------------------------------------------------------------+
    
    
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
    }

    // 메인 페이지
    function index(){
        $objView = new stdClass();
        if($this->session->userdata('MEMBER_IDX') != null){
            $objView->memberIDX = $this->session->userdata('MEMBER_IDX');
            $objView->memberID = $this->session->userdata('MEMBER_ID');
            $objView->memberTY = $this->session->userdata('MEMBER_TY');
        }

        $this->load->model("Store_m");
        $storeModel = new Store_m;

        $searchType = $this->input->GET("searchType");  // 검색 타입
        $searchInput = $this->input->GET("searchInput");  // 검색 내용

        $param = new stdClass();
        $param->searchType = $searchType;
        $param->searchInput = $searchInput;

        $getStoreList = $storeModel->getStoreList($param);  // 매장 리스트
        $objView->getStoreList = $getStoreList;
        $objView->searchType = $searchType;
        $objView->searchInput = $searchInput;

        $viewData = new stdClass();
        $viewData->viewData = $objView;
        $this->load->view("main_v", $viewData);
    }

    // 로그인 페이지
    function login(){
        $this->load->view("login_v");
    }

    // 회원가입 페이지
    function register(){
        $this->load->view("register_v");
    }

    // 업주 관리 페이지
    function ownerInfo(){
        if(!isset($objView->memberTY) && $this->session->userdata('MEMBER_TY') == "user"){
            echo "<script>";
            echo "alert('업주만 이용할 수 있습니다.');";
            echo "location.href='/Main';";
            echo "</script>";
            return;
        }

        $this->load->model("Store_m");
        $storeModel = new Store_m;

        $param = new stdClass();
        $param->memberIDX = $this->session->userdata('MEMBER_IDX');
        $getStoreList = $storeModel->getStoreList($param);  // 업주가 등록한 매장 리스트

        $objView = new stdClass();
        $objView->storeList = $getStoreList;
        $viewData = new stdClass();
        $viewData->viewData = $objView;


        $this->load->view("owner_v", $viewData);
    }

     // 매장 등록
     function addStore(){
        if(!isset($objView->memberTY) && $this->session->userdata('MEMBER_TY') == "user"){
            echo "<script>";
            echo "alert('업주만 이용할 수 있습니다.');";
            echo "location.href='/Main';";
            echo "</script>";
            return;
        }
        $this->load->view("addStore_v");
    }

    // 매장 상세보기
    function detailStore(){
        $this->load->model("Store_m");
        $storeModel = new Store_m;

        $storeIDX = $this->input->GET("idx"); // 매장 IDX

        $param = new stdClass();
        $param->storeIDX = $storeIDX;

        $storeInfo = $storeModel->getStoreInfo($param);   // 매장 정보 가져오기
        $reviewList = $storeModel->getReviewList($param);  // 매장 리뷰 리스트 가져오기

        $objView = new stdClass();
        $objView->storeInfo = $storeInfo;
        $objView->reviewList = $reviewList;
        $objView->memberIDX = ($this->session->userdata('MEMBER_IDX') != null ? $this->session->userdata('MEMBER_IDX') : "");  // 유저 IDX
        $objView->memberTY = ($this->session->userdata('MEMBER_TY') != null ? $this->session->userdata('MEMBER_TY') : "");  // user = 일반 유저 / owner = 업주

        $viewData = new stdClass();
        $viewData->viewData = $objView;

        $this->load->view("detailStore_v", $viewData);
    }

}
