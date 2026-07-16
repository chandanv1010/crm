<?php
namespace App\Controllers\Backend\Customer;
use App\Controllers\BaseController;

class Customer extends BaseController{
	protected $data;

	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'customer';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/customer/customer/index'
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
			'table' => $this->data['module'].'',
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/customer/customer/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['userList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, fullname, image, email, phone, address, created_at, image, gender, userid_created, userid_updated, publish, code, company, company_mst, company_address',
				'table' => $this->data['module'].' as tb1',
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

		$this->data['template'] = 'backend/customer/customer/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$this->data['method'] = 'create';
		$this->data['user_catalogueList'] = user_catalogueList();
		$this->data['template'] = 'backend/customer/customer/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	public function update($id = 0){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/customer/customer/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/customer/customer/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email, phone, address, birthday, gender, cityid, company, company_address, company_mst, code',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);

		$this->data['incidentList'] = $this->AutoloadModel->_get_where([
			'select' => 'id, description, note, status, (SELECT title FROM user_catalogue WHERE user_catalogue.id = incident.user_catalogueid) as user_catalogue, created_at',
			'table' => 'incident',
			'where' => ['publish' => 1, 'deleted_at' => 0, 'customerid' => $id],
			'order_by' => 'created_at desc'
		], TRUE);

		$this->data['user_catalogueList'] = user_catalogueList();

		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Khách hàng không tồn tại');
 			return redirect()->to(BASE_URL.'backend/customer/customer/index');
		}

		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/customer/customer/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}


	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != 0 && $gender != '' && isset($gender)){
			$where['gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['publish'] = $publish;
		}

		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['deleted_at'] = $deleted_at;
		}else{
			$where['deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(fullname LIKE \'%'.$keyword.'%\' OR address LIKE \'%'.$keyword.'%\' OR email LIKE \'%'.$keyword.'%\' OR phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}


}
