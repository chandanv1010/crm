<?php 
namespace App\Controllers\Backend\User;
use App\Controllers\BaseController;

class User extends BaseController{
	protected $data;
	
	public function __construct(){
		$this->data = [];
		$this->data['module'] = 'user';
	}

	public function index($page = 1){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/index'
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
		$catalogue = $this->condition_catalogue();
		$config['total_rows'] = $this->AutoloadModel->_get_where([
			'select' => 'tb1.id',
			'table' => $this->data['module'].' as tb1',
			'keyword' => $keyword,
			'where' => $where,
			'where_in' => $catalogue['where_in'],
			'where_in_field' => $catalogue['where_in_field'],
			'join' => [
				[
					'user_relationship as tb2','tb2.userid = tb1.id','inner'
				]
			],
			'group_by' => 'tb2.userid',
			'count' => TRUE
		]);




		if($config['total_rows'] > 0){
			$config = pagination_config_bt(['url' => 'backend/user/user/index','perpage' => $perpage], $config);

			$this->pagination->initialize($config);
			$this->data['pagination'] = $this->pagination->create_links();


			$totalPage = ceil($config['total_rows']/$config['per_page']);
			$page = ($page <= 0)?1:$page;
			$page = ($page > $totalPage)?$totalPage:$page;
			$page = $page - 1;

			$this->data['userList'] = $this->AutoloadModel->_get_where([
				'select' => 'tb1.id, tb1.fullname, tb1.image, tb1.email, tb1.phone, tb1.branchid, tb1.created_at, tb1.image, tb1.gender, tb1.userid_created, tb1.userid_updated, tb1.publish, (SELECT title FROM branch WHERE branch.id = tb1.branchid ) as branch',
				'table' => $this->data['module'].' as tb1',
				'where' => $where,
				'where_in' => $catalogue['where_in'],
				'where_in_field' => $catalogue['where_in_field'],
				'keyword' => $keyword,
				'join' => [
					[
						'user_relationship as tb2','tb2.userid = tb1.id','inner'
					],
				],
				'limit' => $config['per_page'],
				'start' => $page * $config['per_page'],
				'group_by' => 'tb2.userid',
			], TRUE);

		}

		$this->data['template'] = 'backend/user/user/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function create(){
		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/create'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$insert = $this->store();
		 		$insertid = $this->AutoloadModel->_insert(['table' => $this->data['module'],'data' => $insert]);
		 		if($insertid > 0){
		 			$flag = $this->create_relationship($insertid, $this->request->getPost('catalogue'));

		 			$session->setFlashdata('message-success', 'Thêm mới người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/user/user/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}
		$this->data['method'] = 'create';
		$this->data['template'] = 'backend/user/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function update($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/update'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, branchid, email, phone, birthday, gender, image, catalogue',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}
		if($this->request->getMethod() == 'post'){
			$validation = $this->validation();	
			
			if ($this->validate($validation['validate'], $validation['errorValidate'])){
		 		$update = $this->store();

		 		$flag = $this->AutoloadModel->_update(['table' => $this->data['module'],'data' => $update, 'where' => ['id' =>$id]]);
		 		if($flag > 0){

		 			$this->delele_relationship($id);
		 			$this->create_relationship($id, $this->request->getPost('catalogue'));

		 			$session = session();
		 			$session->setFlashdata('message-success', 'Cập nhật người dùng thành công');
		 			return redirect()->to(BASE_URL.'backend/user/user/index');
		 		}
	        }else{
	        	$this->data['validate'] = $this->validator->listErrors();
	        }
		}


		$this->data['method'] = 'update';
		$this->data['template'] = 'backend/user/user/store';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function delete($id = 0){

		$session = session();
		$flag = $this->authentication->check_permission([
			'routes' => 'backend/user/user/delete'
		]);
		if($flag == false){
 			$session->setFlashdata('message-danger', 'Bạn không có quyền truy cập vào chức năng này!');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$id = (int)$id;
		$this->data[$this->data['module']] = $this->AutoloadModel->_get_where([
			'select' => 'id, fullname, catalogueid, email, phone, branchid, birthday, gender',
			'table' => $this->data['module'],
			'where' => ['id' => $id,'deleted_at' => 0]
		]);
		$session = session();
		if(!isset($this->data[$this->data['module']]) || is_array($this->data[$this->data['module']]) == false || count($this->data[$this->data['module']]) == 0){
			$session->setFlashdata('message-danger', 'Thành viên không tồn tại');
 			return redirect()->to(BASE_URL.'backend/user/user/index');
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
				$this->delele_relationship($id);
	 			$session->setFlashdata('message-success', 'Xóa bản ghi thành công!');
			}else{
				$session->setFlashdata('message-danger', 'Có vấn đề xảy ra, vui lòng thử lại!');
			}
			return redirect()->to(BASE_URL.'backend/user/user/index');
		}

		$this->data['template'] = 'backend/user/user/delete';
		return view('backend/dashboard/layout/home', $this->data);
	}


	private function delele_relationship(int $userid = 0): bool{
		$flag = $this->AutoloadModel->_delete([
			'table' => $this->data['module'].'_relationship',
			'where' => ['userid' => $userid]
		]);

		return ($flag > 0) ? TRUE : FALSE;
	}
	private function create_relationship(int $insertid = 0, array $catalogue = []){
		if(!isset($catalogue) || is_array($catalogue) == false || count($catalogue) == 0){
			return;
		} 
		$insert = [];
		foreach($catalogue as $key => $val){
			$insert[] = [
				'userid' => $insertid,
				'catalogueid' => $val,
			];
		}

		$flag = $this->AutoloadModel->_create_batch([
			'data' => $insert,
			'table' => $this->data['module'].'_relationship'
		]);

		return $flag;
	}

	private function validation(){
		if($this->request->getPost('password')){
			$validate['password'] = 'required|min_length[6]';
		}
		$validate = [
			'email' => 'required|valid_email|check_email_exist',
			'catalogueid' => 'check_user_group',
			'fullname' => 'required',
		];
		$errorValidate = [
			'email' => [
				'check_email_exist' => 'Email đã tồn tại trong hệ thống!',
			],
			'catalogueid' => [
				'check_user_group' => 'Bạn phải lựa chọn giá trị cho trường Nhóm Thành Viên'
			]
		];
		return [
			'validate' => $validate,
			'errorValidate' => $errorValidate,
		];
	}


	public function condition_catalogue(){
		$catalogueid = $this->request->getGet('catalogueid');

		$id = [];	
		if($catalogueid > 0){
			$catalogue = $this->AutoloadModel->_get_where([
				'select' => 'id',
				'table' => $this->data['module'].'_catalogue',
				'where' => ['id' => $catalogueid],
			]);

			$id = [$catalogue['id']];
		}
		
		return [
			'where_in' => $id,
			'where_in_field' => 'tb2.catalogueid'
		];

	}
	private function condition_where(){
		$where = [];
		$gender = $this->request->getGet('gender');
		if($gender != -1 && $gender != '' && isset($gender)){
			$where['tb1.gender'] = $this->request->getGet('gender');
		}

		$publish = $this->request->getGet('publish');
		if(isset($publish)){
			$where['tb1.publish'] = $publish;
		}
		
		$deleted_at = $this->request->getGet('deleted_at');
		if(isset($deleted_at)){
			$where['tb1.deleted_at'] = $deleted_at;
		}else{
			$where['tb1.deleted_at'] = 0;
		}

		return $where;
	}

	private function condition_keyword($keyword = ''): string{
		if(!empty($this->request->getGet('keyword'))){
			$keyword = $this->request->getGet('keyword');
			$keyword = '(tb1.fullname LIKE \'%'.$keyword.'%\' OR tb1.email LIKE \'%'.$keyword.'%\' OR tb1.phone LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}

	private function store(){
		helper(['text']);
		$salt = random_string('alnum', 168);
		$catalogue = $this->request->getPost('catalogue');
		$store = [
 			'email' => $this->request->getPost('email'),
 			'fullname' => $this->request->getPost('fullname'),
 			'catalogueid' => (int)$catalogue[0],
 			'catalogue' => json_encode($this->request->getPost('catalogue')),
 			'gender' => (int)$this->request->getPost('gender'),
 			'image' => $this->request->getPost('image'),
 			'birthday' => $this->request->getPost('birthday'),
 			'branchid' => $this->request->getPost('branchid'),
 			'phone' => $this->request->getPost('phone'),
 		];
 		if($this->request->getPost('password')){
 			$store['password'] = password_encode($this->request->getPost('password'), $salt);
 			$store['salt'] = $salt;
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
