import React from 'react';
import TopBar from '../cmps/TopBar';
import axios from 'axios';
import {useParams} from 'react-router-dom';

import '../css/ColeccionPage.scss';

class ColeccionPage extends React.Component{

	constructor(){
		super();

		this.state = {
			col_fotos: "",
            col_name: "",
			showLoading: "none"
		}
	}
	
	componentDidMount(){
		this.loadData(this.props.ColCod);
	}

	onAddFotoClick = e =>{
		document.getElementById("file").click();
	}

	onFotoSelected = e =>{
		var imageFile = document.getElementById("file");
		let fsize = imageFile.files[0].size;

		if(fsize <= 19000000){
			var formData = new FormData();
			formData.append("ColCod", this.props.ColCod);
			formData.append("FotFile", imageFile.files[0]);
			var _this = this;

			this.setState({showLoading: "block"});

			axios.post("https://api.movil2.cointla.com/api/fotos/crear.php", formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				}
			}).then(res=>{
				_this.loadData(_this.props.ColCod);
				this.setState({showLoading: "none"});
			});

		}else{
			alert("La fotografia es un pesada (2MB Máximo)");
		}
	}

	render(){
		return (
			<div className="ColeccionPage">
				<TopBar backTo="#/colecciones" deleteCol={this.props.ColCod} />
				<h2 className="Title">{this.state.col_name}</h2>
				<div className="LoadingAxios" style={{display: this.state.showLoading}}>
					<div class="lds-ripple"><div></div><div></div></div>
					<div class="LoadingText">Cargando...</div>
				</div>
				<input type="file" onChange={this.onFotoSelected} name="file" id="file" style={{display: "none"}} />
				<div className="AddFotoButton" onClick={this.onAddFotoClick}><i className="material-icons">add_a_photo</i></div>
				<div className="FotosContainer">
					{this.state.col_fotos}
				</div>
			</div>
		);
	}

	loadData = ColCod =>{
		// Realizo consulta al servidor...
		var _this = this;
		axios.defaults.withCredentials = true;
		axios.post("https://api.movil2.cointla.com/api/colecciones/obtener.php", {
            ColCod: ColCod
        }).then(res => {
			let jres = res.data;

			if(jres.status === "OK"){
				let col_fotos = [];
                let col_name = jres.payload.ColDsc;
				
				// Iteramos todas las fotos para armar los divs
				for (const key in jres.payload.fotos) {
					if (Object.hasOwnProperty.call(jres.payload.fotos, key)) {
						const foto = jres.payload.fotos[key];
                        let foto_url = "https://api.movil2.cointla.com/data"+foto.FotPath;

						let onDeleteClick = e =>{
							axios.post("https://api.movil2.cointla.com/api/fotos/eliminar.php", {
								ColCod: ColCod,
								FotCod: foto.FotCod
							}).then(res => {
								_this.loadData(_this.props.ColCod);
							});
						}

						col_fotos.push(
							<div className="FItem" key={foto.FotCod} id={foto.FotCod} style={{backgroundImage: "url("+foto_url+")"}}>
								<div className="inFotoIcon" onClick={onDeleteClick}><i className="material-icons">delete</i></div>
							</div>
						);
					}
				}

				// Actualizar el State del Componente para mostrar la coleccion y fotos
				this.setState({
					col_fotos: col_fotos,
                    col_name: col_name
				});
			}else{
				this.setState({errorMessage: jres.payload.message});
			}
		});
	}


}


let _ColeccionPage = function(){
    let {ColCod} = useParams();
    return (<ColeccionPage ColCod={ColCod}></ColeccionPage>)
}

export default _ColeccionPage;