class Acciones{
	mensaje_alerta(color, mensaje, ruta){
		let mens_dan = "<div class='container' style='margin-top: 20px;'><div id='cont_2do_mensaje' class='alert alert-"+color+" text-center men_tam_comp' role='alert'>"+mensaje+"<img src='"+ruta+"' class='ml-1 img_mens'></div>";
		return mens_dan;
	}
	boton(texto, color, ruta, funcion){
		let agregar_btn = "<div class='cont_btn_agregar'><button id='most_mod_agr' class='btn btn-"+color+"' "+funcion+">"+texto+" <img src='"+ruta+"' class='img_btn_a'></button></div>";
		return agregar_btn;
	}
	modal_solicitar_expediente(){
		let solicitar_exp = "<div class='modal fade' id='exampleModal1' tabindex='-1' aria-labelledby='titulo1' aria-hidden='true'>";
		solicitar_exp += "<div class='modal-dialog'>";
        solicitar_exp += "<div class='modal-content'>";
        solicitar_exp += "<div class='modal-header'>";
        solicitar_exp += "<h5 class='modal-title' id='titulo1'>Agregar un producto</h5>";
        solicitar_exp += "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        solicitar_exp += "</div>";
        solicitar_exp += "<div class='modal-body'>";
        solicitar_exp += "<div class='col-sm-12 col-md-4 col-lg-4 col-xl-4'>";
        solicitar_exp += "<h2 class='text-center'>Formulario de registro</h2>";
        solicitar_exp += "<form action=''>";
        solicitar_exp += "<div class='mb-3'>";
        solicitar_exp +="<label for='nombre' class='form-label'>Nombre del producto</label>";
        solicitar_exp +="<input type='text'class='form-control' id='nombre' name='nombre' placeholder='Ingresa el numbre del producto' autofocus>";
        solicitar_exp +="</div>";
        solicitar_exp +="<div class='mb-3'>";
        solicitar_exp +="<label for='codigo' class='form-label'>Codigo del producto</label>";
        solicitar_exp +="<input type='number'class='form-control' id='codigo' name='codigo' placeholder='Ingresa el codigo del producto'>";
        solicitar_exp +="</div>";
        solicitar_exp +="<div class'mb-3'>";
        solicitar_exp +="<label for='precio' class='form-label'>Precio del producto</label>";
        solicitar_exp +="<input type='number'class='form-control' id='precio' name='precio' placeholder='Ingresa el codigo del producto'>";
        solicitar_exp += "<div class='my-2 container' id='cont_res_agregar' name='cont_res_agregar'></div>";
        solicitar_exp += "</div>";
        solicitar_exp += "<div class='modal-footer justify-content-center'>";
        solicitar_exp += "<button type='button' class='btn btn-success'  id='agregar_r_l' name='agregar_r_l'>Guardar</button>";
        solicitar_exp += "</div>";
        solicitar_exp += "</form>";
        solicitar_exp += "</div>";
        solicitar_exp += "</div>";
        solicitar_exp += "</div>";
        solicitar_exp += "</div>";
        solicitar_exp += "</div>";
        return solicitar_exp;
	}
    modal_expedientes_retrasados(){
        // let solicitar_exp = "<div class='modal fade' id='exampleModal1' tabindex='-1' aria-labelledby='titulo1' aria-hidden='true'>";
		// solicitar_exp += "<div class='modal-dialog'>";
        // solicitar_exp += "<div class='modal-content'>";
        // solicitar_exp += "<div class='modal-header'>";
        // solicitar_exp += "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
        // solicitar_exp += "</div>";
       let solicitar_exp = "<div >";
        solicitar_exp += "<h1>Hay  expedientes con retraso que no ha sido devueltos</h1>";
        solicitar_exp += "</div>";
        // solicitar_exp += "</div>";
        // solicitar_exp += "</div>";
        // solicitar_exp += "</div>";   
        return solicitar_exp;
    }
};
let accion = new Acciones();