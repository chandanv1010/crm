<?php 
namespace App\Controllers\Api;
use App\Controllers\BaseController;

class Customer extends BaseController{
	
	public function __construct(){
	}

	public function get_country(){

		try{
			$city = $this->AutoloadModel->_get_where([
				'select' => '*',
				'table' => 'vn_province',
				'object' => true,
			], TRUE);


			$response['data'] = $city;
			$response['message'] = 'success';
			$response['code'] = 10;

		}catch (\Exception $e){
			$response['message'] = $e->message;
			$response['code'] = 9;
		}

		return json_encode($response);
		
	}
	
}
