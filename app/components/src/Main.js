require('./customer/create')
require('./incident/create')


import React, { Component } from 'react';
import ReactDOM from 'react-dom';


import {
  BrowserRouter as Router,
  Switch,
  Route
} from "react-router-dom";


export default class CustomerStore extends Component {
	render (){
		return (
			<Create/>
		)
	}
}





