<?php 
namespace App\Controllers\Api\Widget;
use CodeIgniter\RESTful\ResourceController;
use App\Models\AutoloadModel;

class Widget extends ResourceController{
	
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
	}

	public function list(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			// $display = $this->AutoloadModel->_get_where([
			// 	'select' => 'tb1.id,tb1.price, tb1.price_promotion,  tb1.catalogueid as cat_id,tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,  tb2.catalogueid, tb1.publish, tb3.title as display_title, tb1.catalogue, tb2.objectid, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description,  tb4.title as cat_title , tb5.fullname as creator,',
			// 	'table' => $this->data['module'].' as tb1',
			// 	'where' => $where,
			// 	'where_in' => $catalogue['where_in'],
			// 	'where_in_field' => $catalogue['where_in_field'],
			// 	'keyword' => $keyword,
			// 	'join' => [
			// 		[
			// 			'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
			// 		],
			// 		[
			// 			'display_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "display" AND tb3.language = \''.$this->currentLanguage().'\' ','inner'
			// 		],
			// 		[
			// 			'display_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "display_catalogue" AND tb4.language = \''.$this->currentLanguage().'\' ','inner'
			// 		],
			// 		[
			// 			'user as tb5','tb1.userid_created = tb5.id','inner'
			// 		],
			// 	],
			// 	'limit' => $config['per_page'],
			// 	'start' => $page * $config['per_page'],
			// 	'order_by'=> 'tb1.order desc, tb1.id desc',
			// 	'group_by' => 'tb1.id'
			// ], TRUE);

			if(isset($display) && is_array($display) && count($display)){
				$response['data'] = $display;
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
			}else{
				$response['message'] = 'Không có dữ liệu phù hợp!';
				$response['code'] = '11';
			}
			return $this->respond($response);
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	public function widget_catalogue_list(){
		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			// $display_catalogue = $this->AutoloadModel->_get_where([
			// 	'select' => 'tb1.id, tb2.title, tb1.lft, tb1.rgt, tb1.level, tb2.canonical, tb1.userid_updated, tb1.publish, tb1.order, tb1.created_at, tb1.updated_at,',
			// 	'table' => $this->data['module'].' as tb1',
			// 	'join' =>  [
			// 		[
			// 			'display_translate as tb2','tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\'   AND tb2.language = \''.$this->currentLanguage().'\' ','inner'
			// 		],
			// 	],
			// 	'where' => $where,
			// 	'keyword' => $keyword,
			// 	'limit' => $config['per_page'],
			// 	'start' => $page * $config['per_page'],
			// 	'order_by'=> 'lft asc'
			// ], TRUE);

			if(isset($display_catalogue) && is_array($display_catalogue) && count($display_catalogue)){
				$response['data'] = $display_catalogue;
				$response['message'] = 'Truy xuất dữ liệu thành công!';
				$response['code'] = '10';
			}else{
				$response['message'] = 'Không có dữ liệu phù hợp!';
				$response['code'] = '11';
			}
			return $this->respond($response);
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}
}
