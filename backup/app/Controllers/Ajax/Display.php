<?php
namespace App\Controllers\Ajax;
use App\Controllers\BaseController;

class Display extends BaseController{

	public function __construct(){

	}

	public function update_price(){
		$id = $this->request->getPost('id');
		$val = $this->request->getPost('val');
		$val = str_replace('.', '', $val);
		$val = (float)$val;
		$field = $this->request->getPost('field');
		$flag = $this->AutoloadModel->_update([
			'table' => 'display',
			'data' => [$field => $val],
			'where' => [
				'id' => $id
			]
		]);

		$param['data'] = [
			'id' => $id,
			'val' => number_format($val,0,',','.'),
			'field' => $field
		];
		echo json_encode($param['data']);die();
	}
}
