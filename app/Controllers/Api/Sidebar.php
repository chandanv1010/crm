<?php 
namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;
use App\Models\AutoloadModel;
use App\Libraries\Pagination;


class Sidebar extends ResourceController{
	
	public function __construct(){
		$this->AutoloadModel = new AutoloadModel();
		$this->pagination = new Pagination();
		$this->data['module'] = 'display';
		helper(['mystring','mypagination']);
	}

	public function index(){
		try{
			$client = new \CodeIgniter\HTTP\CURLRequest(
		        new \Config\App(),
		        new \CodeIgniter\HTTP\URI(),
		        new \CodeIgniter\HTTP\Response(new \Config\App())
			);
			$result = $client->get('http://gomi.thegioiweb.org/api/sidebar/sidebar/send_canonical');
			$this->data['result'] = json_decode(validate_input($result->getBody()),TRUE);
			$canonical = $this->data['result']['data'];
			$function = $this->AutoloadModel->_get_where([
				'select' => 'function, domain',
				'table' => 'contract_website',
				'where' => [
					'domain' => $canonical,
					'deleted_at' => 0,
					'publish' => 1
				],
			]);
			$response['message'] = '';
			$response['code'] = 0;
			if(isset($function) && is_array($function) && count($function)){
				$response['data'] = $function;
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

	public function catch_data_web(){
		$client = new \CodeIgniter\HTTP\CURLRequest(
		        new \Config\App(),
		        new \CodeIgniter\HTTP\URI(),
		        new \CodeIgniter\HTTP\Response(new \Config\App())
		);
		$response = $client->get('http://gomi.thegioiweb.org/frontend/display/display/send_info_api');
		$this->data['response'] = json_decode(validate_input($response->getBody()),TRUE);
		$this->data['response'] = $this->data['response']['data'];

		return $this->data['response'];
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
