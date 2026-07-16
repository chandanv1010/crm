<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class ContractDomain extends BaseController{

	private $table = 'contract_domain';

	public function __construct(){

	}

	public function getDataBeforeInsert(){
		try{
			$postid['id'] = $this->request->getPost('id');
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/contract/domain/create'
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
				12 => '1 năm',
				24 => '2 năm',
				36 => '3 năm',
				48 => '4 năm',
			);
			// loai domain
			$domain_list = $this->AutoloadModel->_get_where([
				'table' => 'domain',
				'select' => 'id, title, price_sell, price_extend',
				'where' => ['publish' => 1, 'deleted_at' => 0],
				'order_by' => 'title asc',
			], true);
			foreach ($domain_list as $key => $value) {
				$domain_list[$key]['price_sell'] = number_format($value['price_sell'], 0, ',', '.');
				$domain_list[$key]['price_extend'] = number_format($value['price_extend'], 0, ',', '.');
			}
			$price_sell = convert_array([
				'data' => $domain_list,
				'field' => 'id',
				'value'=> 'price_sell',
				'text' => '',
			]);
			$price_extend = convert_array([
				'data' => $domain_list,
				'field' => 'id',
				'value'=> 'price_extend',
				'text' => '',
			]);

			$domainid = convert_array([
				'data' => $domain_list,
				'field' => 'id',
				'value' => 'title',
				'text' => 'loại domain',
			]);
			$selectUpdate = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, userid, timeline, domainid, price ',
				'table' => $this->table,
				'where' => ['id' => $postid['id']]
			]);

			if(is_array($domain_list) == false || is_array($staff) == false){
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
					'domainid' =>$domainid,
					'price_sell' =>$price_sell,
					'price_extend' => $price_extend,
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
				'select' => '(SELECT fullname FROM user WHERE user.id = contract_domain_detail.userid) as userid, (SELECT title FROM domain WHERE domain.id = contract_domain_detail.domainid) as domain_title, price, date_start, date_end, objectid, total, timeline,(SELECT domain FROM contract_domain WHERE contract_domain.id = '.$id.') as domain',
				'table' => 'contract_domain_detail',
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
				'routes' => 'backend/contract/domain/create'
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
		 				'select' => 'userid, domainid, price, total , date_start, date_end, timeline, description ',
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);
		 			$object['objectid']=  $id;

		 			$flag_1 = $this->AutoloadModel->_update([
		 				'data' => $save,
		 				'table' => $this->table,
		 				'where' => ['id' => $id]
		 			]);

		 			if($flag_1){
		 				$flag = $this->AutoloadModel->_insert([
			 				'data' => $object,
			 				'table' => 'contract_domain_detail',
			 			]);
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
			'domain' => 'required',
			'domainid' => 'is_natural_no_zero',
			'userid' => 'is_natural_no_zero',
			'timeline' => 'is_natural_no_zero',
			'date_start' => 'required',
		];

		$errorValidate = [
			'customerid' => [
				'is_natural_no_zero' => 'Bạn Phải Nhập Thông Tin Khách Hàng!',
			],
			'domain' => [
				'required' => 'Bạn Phải Nhập Tên Miền!',
			],
			'domainid' => [
				'is_natural_no_zero' => 'Bạn Phải Chọn IP_VPS!',
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
		
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
