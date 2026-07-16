<?php 
namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\AutoloadModel;
use App\Libraries\Pagination;


class Display extends ResourceController{
	
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->pagination = new Pagination();
		$this->data['module'] = 'display';
		helper(['mystring','mypagination']);
	}

	public function index(){
		return $this->respond(1);
		$catch['page'] = $this->request->getGet('page');
		$catch['language'] = $this->request->getGet('language');
		$catch['perpage'] = $this->request->getGet('perpage');
		$catch['canonical'] = $this->request->getGet('canonical');

		try{
			$session = session();
			$response['message'] = '';
			$response['code'] = 0;
			$module_extract = explode("_", $this->data['module']);
			$page = (int)$catch['page'];
			// $page = 1;
			$perpage = ($catch['perpage']) ? $catch['perpage'] : 1;
			$where = $this->condition_where();
			$keyword = $this->condition_keyword();
			$config['total_rows'] = $this->AutoloadModel->_get_where([
	            'select' => 'tb1.id',
	            'table' => $module_extract[0].' as tb1',
	            'keyword' => $keyword,
	            'where' => $where,
	            'join' => [
	                    [
	                        'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$module_extract[0].'\' ', 'inner'
	                    ],
	                    [
	                        'display_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "display" AND tb3.language = \''.$catch['language'].'\' ','inner'
	                    ]
	                ],
	            'count' => TRUE
	        ]);
	        $config['base_url'] = write_url($catch['canonical'], FALSE, false);
	        if($config['total_rows'] > 0){
	        	$config = pagination_frontend(['url' => $config['base_url'],'perpage' => $perpage], $config);
	            $this->pagination->initialize($config);
	            $this->data['pagination'] = $this->pagination->create_links();
	            $totalPage = ceil($config['total_rows']/$config['per_page']);
	            $page = ($page <= 0)?1:$page;
	            $page = ($page > $totalPage)?$totalPage:$page;
	            if($page >= 2){
	                $this->data['canonical'] = $config['base_url'].'/trang-'.$page.HTSUFFIX;
	            }
	            $page = $page - 1;
	        	$display = $this->AutoloadModel->_get_where([
					'select' => 'tb1.id,tb1.price, tb1.price_promotion,  tb1.catalogueid as cat_id,tb1.image,tb1.viewed, tb1.order,tb1.created_at,  tb1.album,  tb2.catalogueid, tb1.publish, tb3.title as display_title, tb1.catalogue, tb2.objectid, tb3.content,  tb3.canonical, tb3.meta_title, tb3.meta_description,  tb4.title as cat_title , tb5.fullname as creator,',
					'table' => $this->data['module'].' as tb1',
					'where' => $where,
					'keyword' => $keyword,
					'join' => [
						[
							'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.$this->data['module'].'\' ', 'inner'
						],
						[
							'display_translate as tb3','tb1.id = tb3.objectid AND tb3.module = "display" AND tb3.language = \''.$catch['language'].'\' ','inner'
						],
						[
							'display_translate as tb4','tb1.catalogueid = tb4.objectid AND tb4.module = "display_catalogue" AND tb4.language = \''.$catch['language'].'\' ','inner'
						],
						[
							'user as tb5','tb1.userid_created = tb5.id','inner'
						],
					],
					'limit' => $config['per_page'],
					'start' => $page * $config['per_page'],
					'order_by'=> 'tb1.order desc, tb1.id desc',
					'group_by' => 'tb1.id'
				], TRUE);
				$response['message'] = '';
				$response['code'] = 0;

				if(isset($display) && is_array($display) && count($display)){
					$response['data'] = $display;
					$response['message'] = 'Truy xuất dữ liệu thành công!';
					$response['code'] = '10';
				}else{
					$response['message'] = 'Không có dữ liệu phù hợp!';
					$response['code'] = '11';
				}
				return $this->respond($response);
	        }
		}catch(\Exception $e){
			$response['message'] = $e->getMessage();
			$response['code'] = '24';
			echo json_encode($response);die();
		}
	}

	private function condition_where(){
		$where = [];

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
			$keyword = '(tb3.title LIKE \'%'.$keyword.'%\')';
		}
		return $keyword;
	}
}
