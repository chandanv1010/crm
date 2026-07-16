<?php 
use App\Models\AutoloadModel;
// lay tong thu/chi 1 ki
if (! function_exists('get_money_end')){
	function get_money_end($id){
		$model = new AutoloadModel();
	 	// lay chi/thu/ton cua thang
	 	$money_month = get_money_month($id);

	 	$object = $model->_get_where([
            'select' => 'money_start, money_end',
            'table' => 'cash_periodic',
            'where' => ['id' => $id],
        ]);
	 	if($money_month['exist'] != ($object['money_start'] + $object['money_end'])){
 			$money_end = ($object['money_start'] + $money_month['exist']);
	 		$flag = $model->_update([
	 			'table' => 'cash_periodic',
	 			'data' => ['money_end' => $money_end],
	 			'where' => ['id' => $id]

 	 		]);
 	 		if($flag > 0 ){
 	 			return $money_end;
 	 		}
	 	}
	 	return $object['money_end'];
	}
}

if (! function_exists('accept_insert_money')){
	function accept_insert_money($param = []){
		$model = new AutoloadModel();
		$flag = 0;
		if(isset($param) && is_array($param) && count($param)){
			$periodicid_newest = $model->_get_where([
	            'select' => 'id',
	            'table' => 'cash_periodic',
	            'where' => ['publish' => 1, 'deleted_at' => 0],
	            'order_by' => 'id desc'
	        ]);
	        $periodicid = $model->_get_where([
	            'select' => 'id',
	            'table' => 'cash_periodic',
	            'where' => ['publish' => 1, 'deleted_at' => 0,'id' => $periodicid_newest['id'],'date_start <=' => $param['date_start'],'date_end >=' => $param['date_start']],
	            'order_by' => 'id desc',
	            'count' => true
	        ]);
	        if($periodicid == 0){
	        	return $flag;
	        }

	        if($param['method'] =='create' || $param['method'] == 'update'|| $param['method'] == 'extend'){
				$save = [
					'title' => $param['domain'],
					'objectid' => $param['id'],
					'catalogueid' => $param['catalogueid'],
					'periodicid' => $periodicid_newest['id'],
					'branchid' => $param['branchid'],
					'money_collect' => $param['total'],
					'deleted_at' => 0,
					'publish' => 1
				];
				if($param['method'] == 'create' ||  $param['method'] == 'extend'){
					$save['created_at'] = $param['date_start'];
		 			$save['userid_created'] = $param['userid'];
		 			$save['publish'] = 1;
		 		}else{
		 			$save['updated_at'] = $param['updated_at'];
		 			$save['userid_updated'] = $param['userid'];
	        	}
	        	if($param['method'] == 'extend'){
	        		$save['title'] =  'Gia hạn tên miền '.$param['domain'];
	        	}
	 		}
			if($param['method'] == 'create' || $param['method'] == 'extend'){
				$flag = $model->_insert([
	 				'data' => $save,
	 				'table' => 'cash',
	 			]);
			}else if($param['method'] == 'update'){
				$flag =  $model->_update([
	 				'data' => $save,
	 				'table' => 'cash',
	 				'where' => ['objectid' => $param['id'],'catalogueid' => $param['catalogueid'],'created_at' =>  $param['date_start']]
	 			]);
			}else if($param['method'] == 'upgrade'){
				if($param['add_payment'] != 0){
					$store = [
						'title' => 'Nâng cấp tên miền '.$param['domain'],
						'objectid' => $param['id'],
						'catalogueid' => $param['catalogueid'],
						'periodicid' => $periodicid_newest['id'],
						'branchid' => $param['branchid'],
						'money_collect' => $param['total'],
						'deleted_at' => 0,
						'publish' => 1,
						'created_at' => gettime($param['date_start'],'Y-m-d').' 00:00:00',
						'userid_created' => $param['userid'],
			 			'publish' => 1,
					];
					$flag = $model->_insert([
		 				'data' => $store,
		 				'table' => 'cash',
		 			]);
				}
			}
		}
	 	// lay chi/thu/ton cua thang
	 	// $money_month = get_money_month($id);

	 	// $object = $model->_get_where([
   //          'select' => 'money_start, money_end',
   //          'table' => 'cash_periodic',
   //          'where' => ['id' => $id],
   //      ]);
	 	// if($money_month['exist'] != ($object['money_start'] + $object['money_end'])){
 		// 	$money_end = ($object['money_start'] + $money_month['exist']);
	 	// 	$flag = $model->_update([
	 	// 		'table' => 'cash_periodic',
	 	// 		'data' => ['money_end' => $money_end],
	 	// 		'where' => ['id' => $id]

 	 // 		]);
 	 // 		if($flag > 0 ){
 	 // 			return $money_end;
 	 // 		}
	 	// }
	 	return $flag;
	}
}

if (! function_exists('delete_catalogue')){
	function delete_catalogue(array $param = []){
		$model = new AutoloadModel();
		$module = explode('_',  $param['module']);
		$flag = 0;
		$catid = $model->_get_where([
			'select' => 'id',
			'table' => $param['module'],
           	'where' => [
           		'lft >=' => $param['lft'],
				'rgt <=' => $param['rgt'],
				'deleted_at' => 0
           	]
		], TRUE);
		$router  = $catid;
		if(isset($catid) && is_array($catid) && count($catid)){
			foreach ($catid as $key => $value) {
				$catid[$key]['deleted_at'] = 1;
			}

			$flag = $model->_update_batch([
				'table' => $param['module'],
				'data' => $catid,
				'field' => 'id'
			]);
			foreach ($router as $key => $value) {
				$model->_update([
		            'table' => 'router',
		            'data' => [
		            	'canonical' => ''
		            ],
		            'where' => [
		            	'objectid' => $value['id'],
		            	'language' => $param['language'],
		            	'module' => $param['module']
		            ]
		        ]);
			}
			if($flag > 0){
				$id = [];
				foreach ($catid as $key => $value) {
					$id[] = $value['id'];
				}
				$store = $model->_get_where([
					'select' => 'id',
					'table' => $module[0],
		           	'where_in' => $id,
		           	'where_in_field' => 'catalogueid',
		           	'where' => [
		           		'deleted_at' => 0
		           	]
				],TRUE);
				$router_blog = $store;
				if(isset($store) && is_array($store) && count($store)){
					foreach ($store as $key => $value) {
						$store[$key]['deleted_at'] = 1;
					}
					$result = $model->_update_batch([
						'table' => $module[0],
						'data' => $store,
						'field' => 'id'
					]);
					foreach ($router_blog as $key => $value) {
						$model->_update([
				            'table' => 'router',
				            'data' => [
				            	'canonical' => ''
				            ],
				            'where' => [
				            	'objectid' => $value['id'],
				            	'language' => $param['language'],
				            	'module' => $module[0]
				            ]
				        ]);	
					}
				}
			}
		}
		return $flag;
	}
}


if (! function_exists('delete_router')){
	function delete_router($id = '', $module = '', $language = ''){
		$model = new AutoloadModel();

	 	$object = $model->_update([
            'table' => 'router',
            'data' => [
            	'canonical' => '',
            ],
            'where' => [
            	'language' => $language,
            	'objectid' => $id,
            	'module' => $module,
            ],
        ]);
	 	return $object;
	}
}


if (! function_exists('get_money_month')){
	function get_money_month($id){
		$model = new AutoloadModel();
		
	 	$object = $model->_get_where([
            'select' => 'SUM(money_collect) as all_collect, SUM(money_pay) as all_pay, (SUM(money_collect) - SUM(money_pay) ) as exist,',
            'table' => 'cash',
            'where' => ['periodicid' => $id, 'deleted_at' => 0],
        ]);
		
	 	return $object;
	}
}

// lay tong thu/chi theo ngay
if (! function_exists('get_money_day')){
	function get_money_day($id){
		$model = new AutoloadModel();
		
	 	$object = $model->_get_where([
            'select' => 'SUM(money_collect) as all_collect, SUM(money_pay) as all_pay, (SUM(money_collect) - SUM(money_pay) ) as exist, created_at',
            'table' => 'cash',
            'where' => ['periodicid' => $id, 'deleted_at' => 0],
            'group_by' => 'DAY( created_at )',
            'order_by' => 'created_at desc',
        ], TRUE);
	 	$money_mounth = [];
		foreach ($object as $key => $value) {
			$created_at = explode(' ', $value['created_at']);
			$created_at[0] = date("d/m/Y", strtotime($created_at[0]));
			$money_mounth[$created_at[0]]['all_collect'] = $value['all_collect'];
			$money_mounth[$created_at[0]]['all_pay'] = $value['all_pay'];
			$money_mounth[$created_at[0]]['exist'] = $value['exist'];
		}

	 	return $money_mounth;
	}
}

// lay list cac ki
if (! function_exists('cash_periodic')){
	function cash_periodic(){
		$array = [];
		$model = new AutoloadModel();

	 	$object = $model->_get_where([
            'select' => 'id,title, date_start',
            'table' => 'cash_periodic',
            'where' => ['publish' => 1, 'deleted_at' => 0],
            'order_by' => 'id desc'
        ], TRUE);

		if(isset($object) && is_array($object) && count($object)){
			foreach($object as $key => $val){
				$time = gettime($val['date_start'],'d/m/Y');
				$time = explode('/', $time);
				$array[$val['id']] = $val['title'].' - tháng '.$time[1].' năm '.$time[2];
			}
		}
        
	 	return $array;
	}
}

// lay list phong ban
if (! function_exists('user_catalogueList')){
	function user_catalogueList(){
		$model = new AutoloadModel();

	 	$object = $model->_get_where([
            'select' => 'id,title',
            'table' => 'user_catalogue',
            'where' => ['publish' => 1, 'deleted_at' => 0],
            'order_by' => 'id desc'
        ], TRUE);
        $object = convert_array([
				'data' => $object,
				'field' => 'id',
				'value' => 'title',
				'text' => 'phòng ban',
			]);
	 	return $object;
	}
}

// lay list nhom tien mat
if (! function_exists('cash_catalogue')){
	function cash_catalogue(){
		$model = new AutoloadModel();

	 	$object = $model->_get_where([
            'select' => 'id,title',
            'table' => 'cash_catalogue',
            'where' => ['publish' => 1, 'deleted_at' => 0],
            'order_by' => 'id desc'
        ], TRUE);
        $object = convert_array([
				'data' => $object,
				'field' => 'id',
				'value' => 'title',
				'text' => 'nhóm',
			]);
	 	return $object;
	}
}

if (! function_exists('get_data')){
	function get_data(array $param = []){
		$model = new AutoloadModel();

		$where = [];
		if(isset($param['where'])){
			$where = $param['where'];
		}
	 	$object = $model->_get_where([
            'select' => $param['select'],
            'table' => $param['table'],
            'where' => $where,
            'order_by' => $param['order_by']
        ], TRUE);
	 	return $object;
	}
}
// lay list nhan vien(phu trach)
if(!function_exists('staff')){
	function staff(){
		$staff = new AutoloadModel();
		$staffInfo = $staff->_get_where([
			'table' => 'user',
			'select' => 'fullname, id',
			'where' => ['publish' => 1, 'deleted_at' => 0],
			'order_by' => 'fullname asc',
		], true);
		return $staffInfo;
	}
}
if(!function_exists('city')){
	function city(){
		$city = new AutoloadModel();
		$cityList = $city->_get_where([
			'table' => 'vn_province',
			'select' => 'name, provinceid',
			'order_by' => 'order desc, name asc',
		], true);
		$cityList = convert_array([
            'data' => $cityList,
            'field' => 'provinceid',
            'value' => 'name',
            'text' => 'Tỉnh/ Thành phố',
        ]);
		return $cityList;
	}
}

if (! function_exists('count_object')){
	function count_object(array $param = []){
		$model = new AutoloadModel();

		$catalogueid = $param['catalogueid'];

		$id = [];	
		if($catalogueid > 0){
			$catalogue = $model->_get_where([
				'select' => 'id, lft, rgt, title',
				'table' => $param['module'].'',
				'where' => ['id' => $catalogueid],
			]);

			$catalogueChildren = $model->_get_where([
				'select' => 'id',
				'table' => $param['module'].'',
				'where' => ['lft >=' => $catalogue['lft'],'rgt <=' => $catalogue['rgt']],
			], TRUE);

			$id = array_column($catalogueChildren, 'id');
		}

		$count = 0;
		$module = explode('_',  $param['module']);
		if(isset($id) && is_array($id)  && count($id)){
			$count = $model->_get_where([
				'select' => 'tb1.id',
				'table' => current($module).' as tb1',
				'where' => [
					'tb1.deleted_at' => 0,
					'tb1.publish' => 1,
				],
				'where_in' => $id,
				'where_in_field' => 'tb2.catalogueid',
				'join' => [
					[
						'object_relationship as tb2', 'tb1.id = tb2.objectid AND tb2.module = \''.current($module).'\' ', 'inner'
					],
					[
						'user as tb3','tb1.userid_created = tb3.id','inner'
					]
				],
				'group_by' => 'tb1.id',
				'count' => TRUE
			]);
		}

		

		return $count;
		
	}
}

if (! function_exists('get_catalogue_object')){
	function get_catalogue_object(array $param = []){
		$model = new AutoloadModel();


		$object = $model->_get_where([
		  	'select' => 'id, title',
            'table' => $param['module'].'_catalogue',
            'where' => ['deleted_at' => 0],
            'where_in' => $param['catalogue'],
            'where_in_field' => 'id',
            'order_by' => 'title asc'
		], TRUE);

		return $object;
		
	}
}

?>

