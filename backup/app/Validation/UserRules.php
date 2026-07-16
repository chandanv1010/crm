<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class UserRules {
	protected $AutoloadModel;
	protected $user;
	protected $helper = ['mystring'];
	protected $request;

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	public function check_user_group(){
		$catalogue = $this->request->getPost('catalogue');
		if(!isset($catalogue) || is_array($catalogue) == false || count($catalogue) == 0){
			return false;
		}
		return true;
	}

	public function checkAuth(string $password = '' ,string $email = ''): bool{

		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0]
		]);

		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}

		$passwordEncode = password_encode($password, $this->user['salt']);
		if($passwordEncode != $this->user['password']){
			return false;
		}

		return true;
	}

	public function checkActive($password = '', $email = ''){
		$this->user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0,'publish' => 1]
		]);

		if(!isset($this->user) || is_array($this->user) == false || count($this->user) == 0){
			return false;
		}

		return true;
	}

	public function check_email(string $email = ''){

		$count = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id, fullname, email, password, salt',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($count == 0){
			return false;
		}

		return true;
	}

	public function check_otp(string $otp = ''){
		$token = $_GET['token'];
		$token = json_decode(base64_decode($token), TRUE);


		if(!isset($token) || is_array($token) == false || count($token) == 0){
			return false;
		}

		$user = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'otp, otp_live',
			'where' => ['id' => $token['id'],'deleted_at' => 0],
		]);

		$currentTime = gmdate('Y-m-d H:i:s', time() + 7*3600);

		if(strtotime($currentTime) > strtotime($user['otp_live'])){
			return false;
		}

		if($user['otp'] != $otp){
			return false;
		}

		return true;

	}

	public function check_email_exist(string $email = ''){
		$emailOriginal = $this->request->getPost('email_original');
		$count = $this->AutoloadModel->_get_where([
			'table' => 'user',
			'select' => 'id',
			'where' => ['email' => $email,'deleted_at' => 0],
			'count' => TRUE,
		]);

		if($emailOriginal != $email){
			if($count > 0){
				return false;
			}
		}
		return true;
	}

}

