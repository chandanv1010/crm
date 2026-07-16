<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;

class ContractWebsite extends BaseController{

	private $table = 'contract_website';
	public $nestedsetbie;
	public function __construct(){
	}

	public function getDataBeforeInsert(){
		try{
			$postid['id'] = $this->request->getPost('id');
			// pre($postid['id']);
			$response['message'] = '';
			$response['code'] = 0;
			$flag = $this->authentication->check_permission([
				'routes' => 'backend/contract/website/create'
			]);
			if($flag == false){
				$response['message'] = 'Bạn không có quyền truy cập vào chức năng này!';
				$response['code'] = '21';
				echo json_encode($response);die();
			}
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
			$selectUpdate = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, userid, process, status',
				'table' => 'contract_website',
				'where' => ['id' => $postid['id']]
			]);
			$status = getOption('status');
			$process = getOption('process');
			if(is_array($status) == false || is_array($process) == false || is_array($staff) == false){
				$response['message'] = 'Có lỗi xảy ra trong quá trình truy xuất dữ liệu';
				$response['code'] = '23';
				echo json_encode($response);die();
			}else{
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
				$response['data'] = [
					'staff' => $staff,
					'selectUpdate' => $selectUpdate,
					'status' => $status,
					'process' =>$process,
				];
				echo json_encode($response);die();
			}
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function getDisplayCatalogue(){
		try{
			$data = $this->AutoloadModel->_get_where([
				'select' => 'id, title',
				'table' => 'function',
			], TRUE);
			$html = '<select name="parentid" id="parentid" class="form-control input-sm parentid  mr10" ><option value="0">Không có thuộc tính cha</option>';
			if(isset($data) && is_array($data) && count($data)){
				foreach ($data as $key => $value) {
					$html = $html.'<option value="'.$value['id'].'">'.$value['title'].'</option>';
				}
			}
			$html = $html.' </select>';
			echo $html;die();
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}
	public function insertFunction(){
		try{
			$this->nestedsetbie = new Nestedsetbie(['table' => 'function']);
			$param['title'] = validate_input($this->request->getPost('title'));
			$param['keyword'] = $this->request->getPost('keyword');
			$param['parentid'] = $this->request->getPost('parentid');
			$param['id'] = $this->request->getPost('id');
			$param['status'] = $this->request->getPost('status');
			if($param['id'] == ''){
				$data = [
					'title' => $param['title'],
					'keyword' => $param['keyword'],
					'parentid' => $param['parentid'],
					'deleted_at' => 0,
				];
				$flag = $this->AutoloadModel->_insert([
					'table' => 'function',
					'data' => $data
				]);
				if($flag > 0){
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
				}
			}else{
				$data = [
					'title' => $param['title'],
					'keyword' => $param['keyword'],
					'parentid' => $param['parentid'],
				];
				$flag = $this->AutoloadModel->_update([
					'table' => 'function',
					'data' => $data,
					'where' => [
						'deleted_at' => 0,
						'id' => $param['id']
					]
				]);
				if($flag > 0){
					$this->nestedsetbie->Get('level ASC, order ASC');
					$this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
					$this->nestedsetbie->Action();
				}
			}
			echo(json_encode($param));die();

		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function updateDisplayCatalogue(){
		try{
			$this->nestedsetbie = new Nestedsetbie(['table' => 'function']);
			$param = $this->request->getPost('data');
			$param = json_decode(base64_decode($param), TRUE);
			echo(json_encode($param));die();

		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function deleteDisplayCatalogue(){
		try{
			$data = $this->request->getPost('data');
			$data = json_decode(base64_decode($data), TRUE);
			$result = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => 'function',
				'where' => [
					'deleted_at' => 0,
					'lft >=' => $data['lft'],
					'rgt <=' => $data['rgt'],
				]
			],TRUE);
			$id = [];
			if(isset($result) && is_array($result) && count($result)){
				foreach ($result as $key => $value) {
					array_push($id, $value);
				}
				foreach ($id as $key => $value) {
					$id[$key]['deleted_at'] = 1;
				}
				$flag = $this->AutoloadModel->_update_batch([
					'table' => 'function',
					'data' => $id,
					'field' =>'id'
				]);
			}
			echo json_encode($id);die();

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
				'routes' => 'backend/contract/website/create'
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
		 		}
		 		if($flag > 0){
					$primary_id = ($id == 0) ? $flag : $id; //là id của đối tượng
					if($method == 'update'){
						$this->delete_contract_detail($primary_id);
					}
					$this->create_contract_detail($primary_id);
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

	public function delete_contract_detail(int $id){
		$flag = $this->AutoloadModel->_delete([
			'table' => 'contract_website_detail',
			'where' => ['contractid' => $id]
		]);

		return $flag;
	}

	public function create_contract_detail(int $insert_id = 0){
		$billing = $this->request->getPost('billing');
		$save = [];
		$flag = 0;
		if(isset($billing['billingPrice']) && is_array($billing['billingPrice']) && count($billing['billingPrice'])){
			foreach($billing['billingPrice'] as $key => $val){
				$save[] = [
					'contractid' => $insert_id,
					'money' => convertMoney($val),
					'cashierid' => $billing['billingCashierId'][$key],
					'date' => gettime(convertTime($billing['billingDate'][$key]),'Y-m-d').' 00:00:00',
				];
			}
		}
		if(isset($save) && is_array($save) && count($save)){
			$flag  = $this->AutoloadModel->_create_batch([
				'table' => 'contract_website_detail',
				'data' => $save,
			]);
		}


		return $flag;
	}

	private function store(array $param = []){
		helper('text');
		$data = $this->request->getPost('post');
		$store  = [];
		if(isset($data) && is_array($data) && count($data)){
			foreach($data as $key => $val){
				if($key > 13) break;
				if($val['name'] == 'id') continue;
				$store[$val['name']] = $val['value'];
			}
		}
		$store['total'] = convertMoney($store['total']);

		$store['date_sign'] = convertTime($store['date_sign']);
		$store['date_sign'] = gettime($store['date_sign'],'Y-m-d').' 00:00:00';
		if(isset($param['method']) && $param['method'] == 'create'){
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
		];
		$errorValidate = [
			'customerid' => [
				'is_natural_no_zero' => 'Bạn Phải Nhập Thông Tin Khách Hàng!',
			],
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}
}
