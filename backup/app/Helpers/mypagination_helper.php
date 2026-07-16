<?php 
if (! function_exists('pagination_config_bt')){
	function pagination_config_bt(array $param = [],array $config = []){

		$config['base_url'] = base_url($param['url']);
		$config['suffix'] = (!empty($_SERVER['QUERY_STRING'])?('?'.$_SERVER['QUERY_STRING']):'');
		$config['first_url'] = $config['base_url'].$config['suffix'];
		$config['per_page'] = $param['perpage'];
		$config['uri_segment'] = 5;
		$config['num_links'] = 3;
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination no-margin">';
		$config['full_tag_close'] = '</ul>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a class="btn-primary">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		return $config;

		
	}
}

?>

