<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Customer extends BaseController{

	private $table = 'customer';
	
	public function __construct(){

	}

	public function list(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/customer/customer/index'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$param = [
				'keyword' => $this->request->getGet('keyword'),
				'field' => $this->request->getGet('field'),
				'fieldKeyword' => $this->request->getGet('fieldKeyword'),
			];
			$keyword = '';
			if(!empty($param['keyword'])){
				$keyword = '(fullname LIKE \'%'.$param['keyword'].'%\')';
			}

			$listCustomer = $this->AutoloadModel->_get_where([
				'select' => $param['field'],
				'table' => $this->table,
				'where' => ['deleted_at' => 0, 'publish' => 1],
				'keyword' => $keyword
			], TRUE);

			if(isset($listCustomer) && is_array($listCustomer) && count($listCustomer)){
				$response['data'] = $listCustomer;
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
				echo json_encode($response);die();
			}else{
				$response['message'] = 'Không có dữ liệu phù hợp!';
				$response['code'] = '10';
			}

			echo json_encode($response);die();


		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function save(){

		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/customer/customer/create'
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
		 		$flag = 0;
		 		if($method == 'create'){
		 			$flag = $this->AutoloadModel->_insert([
		 				'data' => $save,
		 				'table' => $this->table,
		 			]);
		 			$response['id'] = $flag;
		 		}else{
		 			$flag = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $this->request->getPost('id')]
		 			]);
		 		}
	 			$response['email'] = $this->request->getPost('email');
	 			$response['phone'] = $this->request->getPost('phone');
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

	public function delete(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/customer/customer/delete'
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

	private function store(array $param = []){
		$store = $this->request->getPost('post');
		$store['fullname'] = $this->request->getPost('fullname');
		$store['phone'] = $this->request->getPost('phone');
		$store['email'] = $this->request->getPost('email');
		$store['catalogueid'] = $this->request->getPost('catalogueid');
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
			'email' => 'required|valid_email|check_customer_email_exist[email]',
			'phone' => 'required|check_customer_phone_exist[phone]',
			'fullname' => 'required',
			'catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'email' => [
				'check_customer_email_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			'phone' => [
				'check_customer_phone_exist' => 'Số điện thoại đã tồn tại trong hệ thống!',
			],
			'fullname' => [
				'required' => 'Bạn bắt buộc phải nhập vào ô tên của khách hàng'
			],
			'catalogueid' => [
				'is_natural_no_zero' => 'Bạn bắt buộc phải nhập vào nguồn khách hàng'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
	
}
