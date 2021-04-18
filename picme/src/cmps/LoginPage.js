import React from 'react';
import TopBar from '../cmps/TopBar';
import axios from 'axios';
import '../css/LoginPage.scss';

class LoginPage extends React.Component{

	constructor(){
		super();

		this.state = {
			"UsrUsr": "",
			"UsrPwd": "",
			"errorMessage": ""
		}
	}

	onLoginClick = e =>{
		// Realizo consulta al servidor...
		let UsrUsr = this.state.UsrUsr;
		let UsrPwd = this.state.UsrPwd;

		axios.defaults.withCredentials = true;
		axios.post("https://api.movil2.cointla.com/api/usuarios/login.php", {
			UsrUsr: UsrUsr,
			UsrPwd: UsrPwd
		}).then(res => {
			let jres = res.data;

			if(jres.status === "OK"){
				window.location = "#/colecciones";
				window.localStorage.setItem("logued","OK");
			}else{
				this.setState({errorMessage: jres.payload.message});
			}
		});
	}

	render(){
		return (
			<div className="LoginPage">
				<TopBar />
				<div className="LogoContainer">
					<div className="Logo"></div>
				</div>
				<div className="FormContainer">
					<div className="LoginForm">
						<div className="FieldContainer">
							<input type="text" id="UsrUsr" value={this.state.UsrUsr} onChange={e => this.setState({UsrUsr: e.target.value})} placeholder="Usuario" autoComplete="new-password"></input>
						</div>
						<div className="FieldContainer">
							<input type="password" id="UsrPwd" value={this.state.UsrPwd} onChange={e => this.setState({UsrPwd: e.target.value})} placeholder="Contraseña" autoComplete="new-password"></input>
						</div>
						<div className="ErrorMessage">{this.state.errorMessage}</div>
						<div className="FieldContainer">
							<div onClick={this.onLoginClick} className="Button">Acceder</div>
						</div>
					</div>
				</div>
			</div>
		);
	}

}

export default LoginPage;