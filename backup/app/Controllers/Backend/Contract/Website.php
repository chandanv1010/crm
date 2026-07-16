<?php
namespace App\Controllers\Backend\Contract;
use App\Controllers\BaseController;
use App\Libraries\Nestedsetbie;


class Website extends BaseController{
	protected $data;
	public $nestedsetbie;

	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'contract_website';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/contract/website/index'
		]);

		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}
		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'where' => $where,
			'keyword' => $keyword,
			'count' => TRUE
		]);
		$branch = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => 'branch',
			'where' => ['deleted_at' => 0,'publish' => 1]
		],TRUE);

		$this->data['branch'] = convert_array([
			'data' => $branch,
			'field' => 'id',
			'value' => 'title',
			'text' => 'chi nhánh',
		]);

		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/contract/website/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['objectList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, customerid, userid, fullname, phone, email, address, total, date_sign, contract_file, status, process, description, (SELECT fullname FROM user WHERE user.id = contract_website.userid_created) as creator, created_at, updated_at, (SELECT fullname FROM user WHERE user.id = contract_website.userid) as staff, (SELECT SUM(money) FROM contract_website_detail WHERE contract_website_detail.contractid = contract_website.id) as total_money, domain',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);
		}

		// pre($this->data['objectList']);die();

		$this->data['template'] = 'backend/contract/website/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
	public function create(){
		$branch = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => 'branch',
			'where' => ['deleted_at' => 0,'publish' => 1]
		],TRUE);

		$this->data['branch'] = convert_array([
			'data' => $branch,
			'field' => 'id',
			'value' => 'title',
			'text' => 'chi nhánh',
		]);
		
		$this->data['template'] = 'backend/contract/website/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	public function update($id = 0){
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, customerid, userid, fullname, phone, email, address, total, date_sign,branchid, contract_file, status, process, description, domain',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);


		$this->data['PayInfo'] = $this->AutoloadModel->_get_where([
			'select' => 'contractid, cashierid, money, date',
			'table' => 'contract_website_detail',
			'where' => ['contractid' => $id]
		],TRUE);

		$branch = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => 'branch',
			'where' => ['deleted_at' => 0,'publish' => 1]
		],TRUE);

		$this->data['branch'] = convert_array([
			'data' => $branch,
			'field' => 'id',
			'value' => 'title',
			'text' => 'chi nhánh',
		]);
		// pre($this->data['branch']);
		$this->data['template'] = 'backend/contract/website/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	public function delete($id = 0){
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/contract/website/index');
		}
		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1,'userid_deleted' => $this->auth['id'],'updated_at' => $this->currentTime],
				'where' => ['id' => $_id],
				'table' => $this->data['module'],
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/contract/website/index');
		}

		$this->data['template'] = 'backend/contract/website/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function setting($id = 0){
		$session = session();
		$this->nestedsetbie = new Nestedsetbie(['table' => 'function']);
		$this->data['system'] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, parentid, keyword,  level, lft, rgt',
			'table' => 'function',
			'where' => [
				'deleted_at' => 0,
			],
			'order_by'=> ' lft asc'

		], TRUE);

		$this->data['status'] = $this->AutoloadModel->_get_where([
			'select' => 'id, function',
			'table' => $this->data['module'],
			'where' => [
				'deleted_at' => 0,
				'id' => $id
			],
		]);
		if(isset($this->data['status']) && $this->data['status']['function'] != ''){
			$this->data['status']['function'] = json_decode($this->data['status']['function'], TRUE);
		}
		// prE($this->data['status']);
		
		if($this->request->getMethod() == 'post'){
			$status = $this->request->getPost('display');
			$data_id = $this->request->getPost('id');
			$keyword = $this->request->getPost('keyword');
			$param = [];
			if(isset($data_id) && is_array($data_id) && count($data_id)){
				foreach ($data_id as $key => $value) {
					$param[$key]['id'] = $value;
					$param[$key]['keyword'] = $keyword[$key];
					$param[$key]['status'] = '';
				}
				foreach ($data_id as $keyId => $valueId) {
					if(isset($status) && is_array($status) && count($status)){
						foreach ($status as $key => $value) {
							if($valueId == $key){
								$param[$keyId]['status'] = $value;
							}
						}
					}
				}
				foreach ($param as $key => $value) {
					if($value['status'] == 'on'){
						$param[$key]['status'] = 1;
					}else{
						$param[$key]['status'] = 0;
					}
				}
				$store = json_encode($param);
				$flag = $this->AutoloadModel->_update([
					'table' => $this->data['module'],
					'data' => [
						'function' => $store
					],
					'where' => [
						'id' => $id,
						'deleted_at' => 0
					]
				]);
				if($flag > 0){
					if($flag > 0){
			 			$session->setFlashdata('message-success', 'Thêm chức năng thành công!');
					}else{
						$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
					}
					return redirect()->to(BASE_URL.'backend/contract/website/index');
				}
			}

		}

		$this->data['template'] = 'backend/contract/website/setting';
		return view('backend/dashboard/layout/popup', $this->data);
		
	}
	private function condition_where(){
		$where = [];
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}
		$process = $this->request->getGet('process');
		if(isset($process) && $process != 0){
			$where['process'] = $process;
		}
		$branchid = $this->request->getGet('branchid');
		if(isset($branchid) && $branchid != 0){
			$where['branchid'] = $branchid;
		}

		return $where;
	}
	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR description LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}
}
