import React, { Component } from 'react'
import ReactDOM from 'react-dom';

export default class CreateIncident extends Component{

	render(){
		return (
			<section class="incident-wrapper">
				<div class="ibox-title">
					<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
						<div class="uk-flex uk-flex-middle">
							<h5>Vấn đề của khách hàng</h5>
						</div>
					</div>
				</div>
				<div class="ibox-content">
					<div class="row mb15">
						<div class="col-lg-6 b-r">
							<div class="form-row">
								<ul class="uk-clearfix uk-list incident-list">
									<li>
										<div class="incident-item gh active">
											Phòng gia hạn: Được dịch từ tiếng Anh-Trong xuất bản và thiết kế đồ họa, Lorem ipsum là một văn bản giữ chỗ thường được sử dụng để thể hiện hình thức trực quan của một tài liệu hoặc một kiểu chữ mà không dựa vào nội dung có ý nghĩa - <span>10:51 22/08/2020.</span>
										</div>
									</li>
									<li>
										<div class="incident-item gh">
											Phòng gia hạn: Được dịch từ tiếng Anh-Trong xuất bản và thiết kế đồ họa, Lorem ipsum là một văn bản giữ chỗ thường được sử dụng để thể hiện hình thức trực quan của một tài liệu hoặc một kiểu chữ mà không dựa vào nội dung có ý nghĩa -  <span>10:51 22/08/2020.</span>
										</div>
									</li>
									<li>
										<div class="incident-item boss">
											Phòng gia hạn: Được dịch từ tiếng Anh-Trong xuất bản và thiết kế đồ họa, Lorem ipsum là một văn bản giữ chỗ thường được sử dụng để thể hiện hình thức trực quan của một tài liệu hoặc một kiểu chữ mà không dựa vào nội dung có ý nghĩa -  <span>10:51 22/08/2020.</span>
										</div>
									</li>
									<li>
										<div class="incident-item cskh">
											Phòng CSKH: Nguyễn Công Tuấn chuyển hợp đồng cho bộ phận gia hạn - <span>10:51 22/08/2020.</span>
										</div>
									</li>
									<li>
										<div class="incident-item boss">
											Ban Giám Đốc: Nguyễn Công Tuấn chuyển hợp đồng cho bộ phận gia hạn - <span>10:51 22/08/2020.</span>
										</div>
									</li>
									<li>
										<div class="incident-item kt">
											Phòng Kế Toán: Nguyễn Công Tuấn chuyển hợp đồng cho bộ phận gia hạn - 10:10 22/08/2019
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="discussion">
								<div class="chat-message left">  
									<div class="message-item">
										<a class="message-author" href="#">phuongnt</a> (01-11-2019) :- Gia hạn thành công 2019
									</div>
								</div>
								<div class="chat-message left">  
									<div class="message-item">
										<a class="message-author" href="#">tuannc</a> (01-11-2019) :- Đã nhận yêu cầu gia hạn, khách hàng cần làm thêm website, đề nghị bên Sale Check lại.
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		)
	}

}

ReactDOM.render(<CreateIncident/>, document.getElementById('incident-store'));