<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class CashPeriodic extends BaseController{

	private $table = 'cash_periodic';

	public function __construct(){

	}

	public function save(){
		try{
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/cash/periodic/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$save = $this->store();
	 			$id = $this->request->getPost('id_newest');
	 			$money_end = 0;
	 			if(isset($id)&& $id != ''){
		 			// tinh ton thang truoc
		 			$money_box = get_money_month($id);
		 			$prev_month = $this->AutoloadModel->_get_where([
							'select' => 'money_end, money_start',
							'table' => 'cash_periodic',
							'where' => ['id' => $id, 'publish' => 1, 'deleted_at' => 0],
						]);
		 			$money_end = $prev_month['money_start'] + $money_box['exist'];
		 			$data = ['money_end' => $money_end];
		 			$flag_1 = $this->AutoloadModel->_update([
		 				'data' => $data,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
	 				$save['money_start'] = convertMoney($money_end);
	 			}
	 			$flag = $this->AutoloadModel->_insert([
	 				'data' => $save,
	 				'table' => $this->table,
	 			]);
		 		if($flag > 0){
					// lay chi tieu mac dinh
					$commonList = $this->AutoloadModel->_get_where([
						'select' => 'title, catalogueid, money_collect, money_pay, description, userid_created',
						'table' => 'cash_common',
						'where' => ['publish' => 1, 'deleted_at' => 0],
					], true);
					if(isset($commonList) && is_array($commonList) && count($commonList)){
						foreach ($commonList as $key => $value) {
							$commonList[$key]['created_at'] = $save['date_start'];
							$commonList[$key]['periodicid'] = $flag;
							$commonList[$key]['publish'] = 1;
						}
						//add chi tieu mac dinh vao chi tieu
						$flag = $this->AutoloadModel->_create_batch([
							'data' => $commonList,
							'table' => 'cash',
						]);
					}
					if($flag > 0){
						$response['message'] = 'Lưu trữ bản ghi thành công!';
						$response['code'] = '10';

						echo json_encode($response);die();
					}

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


	private function store(){
		helper('text');
		$data = $this->request->getPost('data');
		$store  = [];
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				if($val['name'] == 'id') continue; 
				$store[$val['name']] = $val['value'];
			}
		}
		$store['money_end'] = convertMoney($this->request->getPost('money_end'));
		$store['money_start'] = convertMoney($this->request->getPost('money_start'));
		$store['date_start'] = convertTime($this->request->getPost('date_start'));

		$store['date_end'] = convertTime($store['date_end']);
		$store['date_start'] = gettime($store['date_start'],'Y-m-d').' 00:00:00';
		$store['date_end'] = gettime($store['date_end'],'Y-m-d').' 00:00:00';
		$store['created_at'] = $this->currentTime;
		$store['userid_created'] = $this->auth['id'];
		$store['publish'] = 1;
		return $store;
	}
	

	private function validation(){
		$validate = [
			'title' => 'required',
			'date_end' => 'required',
		];

		$errorValidate = [
			'title' => [
				'required' => 'Bạn Phải Nhập Tiêu Đề',
			],
			'date_end' => [
				'required' => 'Bạn Phải Nhập Ngày Kết Thúc!',
			],
		];
		
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
