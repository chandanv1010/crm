<?php
namespace App\Controllers\Backend\Dashboard;
use App\Controllers\BaseController;

class Dashboard extends BaseController{

	protected $data;

	public function __construct(){
		$this->data = [];
	}

	public function index($id = 0, $page = 0){
		$this->data['check'] = $this->authentication->check_permission([
			'routes' => 'backend/dashboard/dashboard/index'
		]);
		$param = $this->AutoloadModel->_get_where([
			'select' => 'id, title, money_start, money_end, description, date_start, date_end',
			'table' => 'cash_periodic',
			'limit' => 6,
			'order_by' => 'id desc',
		], TRUE);
		$param = array_reverse($param);
		$this->data['website'] = [];
		if(isset($param) && is_array($param) && count($param)){
			$this->data['periodicList'] = $this->periodiclist($param);
			foreach ($param as $key => $value) {
				$this->data['periodicId'][] = $value['id'];
			}
			$this->data['hosting'] = $this->data_hosting($param, $this->data['periodicId']);
			$this->data['website'] = $this->data_website($param, $this->data['periodicId']);
		}
		$revenue = $this->data_revenue($this->data['periodicId']);
		$this->data['money_end']= $revenue['money_end'];
		$this->data['money_pay']= $revenue['money_pay'];
		$cash = $this->data_cash($this->data['periodicId']);
		$this->data['mien_bac']	= $cash['mien_bac'];
		$this->data['mien_nam']	= $cash['mien_nam'];
		$customer = $this->data_customer($this->data['periodicId']);
		$this->data['customer']['title'] = $customer['title'];
		$this->data['customer']['number'] = $customer['number'];
		$this->data['periodic_in_year'] = $this->periodic_in_year();


		$this->data['sum_pay'] = $this->sum_pay();
		$this->data['template'] = 'backend/dashboard/home/index';
		return view('backend/dashboard/layout/home', $this->data);
	}

	public function periodiclist($param = []){
		$periodicList = [];
		foreach ($param as $key => $value) {
			$periodicList[] = $value['title'];
		}

		foreach ($periodicList as $key => $value) {
			$value = str_replace('thang ','', strtolower(trim(removeutf8($value))));
			$periodicList[$key] = $value;
		}
		return $periodicList;
	}

	public function data_hosting($param = [], $id = []){
		$date_start = $param[0]['date_start'];
		$date_end = $param[5]['date_end'];
		$result = [];
		$hosting = $this->AutoloadModel->_get_where([
			'select' => 'SUM(money_collect) as total,branchid, periodicid',
			'table' => 'cash',
			'where' => [
				'catalogueid' => 8
			],
			'where_in' => $id,
			'where_in_field' => 'periodicid',
			'group_by' => 'periodicid',
			'order_by' => 'periodicid asc'
		], true);
		foreach ($hosting as $key => $value) {
			$result[] = $value['total'];
		}
		return $result;
	}

	public function data_website($param = [], $id = []){
		$result = [];
		$website = $this->AutoloadModel->_get_where([
			'select' => 'SUM(money_collect) as total,branchid, periodicid',
			'table' => 'cash',
			'where' => [
				'catalogueid' => 6
			],
			'where_in' => $id,
			'where_in_field' => 'periodicid',
			'group_by' => 'periodicid',
			'order_by' => 'periodicid asc'
		], true);
		foreach ($website as $key => $value) {
			$result[] = $value['total'];
		}

		return $result;
	}

	public function data_revenue($id = []){
		$result = [];
		$money_end = [];
		$money_pay = [];
		$revenue = $this->AutoloadModel->_get_where([
			'select' => 'SUM(money_collect) as total,SUM(money_pay) as pay, periodicid',
			'table' => 'cash',
			'where_in' => $id,
			'where_in_field' => 'periodicid',
			'group_by' => 'periodicid',
			'order_by' => 'periodicid asc'
		], true);
		foreach ($revenue as $key => $value) {
			$money_end[] = $value['total'];
			$money_pay[] = $value['pay'];
		}
		$result['money_end'] = $money_end;
		$result['money_pay'] = $money_pay;

		return $result;
	}

	public function sum_pay($id = []){
		$result = [];
		$money_end = [];
		$money_pay = [];
		$sum_pay = $this->AutoloadModel->_get_where([
			'select' => 'SUM(tb1.money_pay) as pay, tb1.catalogueid, tb2.title',
			'table' => 'cash as tb1',
			'join' => [
				[
					'cash_catalogue as tb2','tb1.catalogueid = tb2.id AND tb2.deleted_at = 0','inner'
				]
			],
			'group_by' => 'tb1.catalogueid',
			'order_by' => 'tb1.catalogueid asc'
		], true);
		$sum = 0;
		if(isset($sum_pay) && is_array($sum_pay) && count($sum_pay)){
			foreach ($sum_pay as $key => $value) {
				if($value['pay'] == 0){
					unset($sum_pay[$key]);
				}
				$sum = $sum + $value['pay'];
			}
		}
		return [
			'data' => $sum_pay,
			'sum'=> $sum
		];
	}

	public function data_cash($id = []){
		$result = [];
		$cash = $this->AutoloadModel->_get_where([
			'select' => 'SUM(money_collect) as total,branchid, periodicid',
			'table' => 'cash',
			'where_in' => $id,
			'where_in_field' => 'periodicid',
			'group_by' => 'periodicid,branchid',
			'order_by' => 'periodicid asc'
		], true);
		$mien_bac	= [];
		$mien_nam	= [];

		foreach ($cash as $key => $value) {
			if($value['branchid'] == 1){
				$mien_bac[]	= $value['total'];
			}
			if($value['branchid'] ==2){
				$mien_nam[]	= $value['total'];
			}
		}
		$result['mien_bac'] = $mien_bac;
		$result['mien_nam'] = $mien_nam;
		return $result;
	}

	public function data_customer(){
		$data = [];
		$customer = $this->AutoloadModel->_get_where([
			'select' => 'COUNT(tb1.id) as total, tb1.cityid, tb2.name',
			'table' => 'customer as tb1',
			'join' => [
				[
					'vn_province as tb2','tb1.cityid = tb2.provinceid','inner'
				]
			],
			'group_by' => 'tb1.cityid',
			'order_by' => 'tb1.cityid asc'
		], true);
		foreach ($customer as $key => $value) {
			$data['title'][$value['cityid']] = $value['name'];
			$data['number'][$value['cityid']] = $value['total'];
		}
		$sum = 0;
		foreach ($data['number'] as $key => $value) {
			if($key != '01TTT' && $key != '79TTT'){
				$sum = $sum + $value;
				unset($data['title'][$key]);
				unset($data['number'][$key]);
			}
		}
		array_push($data['title'],'Tỉnh thành khác');
		array_push($data['number'],$sum);
		$data['title'] = array_values($data['title']);
		$data['number'] = array_values($data['number']);
		return $data;
	}

	public function periodic_in_year()
    {
       	$date_first = $this->setDate(date("Y"),1,1);
		$date_end = $this->setDate(date("Y"),12,31);
		$result = [];
		$param = [];
		$periodic_in_year = $this->AutoloadModel->_get_where([
			'select' => 'id, title, money_start, money_end, description, date_start, date_end',
			'table' => 'cash_periodic',
			'limit' => 12,
			'where' => [
				'date_start >=' => $date_first,
				'date_end <=' => $date_end,
			],
			'order_by' => 'id asc',
		], TRUE);
		$id = [];
		foreach ($periodic_in_year as $key => $value) {
			$id[] = $value['id'];
		}

		$total = [];

		$revenue = $this->AutoloadModel->_get_where([
			'select' => 'SUM(money_collect) as total,SUM(money_pay) as pay, periodicid',
			'table' => 'cash',
			'where_in' => $id,
			'where_in_field' => 'periodicid',
			'group_by' => 'periodicid',
			'order_by' => 'periodicid asc'
		], true);
		foreach ($revenue as $key => $value) {
			$total[] = $value['total'] - $value['pay'];
		}

		$param['list'] = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'];
		$param['total'] = $total;
		return $param;
    }

	public function setDate($year, $month, $day)
    {
        if (null == $year) {
            $year = $this->format('Y');
        }
        if (null == $month) {
            $month = $this->format('n');
        }
        if (null == $day) {
            $day = $this->format('j');
        }
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $day = $day > $daysInMonth ? $daysInMonth : $day;
        $return = $year.'-'.$month.'-'.$day.' 00:00:00';
        return $return;
    }
}
