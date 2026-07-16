<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class CashCommon extends BaseController{

	private $table = 'cash_common';

	public function __construct(){

	}
	public function update(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' =>'backend/cash/common/update'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$id = $this->request->getPost('id');
			$object = $this->AutoloadModel->_get_where([
				'select' => 'title, catalogueid, money_collect, money_pay, description',
				'table' => $this->table,
				'where'=> ['id' => $id],
			]);
			$html = view('backend/cash/common/store',['object' => $object], ['saveData' => true]);
			if(isset($object ) && is_array($object ) && count($object )){
		 		$response['message'] = 'Truy xuất dữ liệu thành công!';
		 		$response['code'] = 10;
		 		$response['data'] = [
		 			'html' => $html,
		 		];

		 		echo json_encode($response); die();
		 	}else{
	 			$response['message'] = 'Có lỗi xảy ra, truy xuất dữ liệu bản ghi không thành công!';
				$response['code'] = '23';
				echo json_encode($response);die();
		 	}

		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code']= '24';
			echo json_encode($response);die();
		}
	}

	public function delete(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/cash/common/delete'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}
			$id = $this->request->getPost('id');
			$flag = $this->AutoloadModel->_update([
 				'data' => ['deleted_at' => 1],
 				'table' => $this->table,
 				'where' => ['id' => $id]
 			]);
 			if($flag > 0){
	 			$response['message'] = 'Xóa bản ghi thành công!';
				$response['code'] = '10';
				echo json_encode($response);die();
	 		}else{
	 			$response['message'] = 'Có lỗi xảy ra, Xóa bản ghi không thành công!';
				$response['code'] = '23';
				echo json_encode($response);die();
	 		}
 		}catch(\Exception $e){
 			$response['message'] = $e->getMessage();
 			$response['code'] = '24';
 			echo json_encode($response);die();
 		}
	}


	public function save(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/cash/common/create'
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
		$store = $this->request->getPost('data');

		$store['money_collect'] = convertMoney($store['money_collect']);
		$store['money_pay'] = convertMoney($store['money_pay']);
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
