<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class ContractHosting extends BaseController{

	private $table = 'contract_hosting';

	public function __construct(){

	}

	public function getDataBeforeInsert(){
		try{
			$postid['id'] = $this->request->getPost('id');
			// pre($postid['id']);
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/contract/hosting/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}
			// nguoi phu trach
			$staff = $this->AutoloadModel->_get_where([
				'table' => 'user',
				'select' => 'fullname, id',
				'where' => ['publish' => 1, 'deleted_at' => 0],
				'order_by' => 'fullname asc',
			], true);
			$staff = convert_array([
				'data' => $staff,
				'field' => 'id',
				'value' => 'fullname',
				'text' => 'người phụ trách',
			]);
			// thoi gian thue
			$timeline = array(
				0 => '- Chọn thời gian -',
				12 => '12 tháng',
				18 => '18 tháng',
				24 => '24 tháng',
				30 => '30 tháng',
				36 => '36 tháng',
				42 => '42 tháng',
				48 => '48 tháng',
				54 => '54 tháng',
				60 => '60 tháng',
				66 => '66 tháng',
				72 => '72 tháng',
			);

			// loai dich vu
			$service = $this->AutoloadModel->_get_where([
				'table' => 'hosting',
				'select' => 'id, title, price',
				'where' => ['publish' => 1, 'deleted_at' => 0],
				'order_by' => 'title asc',
			], true);
			foreach ($service as $key => $value) {
				$service[$key]['price'] = number_format($value['price'], 0, ',', '.');
			}

			$price = convert_array([
				'data' => $service,
				'field' => 'id',
				'value'=> 'price',
				'text' => '',
			]);

			$service = convert_array([
				'data' => $service,
				'field' => 'id',
				'value' => 'title',
				'text' => 'loại dịch vụ',
			]);

			// ip vps
			$ip_vps = $this->AutoloadModel->_get_where([
				'table' => 'vps',
				'select' => 'id, ip',
				'where' => ['publish' => 1, 'deleted_at' => 0],
				'order_by' => 'id asc',
			], true);

			$ip_vps = convert_array([
				'data' => $ip_vps,
				'field' => 'id',
				'value' => 'ip',
				'text' => 'Ip VPS',
			]);

			$selectUpdate = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, userid, timeline, service, ip_vps ',
				'table' => 'contract_hosting',
				'where' => ['id' => $postid['id']]
			]);


			if(is_array($service) == false || is_array($ip_vps) == false || is_array($staff) == false){
				$response['message'] = 'Có lỗi xảy ra trong quá trình truy xuất dữ liệu';
				$response['code'] = '23';
				echo json_encode($response);die();
			}else{
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
				$response['data'] = [
					'staff' => $staff,
					'selectUpdate' => $selectUpdate,
					'timeline' => $timeline,
					'service' =>$service,
					'ip_vps' =>$ip_vps,
					'price' => $price,
				];
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}


	public function getInforContract() {
		try{
			$id = $this->request->getPost('id');
			$response['message'] = '';
			$response['code'] = 0;

			$inforContract = $this->AutoloadModel->_get_where([
				'select' => '(SELECT fullname FROM user WHERE user.id = contract_hosting_detail.userid) as userid,(SELECT ip FROM vps WHERE vps.id = contract_hosting_detail.ip_vps ) as ip_vps , (SELECT title FROM hosting WHERE hosting.id = contract_hosting_detail.service) as service, price, type, date_start, add_payment, date_end, objectid, total, timeline,(SELECT domain FROM contract_hosting WHERE contract_hosting.id = '.$id.') as domain',
				'table' => 'contract_hosting_detail',
				'where' => ['objectid' => $id],
			], TRUE);
			if(!is_array($inforContract)){
				$response['message'] = 'Dữ liệu không tồn tại!!';
				$response['code'] = '23';
				echo json_encode($response);die();
			}else{
				$response['message'] ='Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
				foreach ($inforContract as $key => $value) {
					$inforContract[$key]['date_start'] = gettime($value['date_start'], 'd/m/Y');
					$inforContract[$key]['date_end'] = gettime($value['date_end'], 'd/m/Y');
					$inforContract[$key]['price'] = number_format($value['price'], 0, ',', '.');
					$inforContract[$key]['total'] = number_format($value['total'], 0, ',', '.');
				}
				$response['data'] = $inforContract;

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
				'routes' => 'backend/contract/hosting/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}

			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				$id = $this->request->getPost('id');
				$method = $this->request->getPost('method');
		 		$save = $this->store(['method' => $method]);
		 		$flag = 0;
		 		if($method == 'create'){
		 			$flag = $this->AutoloadModel->_insert([
		 				'data' => $save,
		 				'table' => $this->table,
		 			]);
		 		}else if($method == 'update'){
		 			$flag = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
		 		}else if($method == 'extend'){
		 			$object = $this->AutoloadModel->_get_where([
		 				'select' => 'userid, ip_vps, service, price, total , date_start, date_end, timeline, description ',
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
		 			$object['objectid']=  $id;
		 			$object['type']=  'gia hạn';

		 			$flag_1 = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);

		 			if($flag_1){
		 				$flag = $this->AutoloadModel->_insert([
			 				'data' => $object,
			 				'table' => 'contract_hosting_detail',
			 			]);
		 			}
		 		}else if($method == 'upgrade'){
		 			$object = $this->AutoloadModel->_get_where([
		 				'select' => 'userid, ip_vps, service, price, total , date_start, date_end, timeline, description ',
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
		 			$object['objectid']=  $id;
		 			$object['type']=  'nâng cấp';
		 			$data = $this->request->getPost('post');
		 			$data_sub = array_column($data,'value','name');
		 			$object['add_payment']=  $data_sub['totalFinal'];
		 			$object['date_end']=  $this->currentTime;
		 			$flag_1 = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);

		 			if($flag_1){
		 				$flag = $this->AutoloadModel->_insert([
			 				'data' => $object,
			 				'table' => 'contract_hosting_detail',
			 			]);
		 			}
		 		}
		 		
		 		$post = $this->request->getPost('post');
		 		$check = false;
		 		foreach ($post as $key => $value) {
		 			if($value['name'] == 'money_default'){
		 				if($value['value'] == 1){
		 					$check = true;
		 				}
		 			}
		 		}
		 		$data_sub = array_column($post,'value','name');
		 		if($check == true){
		 			$save['method'] = $method;
		 			if($save['method'] == 'create'){
			 			$save['id'] = $flag;
			 		}else{
			 			$save['id'] = $id;
			 		}
			 		if($save['method'] == 'upgrade'){
			 			$domain = $this->AutoloadModel->_get_where([
			 				'select' => ' domain ',
			 				'table' => $this->table,
			 				'where' => ['id' => $id]
			 			]);
			 			$save = $save + $domain;
			 			$save['add_payment']=  $data_sub['totalFinal'];
		 				$save['date_start']=  $this->currentTime;
			 		}
			 		if($save['method'] == 'extend'){
		 				$save['date_start']=  gettime($this->currentTime,'Y-m-d').' 00:00:00';
			 		}
		 			$save['catalogueid'] = 8;
		 			$accept_insert_money = accept_insert_money($save);
		 			if($accept_insert_money == 0){
		 				$response['message'] = 'Có lỗi xảy ra, Lưu trữ bản ghi QL tiền mặt không thành công!';
						$response['code'] = '141';
						echo json_encode($response);die();
		 			}
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
		$data = $this->request->getPost('post');
		$store  = [];
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				if($val['name'] == 'id') continue;
				if($val['name'] == 'method') continue;
				if($val['name'] == 'totalFinal') continue;
				$store[$val['name']] = $val['value'];
			}
		}
		$store['date_start'] = str_replace('/','-',$store['date_start']);
		$store['date_end'] = str_replace('/','-',$store['date_end']);
		$store['total'] = convertMoney($store['total']);
		$store['price'] = convertMoney($store['price']);
		$store['date_start'] = gettime($store['date_start'],'Y-m-d').' 00:00:00';
		$store['date_end'] = gettime($store['date_end'],'Y-m-d').' 00:00:00';
		if(isset($param['method']) && $param['method'] == 'create'){
			$store['contract_code'] = 'HT0001';
			$store['code'] = md5($store['domain'].random_string('alnum', 168));
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
			'customerid' => 'is_natural_no_zero',
			'ip_vps' => 'is_natural_no_zero',
			'service' => 'is_natural_no_zero',
			'userid' => 'is_natural_no_zero',
			'timeline' => 'is_natural_no_zero',
			'date_start' => 'required',
		];

		$errorValidate = [
			'customerid' => [
				'is_natural_no_zero' => 'Bạn Phải Nhập Thông Tin Khách Hàng!',
			],
			'ip_vps' => [
				'is_natural_no_zero' => 'Bạn Phải Chọn IP_VPS!',
			],
			'service' => [
				'is_natural_no_zero' => 'Bạn Phải Chọn Gói Dịch Vụ!',
			],
			'userid' => [
				'is_natural_no_zero' => 'Bạn Phải Chọn Người Phụ Trách!',
			],
			'timeline' => [
				'is_natural_no_zero' => 'Bạn Phải Chọn Thời Gian dịch Vụ!',
			],
			'date_start' => [
				'required' => 'Bạn Phải Nhập Ngày Khởi Tạo!',
			],
		];

		if($this->request->getPost('method') != 'upgrade'){
			$validate['domain'] = 'required';
			$errorValidate ['domain'] = ['required' => 'Bạn Phải Nhập Tên Miền!',];
		}
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
