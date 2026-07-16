import React, { Component } from 'react'

export default class Gender extends Component{

	render(){
		return (
			<select name="cityid" class="form-control input  city" id="city">
				<option value="0" selected="selected">[Chọn Giới Tính]</option>
				<option value="1">Nam</option>
			</select>
		)
	}

}