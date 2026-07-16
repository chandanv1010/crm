<?php 
namespace App\Libraries;
use App\Models\AutoloadModel;

class Authentication{

	public $auth;
	protected $AutoloadModel;

	public function __construct(){
		$this->auth = ((isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '');
		$this->AutoloadModel = new AutoloadModel();
	}

	public function check_auth(){
 		return json_decode($this->auth, TRUE);

	}

	public function check_permission(array $param = []){

		$this->auth = json_decode($this->auth, TRUE);


		$user = $this->AutoloadModel->_get_where([
			'select' => 'id, catalogue',
			'table' => 'user',
			'where' => ['id' => $this->auth['id']]
		]);

		$catalogue = $this->AutoloadModel->_get_where([
			'select' => 'permission',
			'table' => 'user_catalogue',
			'where_in' => json_decode($user['catalogue'], TRUE),
			'where_in_field' => 'id'
		], TRUE);


		$permission = [];
		if(isset($catalogue) && is_array($catalogue) && count($catalogue)){
			foreach($catalogue as $key => $val){
				if($val['permission'] == 'null') continue;
				$permission = array_merge($permission, json_decode($val['permission'], TRUE));
			}
		}

		$permission = array_unique($permission);

		if(is_array($permission) && in_array($param['routes'], $permission) == false){
			return false;
		}
		return true;

	}

}