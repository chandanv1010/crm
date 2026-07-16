<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class CashCatalogue extends BaseController{

	private $table = 'cash_catalogue';

	public function __construct(){

	}

	public function save(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/cash/catalogue/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				$id = $this->request->getPost('id');
		 		$method = ($id > 0) ? 'update' : 'create';
		 		$save = $this->store(['method' => $method]);
		 		if($method == 'create'){
		 			$flag = $this->AutoloadModel->_insert([
		 				'data' => $save,
		 				'table' => $this->table,
		 			]);
		 		}else {
		 			$flag = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
		 		}
		 		if($flag > 0){
		 			$response['message'] = 'Lưu trữ bản ghi thành công!';
					$response['code'] = '10';
					echo json_encode($response);die();
		 		}else{
		 			$response['message'] = 'Có lỗi xảy ra, Lưu trữ bản ghi không thành công!';
					$response['code'] = '23';
					echo json_encode($response);die();
		 		}
	        }else{
	        	$response['message'] = $this->validator->listErrors();
				$response['code'] = '22';
				echo json_encode($response);die();
	        }

		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}


	private function store(array $param = []){
		helper('text');
		$data = $this->request->getPost('data');
		$store  = [];
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				if($val['name'] == 'id') continue;
				$store[$val['name']] = $val['value'];
			}
		}
		if(isset($param['method']) && $param['method'] == 'create'){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
		
		return $store;
	}
	

	private function validation(){
		$validate = [
			'title' => 'required',
		];

		$errorValidate = [
			'title' => [
				'required' => 'Bạn Phải Nhập Tiêu Đề',
			],
		];
		
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
