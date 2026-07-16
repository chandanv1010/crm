<?php


if(!function_exists('getOption')){
	function getOption(string $field = ''){
		$data['status'] = array(
			0 => '- Chọn tình trạng -',
			1 => 'Đã kết thúc',
			2 => 'Chưa kết thúc',
		);

		$data['process'] = array(
			0 => '- Chọn trạng thái -',
			1 => 'Đã hoàn thành',
			2 => 'Chưa hoàn thành',
		);

		if($field != ''){
			return $data[$field];
		}
		return $data;
	}
}

if(!function_exists('write_url')){
	function write_url($canonical = '', $suffix = TRUE, $fulllink = FALSE){
		$domain = ($fulllink == TRUE)?BASE_URL:'';
		if(!empty($canonical)) return ($suffix == TRUE)?($domain.$canonical.HTSUFFIX):($domain.$canonical);
	}
}

if(!function_exists('check_isset')){
	function check_isset(string $check = ''){
		return (isset($check) ? $check : '');
	}
}

if(!function_exists('view_cells')){
	function view_cells(string $module = ''){
		$module = explode('_',  $module);
		$new_module = [];
		foreach ($module as $key => $value) {
			$new_module[] = ucwords($value);
		}
		if(!isset($new_module[1])){
			$new_module[1] = $new_module[0];
		}
		$view =  '\App\Controllers\Frontend\\';
		foreach ($new_module as $key => $value) {
			$view = $view.$value.((isset($new_module[$key + 1])) ? '\\' : '').((!isset($new_module[$key + 1])) ? '::index' : '');
		}
		return $view;
	}
}

if(!function_exists('convertTime')){
	function convertTime($time){
		$time = str_replace('/','-', $time);
		return $time;
	}
}

if(!function_exists('gettime')){
	function gettime($time, $type = 'H:i - d/m/Y'){
		
		if($type == 'datetime'){
			$type = 'Y-m-d H:i:s';
		}
		if($type == 'date'){
			$type = 'Y-m-d';
		}
		return gmdate($type, strtotime($time) + 7*3600);
	}
}

if(!function_exists('currentTime')){
	function currentTime(){
		$currentTime =  gmdate('Y-m-d H:i:s', time() + 7*3600);
		return $currentTime;
	}
}


if(!function_exists('getthumb')){
	function getthumb(string $string = '', bool $thumb = true){
		$image = '';

		if(!file_exists(dirname(dirname(dirname(__FILE__))).$image) ){
			$image = 'public/not-found.png';
		}
		if($thumb == TRUE){
			$thumbUrl = str_replace('/upload/image', '/upload/thumb/Images', $string);
			if (file_exists(dirname(dirname(dirname(__FILE__))).$thumbUrl)){
				return $thumbUrl;
			}
		}
		return $string;
	}
}


if(!function_exists('convertMoney')){
	function convertMoney(string $string = ''): float{
		return (float)str_replace('.','', $string);
	}
}



if (! function_exists('validate_input')){
	function validate_input(string $string): string{
		return htmlspecialchars_decode(html_entity_decode($string));
	}
}


if (! function_exists('password_encode')){
	function password_encode(string $password, string $salt): string{
		return md5(md5($salt.$password));
	}
}


if (! function_exists('pre')){
	function pre($param, $flag = true){
		echo '<pre>';
		print_r($param);
		if($flag == true){
			die();
		}

	}
}


if (! function_exists('convertArray')){
	function convert_array($param){
		if($param['text'] != ''){
			$array[0] = '[Chọn '.$param['text'].']';
		}
		if(isset($param['data']) && is_array($param['data']) && count($param['data'])){
			foreach($param['data'] as $key => $val){
				$array[$val[$param['field']]] = $val[$param['value']];
			}
		}

		return $array;
	}
}

// tạo thông báo
if(!function_exists('show_flashdata')){
	function show_flashdata($body = TRUE){;
		$result = [];
		$session = session();
		$message = $session->getFlashdata('message-success');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 0;
			return $result;
		}
		$message = $session->getFlashdata('message-danger');
		$result['message'] = $message;
		if(isset($message)){
			$result['flag'] = 1;
		}


		return $result;
	}
}


if(!function_exists('removeutf8')){
	function removeutf8($value = NULL){
		$chars = array(
			'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
			'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
			'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
			'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
			'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
			'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
			'd'	=>	array('đ','Đ'),
		);
		foreach ($chars as $key => $arr)
			foreach ($arr as $val)
				$value = str_replace($val, $key, $value);
		return $value;
	}
}

if(!function_exists('slug')){
	function slug($value = NULL){
		$value = removeutf8($value);
		$value = str_replace('-', ' ', trim($value));
		$value = preg_replace('/[^a-z0-9-]+/i', ' ', $value);
		$value = trim(preg_replace('/\s\s+/', ' ', $value));
		return strtolower(str_replace(' ', '-', trim($value)));
	}
}

if(!function_exists('longDay')){
	function longDay($date){
		$date = explode(' ', $date);
		$currentTime =gmdate('Y-m-d', time() + 7*3600);
		$date1 = new DateTime($date[0]);
		$date2 = new DateTime($currentTime );
		$diff = $date1->diff($date2);
		print_r($diff);
		return ($diff)->days; 
	}
}

if(!function_exists('dayWarning')){
	function dayWarning($day){
		$class= '';
		if($day <= 0){
			$class = 'warning-1';
		} else if($day <= 15){
			$class = 'warning-2';
		}
		return $class;
	}
}


?>
