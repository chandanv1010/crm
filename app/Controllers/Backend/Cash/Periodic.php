<?php 
namespace App\Controllers\Backend\Cash;
use App\Controllers\BaseController;

class Periodic extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];		
		$this->data['module'] = 'cash_periodic';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/cash/periodic/index'
		]);

		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}


		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'count' => TRUE
		]);


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/cash/periodic/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['periodicList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, money_start, money_end, description, date_start, date_end',
				'table' => $this->data['module'],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by' => 'id desc',
			], TRUE);

			$this->data['periodicNewest'] = $this->AutoloadModel->_get_where([
				'select' => 'id, date_end, money_start, money_end',
				'table' => $this->data['module'],
				'query' =>'id = (SELECT MAX(id) FROM cash_periodic)'
			]);

		}


		$this->data['template'] = 'backend/cash/periodic/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

}
