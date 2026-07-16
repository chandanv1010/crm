<?php 
namespace App\Validation;
use App\Models\AutoloadModel;
use CodeIgniter\HTTP\RequestInterface;

class CustomerRules {

	protected $AutoloadModel;
	protected $user;
	protected $helper = ['mystring'];
	protected $request;
	protected $table = 'customer';

	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->request = \Config\Services::request();
		helper($this->helper);

	}

	
	public function check_customer_email_exist(string $param = '', string $field = ''): bool{
		$info = $this->request->getPost($field.'_original');
		$count = $this->AutoloadModel->_get_where([
			'table' => $this->table,
			'select' => 'id',
			'where' => [$field => $param,'deleted_at' => 0],
			'count' => TRUE,
		]);
		if($info != $param){
			if($count > 0){
				return false;
			}
		}
		return true;
	}

	public function check_customer_phone_exist(string $param = '', string $field = ''): bool{
		$info = $this->request->getPost($field.'_original');
		$count = $this->AutoloadModel->_get_where([
			'table' => $this->table,
			'select' => 'id',
			'where' => [$field => $param,'deleted_at' => 0],
			'count' => TRUE,
		]);
		if($info != $param){
			if($count > 0){
				return false;
			}
		}
		return true;
	}


}

