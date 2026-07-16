<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Vps extends BaseController{

	private $table = 'vps';
	
	public function __construct(){

	}

	public function save(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/service/vps/create'
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
		 		}else{
		 			$flag = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $this->request->getPost('id')]
		 			]);
		 			$response['email'] = $this->request->getPost('email');
		 			$response['phone'] = $this->request->getPost('phone');
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
		$store = $this->request->getPost('post');
		$store['title'] = $this->request->getPost('title');
		$store['ip'] = $this->request->getPost('ip');
		$store['disk_space'] = $this->request->getPost('disk_space');
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
			'ip' => 'required',
		];
		$errorValidate = [
			'title' => [
				'required' => 'Bạn bắt buộc phải nhập vào tên VPS!',
			],
			'ip' => [
				'required' => 'Bạn bắt buộc phải nhập vào Ip!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
	
}
