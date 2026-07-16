<?php 
namespace App\Controllers\Backend\Deadline;
use App\Controllers\BaseController;

class Deadline extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'deadline';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/deadline/deadline/index'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/dashboard/dashboard/index');
		}

		helper(['mypagination']);
		$page = (int)$page;
		$perpage = ($this->request->getGet('perpage')) ? $this->request->getGet('perpage') : 50;
		$where = $this->condition_where();
		$keyword = $this->condition_keyword();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'id',
			'table' => $this->data['module'],
			'keyword' => $keyword,
			'where' => $where,
			'count' => TRUE
		]);




		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/deadline/deadline/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['deadlineList'] = $this->AutoloadModel->_get_where([
				'select' => 'id, title, timeline, created_at, (SELECT fullname FROM user WHERE user.id = deadline.userid_created) as creator , userid_updated',
				'table' => $this->data['module'],
				'where' => $where,
				'keyword' => $keyword,
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
			], TRUE);

		}

		$this->data['template'] = 'backend/deadline/deadline/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/deadline/deadline/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				$method = 'create';
		 		$insert = $this->store($method);
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$catalogueid = $this->request->getPost('catalogueid');
		 			if(isset($catalogueid) && is_array($catalogueid) && count($catalogueid)){
						foreach($catalogueid as $key => $val){
							$_catalogue_relation_ship[] = array(
								'module' => 'deadline',
								'moduleid' => $insertid,
								'catalogueid' => $val
							);
						}
					}

					$this->AutoloadModel->_create_batch(array(
						'table' => 'catalogue_relationship',
						'data' => $_catalogue_relation_ship,
					));
		 			$session->setFlashdata('message-success', 'Thêm mới thời gian xử lý thành công');
		 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['template'] = 'backend/deadline/deadline/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/deadline/deadline/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, timeline, catalogueid ',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thời gian xử lý không tồn tại');
 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
				$method = 'update';
		 		$update = $this->store($method);

		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){
		 			$this->AutoloadModel->_delete(array(
						'where' => array('module' => 'deadline','moduleid' => $id),
						'table' => 'catalogue_relationship',
					));

					$catalogueid = $this->request->getPost('catalogueid');
		 			if(isset($catalogueid) && is_array($catalogueid) && count($catalogueid)){
						foreach($catalogueid as $key => $val){
							$_catalogue_relation_ship[] = array(
								'module' => 'deadline',
								'moduleid' => $id,
								'catalogueid' => $val
							);
						}
					}

					$this->AutoloadModel->_create_batch(array(
						'table' => 'catalogue_relationship',
						'data' => $_catalogue_relation_ship,
					));

		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật thời gian xử lý thành công');
		 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}

		$this->data['template'] = 'backend/deadline/deadline/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/deadline/deadline/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, title, timeline',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$this->AutoloadModel->_delete(array(
			'where' => array('module' => 'deadline','moduleid' => $id),
			'table' => 'catalogue_relationship',
		));
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thời gian xử lý không tồn tại');
 			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}

		if($this->request->getPost('delete')){
			$userID = $this->request->getPost('id');

			$flag = $this->AutoloadModel->_update([
				'data' => ['deleted_at' => 1],
				'where' => ['id' => $userID],
				'table' => $this->data['module']
			]);

			$session = session();
			if($flag > 0){
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/deadline/deadline/index');
		}

		$this->data['template'] = 'backend/deadline/deadline/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function validation(){
		$validate = [
			'timeline' => 'required',
			'title' => 'required',
		];
		$errorValidate = [
			'timeline' => [
				'required' => 'Bạn cần nhập thời gian!',
			],
			'title' => [
				'required' => 'Bạn phải nhập tên thời gian!'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
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
			$keyword = '(title LIKE \'%'.$keyword.'%\' )';
		}
		return $keyword;
	}

	private function store($method){
		$store = [
 			'title' => $this->request->getPost('title'),
 			'timeline' => $this->request->getPost('timeline'),
 			'catalogueid' => json_encode($this->request->getPost('catalogueid')),
 		];
 		if($method == 'create'){
 			$store['created_at'] = $this->currentTime;
 			$store['userid_created'] = $this->auth['id'];
 			$store['publish'] = 1;
 		}else{
 			$store['updated_at'] = $this->currentTime;
 			$store['userid_updated'] = $this->auth['id'];
 		}
 		return $store;
	}

}
