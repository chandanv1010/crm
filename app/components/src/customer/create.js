import React, { Component } from 'react'
import ReactDOM from 'react-dom';
import City from  './common/city';
import Gender from  './common/gender';

export default class Create extends Component{

	
	render(){
		return (
			<section class="customer-information">
				<div class="ibox-title">
					<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
						<div class="uk-flex uk-flex-middle">
							<h5>Thông tin khách hàng</h5>
						</div>
						<div class="uk-flex">
							<div class="js_edit_all text-success m-r">Sửa</div>
							<div class="js_extend text-success pull-right cursor" data-expand="1"><u>Mở Rộng</u></div>
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row mb15">
						<div class="col-lg-6">
							<div class="form-row uk-flex uk-flex-bottom">
								<label class="control-label special text-left uk-flex uk-flex-middle">
									<span class="mr10">Họ Tên</span>
									<span class="text-success">(anh / chị ) </span>
								</label>
								<input type="text" name="fullname" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-row uk-flex uk-flex-bottom">
								<label class="control-label text-left uk-flex uk-flex-middle">
									<span class="mr10">Địa chỉ </span>
								</label>
								<input type="text" name="address" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
							</div>
						</div>
					</div>
					<div class="row mb15">
						<div class="col-lg-6">
							<div class="form-row uk-flex uk-flex-bottom">
								<label class="control-label text-left uk-flex uk-flex-middle">
									<span class="mr10">Số điện thoại </span>
								</label>
								<input type="text" name="phone" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-row uk-flex uk-flex-bottom">
								<label class="control-label text-left uk-flex uk-flex-middle">
									<span class="mr10">Thành Phố</span>
								</label>
								<City />
							</div>
						</div>
					</div>
					<div class="extend">
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày Sinh </span>
									</label>
									<input type="text" name="birthday" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Giới Tính</span>
									</label>
									<Gender />
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Công Ty</span>
										<span class="text-warning">(nếu có ) </span>
									</label>
									<input type="text" name="company" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Mã Số thuế </span>
									</label>
									<input type="text" name="company_ma" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span>Địa chỉ CT</span>
									</label>
									<input type="text" name="company_address" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span>Mã KH</span>
									</label>
									<input type="text" name="code" value="" class="form-control input js_input" placeholder="" autocomplete="off" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		)
	}

}

ReactDOM.render(<Create/>, document.getElementById('customer-store'));