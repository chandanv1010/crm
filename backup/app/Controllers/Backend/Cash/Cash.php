<?php 
namespace App\Controllers\Backend\Cash;
use App\Controllers\BaseController;

class Cash extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];		
		$this->data['module'] = 'cash';
	}

	public function index(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/cash/cash/index'
		]);

		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		$query = $this->condition_query();
		$this->data['periodic'] = $this->AutoloadModel->_get_where([
			'select' => 'id, date_start, date_end, money_start',
			'table' => 'cash_periodic',
			'query' =>$query,
		]);


		$this->data['template'] = 'backend/cash/cash/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function detail(){
		$day = $this->request->getGet('day');
		$id = $this->request->getGet('id');
		$day_start = date("Y-m-d 00:00:00",$day );
		$day_end = date("Y-m-d 23:59:59",$day );
		$keyword = $this->condition_keyword();
		$this->data['object'] = $this->AutoloadModel->_get_where([
            'select' => 'id, title, money_collect, money_pay, description, (SELECT title FROM branch WHERE branch.id = cash.branchid) as branch, (SELECT fullname FROM user WHERE user.id = cash.userid_created) as creator, (SELECT title FROM cash_catalogue WHERE cash_catalogue.id = cash.catalogueid) as catalogue_title, ',
            'table' => 'cash',
            'where' => ['publish' => 1,
            			'deleted_at' => 0,
            			'created_at >=' => $day_start, 
            			'created_at <=' => $day_end,
            			],
            'keyword' => $keyword,
            'order_by' => 'created_at desc',
        ], TRUE);
        $this->data['periodicid'] = $id;
        $this->data['day'] = date("d-m-Y",$day );
		$this->data['template'] = 'backend/cash/cash/detail';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	public function search($page = 1){

		helper(['mypagination']);
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 20;
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => 'cash',
			'where' => $where,
	        'keyword' => $keyword,
			'count' => TRUE
		]);


		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/cash/cash/search','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['object'] = $this->AutoloadModel->_get_where([
	            'select' => 'id, title, money_collect, money_pay, description, (SELECT title FROM branch WHERE branch.id = cash.branchid) as branch, (SELECT fullname FROM user WHERE user.id = cash.userid_created) as creator, (SELECT title FROM cash_catalogue WHERE cash_catalogue.id = cash.catalogueid) as catalogue_title, created_at ',
	            'table' => 'cash',
	            'where' => $where,
	            'keyword' => $keyword,
	            'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
	            'order_by' => 'created_at desc',
	        ], TRUE); 
			
			$this->data['total_money'] = $this->AutoloadModel->_get_where([
	            'select' => 'SUM(money_collect) as all_collect, SUM(money_pay) as all_pay',
	            'table' => 'cash',
	            'where' => $where,
	            'keyword' => $keyword,
	        ]);
		}

		

		$this->data['template'] = 'backend/cash/cash/search';
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

		$catalogueid = $this->request->getGet('catalogueid');
		if(isset($catalogueid) && $catalogueid != 0){
			$where['catalogueid'] = $catalogueid;
		}

		$branchid = $this->request->getGet('branchid');
		if(isset($branchid) && $branchid != 0){
			$where['branchid'] = $branchid;
		}

		$timeFrom = $this->request->getGet('timeFrom');
		$timeTo =$this->request->getGet('timeTo') ;
		if(isset($timeFrom) && $timeFrom != 0){
			$timeFrom = gettime(convertTime($timeFrom),'Y-m-d').' 00:00:00';
			$where['created_at >='] = $timeFrom;
		}
		if(isset($timeTo) && $timeTo != 0){
			$timeTo = gettime(convertTime($timeTo),'Y-m-d').' 00:00:00';
			$where['created_at <='] = $timeTo;
		}
		return $where;
	}

	private function condition_query(){
		$query = 'id = (SELECT MAX(id) FROM cash_periodic)';
		$id = $this->request->getGet('periodicid');
		if(isset($id) && $id != ''){
			$query = 'id = '.$id;
		}
		
		return $query;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}
}
