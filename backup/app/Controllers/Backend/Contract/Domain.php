<?php
namespace App\Controllers\Backend\Contract;
use App\Controllers\BaseController;

class Domain extends BaseController{
	protected $data;


	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'contract_domain';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/contract/domain/index'
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
		$having = $this->condition_having();
		$order_by = $this->condition_order_by();

		$join = [
				['customer as tb2','tb2.id = tb1.customerid','inner']
		];
		$query = $this->condition_query();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id, (SELECT TIMESTAMPDIFF(DAY,NOW(),tb1.date_end)) as day, tb2.cityid',
			'table' => $this->data['module'].' as tb1',
			'join' => $join,
			'where' => $where,
			'query' => $query,
			'keyword' => $keyword,
			'group_by' => 'tb1.id',
			'having' => $having,
			'count' => TRUE
		]);
		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/contract/domain/index','perpage' => $perpage], $config);
			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();
			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;
			$this->data['objectList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.contract_code, tb1.customerid, tb1.userid, tb1.fullname, tb1.phone, tb1.email, tb1.address, tb1.total, tb1.date_sign, tb1.contract_file, tb1.description, (SELECT fullname FROM user WHERE user.id = tb1.userid_created) as creator, tb1.date_start, tb1.date_end, tb1.timeline, tb1.created_at, tb1.updated_at, tb1.price, tb1.domain, (SELECT fullname FROM user WHERE user.id = tb1.userid) as staff,(SELECT title FROM domain WHERE domain.id  = tb1.domainid) as domain_title , (SELECT TIMESTAMPDIFF(DAY,NOW(),tb1.date_end)) as day, tb2.cityid',
				'table' => $this->data['module'].' as tb1',
				'join' => $join,
				'where' => $where,
				'query' => $query,
				'group_by' => 'tb1.id',
				'having' => $having,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by' => $order_by,
			], TRUE);
		}
		$this->data['template'] = 'backend/contract/domain/index';
		return view('backend/dashboard/layout/home', $this->data);
	}
	public function create(){
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/contract/domain/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	public function update($id = 0){
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, contract_code, customerid, userid, price, fullname, phone, domainid, email, address, date_start, date_end, total, date_sign, contract_file, description, domain',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		
		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/contract/domain/store';
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
 			return redirect()->to(BASE_URL.'backend/contract/domain/index');
		}
		if($this->request->getPost('delete')){
			$_id = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1,'userid_deleted' => $this->auth['id'],'updated_at' => $this->currentTime],
				'where' => ['id' => $_id],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/contract/domain/index');
		}

		$this->data['template'] = 'backend/contract/domain/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function extend($id = 0){
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, contract_code, customerid, userid, fullname, phone, email, domainid, address, date_end, domain',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0],
		]);
		$this->data['method'] = 'extend';
		$this->data['template'] = 'backend/contract/domain/extend';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	private function condition_where(){
		$where = [];
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}

		$userid = $this->request->getGet('staff');
		if(isset($userid) && $userid!= 0){
			$where['tb1.userid'] =$userid;
		}

		$cityid = $this->request->getGet('city');
		if(isset($cityid) && $cityid != 0){
			$where['tb2.cityid'] = $cityid;
		}
		return $where;
	}
	private function condition_query(){
		$query = '';
		$timeFrom = $this->request->getGet('timeFrom');
		$timeTo =$this->request->getGet('timeTo') ;
		
		if(isset($timeFrom) && $timeFrom != 0){
			$timeFrom = gettime(convertTime($timeFrom),'Y-m-d').' 00:00:00';
			$query = 'tb1.created_at >= \''.$timeFrom.'\'';
		}
		if(isset($timeTo) && $timeTo != 0){
			$timeTo = gettime(convertTime($timeTo),'Y-m-d').' 23:59:59';
			$query = $query.' AND tb1.created_at <= \''.$timeTo.'\'';
		}

		return $query;
	}
	private function condition_having(){
		$having = '';

		$contract_end = $this->request->getGet('contract_end');
		if($contract_end == 1){
			$having = ' day < -10 ';
		}
		else{
			$having = ' day >= -10 ';
		}

		return $having;
	}
	private function condition_order_by(){
		$order_by = '';

		$contract_end = $this->request->getGet('contract_end');
		if($contract_end == 1){
			$order_by = ' tb1.date_end desc ';
		}
		else{
			$order_by = ' tb1.date_end asc ';
		}

		return $order_by;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb1.fullname LIKE \'%'.$keyword.'%\' OR tb1.email LIKE \'%'.$keyword.'%\' OR tb1.phone LIKE \'%'.$keyword.'%\' OR tb1.address LIKE \'%'.$keyword.'%\' OR tb1.description LIKE \'%'.$keyword.'%\' OR tb1.domain LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}
}
