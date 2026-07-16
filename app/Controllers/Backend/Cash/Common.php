<?php 
namespace App\Controllers\Backend\Cash;
use App\Controllers\BaseController;

class Common extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];		
		$this->data['module'] = 'cash_common';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/cash/common/index'
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


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/cash/common/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['commonList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, money_collect, money_pay, description, publish, (SELECT fullname FROM user WHERE user.id = cash_common.userid_created) as creator, (SELECT title FROM cash_catalogue WHERE cash_catalogue.id = cash_common.catalogueid) as catalogue_title',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by' => 'id desc'
			], TRUE);
		}


		$this->data['template'] = 'backend/cash/common/index';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function condition_where(){
		$where = [];
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
			$keyword = '(title LIKE \'%'.$keyword.'%\' OR ip LIKE \'%'.$keyword.'%\' OR disk_space LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

}
