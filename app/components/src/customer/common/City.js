import React, { Component } from 'react'
import axios from 'axios'

export default class City extends Component{

	constructor(props) {
	    super(props)
	    this.state = {
	    	'listCity' : [],

	    }
  	}

  	componentDidMount() {
	  	axios.get(BASE_URL + "api/customer/get_country")
	  	.then(response => {
	  		this.setState({listCity: response.data.data});
	  	});
	}
  

	render(){

		return (
			<select name="cityid" class="form-control input " onChange="b">
				<option value="0">[Chọn Thành Phố]</option>
				{
					this.state.listCity.map((data) => {
						return (
							<option value="{data.provinceid}">{data.name}</option>
						)
					})
				}
				
				
			</select>
		)
	}

	

}