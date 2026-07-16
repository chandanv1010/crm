<?php 
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Incident extends BaseController{

	private $table = 'incident';
	
	public function __construct(){

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
				$id = $this->request->getPost('customerid');
				$method = 'create';
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
		 		} 
		 		if($flag > 0){
		 			$response['description'] = $save['description'];
		 			$response['created_at'] = $save['created_at'];
		 			$department = $this->AutoloadModel-> _get_where([
		 				'select' =>'title',
		 				'table' => 'user_catalogue',
		 				'where' => ['id' => $save['user_catalogueid']],
		 			]);
		 			$response['department'] = $department['title'];
		 			
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
		
		$store['description'] = $this->request->getPost('description');
		$store['user_catalogueid'] = $this->request->getPost('user_catalogueid');
		$store['customerid'] = $this->request->getPost('customerid');
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
			'description' => 'required',
			'user_catalogueid' => 'is_natural_no_zero',
		];
		$errorValidate = [
			'description' => [
				'required' => 'Bạn chưa nhập nội dung vấn đề!',
			],
			'user_catalogueid' => [
				'is_natural_no_zero' => 'Bạn chưa chọn phòng ban!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
	
}
