<?php 
use App\Models\AutoloadModel;

if (! function_exists('authentication')){
	function authentication(){
		$model = new AutoloadModel();
	 	$auth = (isset($_COOKIE[AUTH.'backend'])) ? $_COOKIE[AUTH.'backend'] : '';
	 	$auth = json_decode($auth, TRUE);
	 	$user = $model->_get_where([
            'select' =>'id, email, phone, image, fullname',
            'table' => 'user',
            'where' => ['email' => $auth['email']]
        ]);
	 	return $user;
		
	}
}

?>

