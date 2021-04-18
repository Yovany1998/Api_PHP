import React from 'react';
import TopBar from '../cmps/TopBar';
import axios from 'axios';

import '../css/ColeccionesPage.scss';

class ColeccionesPage extends React.Component{

	constructor(){
		super();

		this.state = {
			cols_divs: "",
			showAddPage: "none",
			ColNom: ""
		}
	}
	
	componentDidMount(){
		this.loadData();
	}

	onColClick = e =>{
		let ColCod = e.target.id;

		window.location = "#/coleccion/"+ColCod;
	}

	onAddColClick = e =>{
		this.setState({
			showAddPage: "block"
		});
	}

	onCancelClick = e =>{
		this.setState({
			showAddPage: "none"
		});
	}

	onCrearClick = e =>{
		var _this = this;
		axios.post("https://api.movil2.cointla.com/api/colecciones/crear.php", {
			ColNom: this.state.ColNom,
			ColDsc: this.state.ColNom
		}).then(res => {
			_this.loadData();
			this.setState({showAddPage: "none", ColNom: ""});

		});
	}

	render(){
		return (
			<div className="ColeccionesPage">
				<TopBar />
				<div className="AddColPage" style={{display: this.state.showAddPage}}>
					<div className="Container">
						<h3>Ingrese Nombre:</h3>
						<div className="NombreInput">
							<input placeholder="Escriba el nombre de la colección." onChange={e=>this.setState({ColNom: e.target.value})} value={this.state.ColNom}></input>
						</div>
						<div className="CrearButton" onClick={this.onCrearClick}>CREAR</div>
						<div className="CancelButton" onClick={this.onCancelClick}>CANCELAR</div>
					</div>
				</div>
				<h2 className="Title">Colecciones</h2>
				<div className="AddColButton" onClick={this.onAddColClick}><i className="material-icons">add_circle_outline</i></div>
				{this.state.cols_divs}
			</div>
		);
	}

	loadData = () =>{
		// Realizo consulta al servidor...
		axios.defaults.withCredentials = true;
		axios.post("https://api.movil2.cointla.com/api/colecciones/listado.php", {}).then(res => {
			let jres = res.data;

			if(jres.status === "OK"){
				let cols_divs = [];
				
				// Iteramos todas las colecciones para armar los divs
				for (const key in jres.payload) {
					if (Object.hasOwnProperty.call(jres.payload, key)) {
						const coleccion = jres.payload[key];
						cols_divs.push(
							<div className="CItem" key={coleccion.ColCod} id={coleccion.ColCod} onClick={this.onColClick}>
								<div className="Desc">{coleccion.ColDsc}</div>
								<div className="Icon"><i className="material-icons">arrow_forward_ios</i></div>
							</div>
						);
					}
				}

				// Actualizar el State del Componente para mostrar las colecciones
				this.setState({
					cols_divs: cols_divs
				});
			}else{
				this.setState({errorMessage: jres.payload.message});
			}
		});
	}


}

export default ColeccionesPage;