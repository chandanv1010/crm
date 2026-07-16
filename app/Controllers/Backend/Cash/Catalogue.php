<?php 
namespace App\Controllers\Backend\Cash;
use App\Controllers\BaseController;

class Catalogue extends BaseController{
	protected $data;
	
	
	public function __construct(){
		$this->data = [];		
		$this->data['module'] = 'cash_catalogue';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/cash/catalogue/index'
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
			$config = pagination_config_bt(['url' => 'backend/cash/catalogue/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();

			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['catalogueList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, description,(SELECT fullname FROM user WHERE user.id = cash_catalogue.userid_created) as creator',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'order_by' => 'id desc',
			], TRUE);

		}


		$this->data['template'] = 'backend/cash/catalogue/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		
		$this->data['template'] = 'backend/cash/catalogue/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}

	public function update($id = 0){
		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, description,',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/cash/catalogue/index');
		}
		
		$this->data['template'] = 'backend/cash/catalogue/store';
		return view('backend/dashboard/layout/popup', $this->data);
	}
	
	public function delete($id = 0){

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);

		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Bản ghi không tồn tại');
 			return redirect()->to(BASE_URL.'backend/cash/catalogue/index');
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
			return redirect()->to(BASE_URL.'backend/cash/catalogue/index');
		}

		$this->data['template'] = 'backend/cash/catalogue/delete';
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
			$keyword = '(title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

}
