// -------------LOGIN-------------
//boton logearse

$('#entrar').on("click", function(){
	usuario.login_usuario();
});
// -------------------------------
// boton de la tabla 1 mostrar expedientes solicitados
function hh(ci){
	usuario.expedientes_soli_personal(ci);
}
// mostrara valor tabla de modal 1 solicitar expediente
function most_mod_agr(ci_per_s){
	$("#error_soli_exp1").html("");
	$("#solicitante").val("");
	$("#observacion").val("");
	usuario.selec_analis($("#solicitante").val(), ci_per_s);
	$("#exampleModal1").modal("show");
	$("#mod1").css("width","1000px");
};
// mostrar analistas al precionar tecla en el campo
$("#solicitante").on("keyup",function(){
	usuario.selec_analis($("#solicitante").val(), $("#ci_per_agre_exp").val());
	if($("#analista").val() != null){
		$("#error_soli_exp1").html("");
	}
});
// accione que se activara a arrastrar en el modal agregar expediente pdf

$('#btn_mod_exp').on('click', function() {
	if($("#file").val() === ""){
		alert("vacio");
		return
	}
	
	const archivo = $("#file")[0].files[0];
	const extension = archivo.name.split(".").pop().toLowerCase();

	if (extension !== "pdf") {
	alert("El archivo no es un PDF");
	}else{
      //Todas las propiedades del Archivo
      //El método prop() nos sirve para poder modificar las propiedades nativas de Javascript 
      //de los elementos de una página, Ejemplo $('#checkbox1').prop("checked", true);
      var file_data = $('.file').prop('files')[0];
      var fileName = file_data.fileName;
      var fileSize = file_data.fileSize;

      console.log(file_data);
	  console.log(fileName);
	  console.log(fileSize);

    //   if(file_data != undefined) {
          var form_data = new FormData();  
          console.log(form_data)  
                        
          form_data.append('file', file_data);
		  alert(form_data);
		  saludo = "hola";
        // usuario.subir_expediente_pdf(saludo);
		  //   $.ajax({
        //       type: 'POST',
        //       url: 'model/ajax/ajax_subir_expediente.php',
        //       contentType: false,
        //       processData: false,
        //       data: {saludo: saludo},
        //       success:function(response) {
        //         alert(response);
		// 		//   if(response == 'success') {
        //         //       console.log('Archivo subido');
        //         //       //Llamando mi funcion
        //         //       mensajeToast();
        //         //   } else {
        //         //       console.log('Error al subir Archivo');
        //         //   }
        //         //   //Limpio el input type File
        //         //   $('.file').val('');
        //       },
		// 	  error: function(error){
		// 		alert(error);
		// 	  }
        //   });
    //   }
	}
  });
// fin del dragover modal pdf


// btn guardar solicitud de expediente
$("#agre_solicitar_exp").on("click", function(){
		$("#error_soli_exp1").html("");
		$("#exampleModal1").modal("hide");
		let ci_entregar_exp = $("#ci_per_agre_exp").val();
		let analis = $("#analista").val();
		let observacion = $("#observacion").val();
		usuario.expediente_entregado(analis, ci_entregar_exp, observacion);
		$("#solicitante").val("");
});
// modal de devovelver expedientes solicitados - persona
function modal2_devol_exp_per(ci){
	$("#exampleModal2").modal("show");
	let modal_dev_exp = "<h2 class='text-center' id='id_tit_mod1'>Recibir expediente</h2>";
        modal_dev_exp += "<form action='>";
		modal_dev_exp += "<div class='mb-3 cont_mod1_entregado' >";
		modal_dev_exp += "<div class='modal-footer justify-content-center'>";
		modal_dev_exp += "<button type='button' class='btn btn-success'  id='btn_recivir_expediente' name='btn_recivir_expediente' onclick='rec_exp("+ci+")'>Si</button>";
		modal_dev_exp += "</div>";
		modal_dev_exp += "<div class='mb-2' id='error_soli_exp1'></div>";
		modal_dev_exp += "</form>";

	$("#modal2").html(modal_dev_exp);
}
// DEbolver expediente solicitado
function rec_exp(ci, num){
	if(num !=2){
		usuario.debolver_expediente(ci);
	}else{
		usuario.debolver_exp(ci);
	}
}
// subir expediente en pdf
function mos_modal_exp_pdf(ci){
	$("#exampleModal5").modal("show");
}
// mostrar modal editar ultima observacion observacion
function modal_edit_observacion(ci, n){
	let modal_edi_obs = "<h2 class='text-center' id='id_tit_mod1'>Editar observacion</h2>";
        modal_edi_obs += "<form action='>";
		modal_edi_obs += "<div class='mb-3' >";
		modal_edi_obs += "<label for='observacion_act'>Observacion</label>";
		modal_edi_obs += "<input class='form-control' type='text' id='observacion_act' name='observacion_act'>";
		modal_edi_obs += "</div>";
		modal_edi_obs += "<div class='modal-footer justify-content-center'>";
		if(n == 2){
			modal_edi_obs += "<button type='button' class='btn btn-success'  id='btn_recivir_expediente' name='btn_recivir_expediente' onclick='guardar_edit_obs("+ci+",2)'>Editar</button>";
		}else{
			modal_edi_obs += "<button type='button' class='btn btn-success'  id='btn_recivir_expediente' name='btn_recivir_expediente' onclick='guardar_edit_obs("+ci+",1)'>Editar</button>";
		}
		modal_edi_obs += "</div>";
		modal_edi_obs += "<div class='mb-2' id='error_soli_exp1'></div>";
		modal_edi_obs += "</form>";
	$("#modal2").html(modal_edi_obs);
	usuario.editar_observacion(ci);
	$("#exampleModal2").modal("show");
}
// guardar en la bbdd observacion editada
function guardar_edit_obs(ci, opc){
	let observacion_nv = $("#observacion_act").val();
	if(opc == 1){
		usuario.guardar_edit_obs(ci, observacion_nv, opc);
	}else if(opc == 2){
		usuario.guardar_edit_obs(ci, observacion_nv, opc);
	}
	

}
// debolver expedientes solicitados en opcion que muestra nada mas todos los expedientes solicitados
function entre_exp(ci){
	$("#exampleModal2").modal("show");
	let modal_dev_exp = "<h2 class='text-center' id='id_tit_mod1'>Recibir expediente</h2>";
        modal_dev_exp += "<form action='>";
		modal_dev_exp += "<div class='mb-3 cont_mod1_entregado' >";
		modal_dev_exp += "<div class='modal-footer justify-content-center'>";
		modal_dev_exp += "<button type='button' class='btn btn-success'  id='btn_recivir_expediente' name='btn_recivir_expediente' onclick='rec_exp("+ci+", 2)'>Si</button>";
		modal_dev_exp += "</div>";
		modal_dev_exp += "<div class='mb-2' id='error_soli_exp1'></div>";
		modal_dev_exp += "</form>";

	$("#modal2").html(modal_dev_exp);
}
// click nabvar opcion 1 personal
$("#opnb1").on("click", function(){
	usuario.mostrar_personal();
})
// boton de nabvar opcion 2 expedientes si devolver
$("#opnb2").on("click", function(){
	usuario.expedi_sn_devolver();
})
// boton de administrador 1 usuarios mostrar usuarios tabla
$("#opc_adm_1").on("click",()=>{
	usuario.usus_login();
});
// boton arriba de la tabla, agregar nuevo usuario
function modal_agreagar_usu(){
	let modal_agre_usu = "<h2 class='text-center' id='id_tit_mod1'>Crear usuario</h2>";
				modal_agre_usu += "<form action='>";
				modal_agre_usu += "<div class='mb-3 cont_mod1_entregado'>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label for='cedula' class='form-label'>Ingresa la cedula: </label>";
				modal_agre_usu += "<div class='d-flex flex-row'><select id='nac' name='nac' class='form-control'><option value='V'>V</option><option value='E'>E</option></select>";
				modal_agre_usu += "<input type='number' class='form-control ml-1 px-1' id='cedula' name='cedula' value='' onkeypress='cedulaBuscar(event, 1)'></div>";
				modal_agre_usu += "<div class='text-center' id='buscando_ci' name='buscando_ci'></div>";
				modal_agre_usu += "<input type='number' class='form-control ml-1 px-1 my-2' id='cedula2' name='cedula2' value='' readonly>";
				modal_agre_usu += "<label for='nombre2' class='form-label' id='lb_cedula2' style='display: none;'>Ingresa el nombre: </label>";
				modal_agre_usu += "<input type='text' class='form-control ml-1 px-1' id='nombre2' name='nombre2' value='' style='display: none;'>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'></div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label for='crear_nom' class='form-label' id='lb_crear_nom' name='lb_crear_nom'>Nombre: </label>";
				modal_agre_usu += "<input type='text' class='form-control ml-1 px-1' id='crear_nom' name='crear_nom' value=''>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label for='adm_correo' class='form-label'>Ingresa el correo: </label>";
				modal_agre_usu += "<input type='email' class='form-control ml-1 px-1' id='adm_correo' name='adm_correo' value=''>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
                modal_agre_usu += "<label for='crear_act' class='form-label'>Activo:</label>";
                modal_agre_usu += "<select class='form-control' id='act_act_adm' name='act_act_adm'></select>";
                modal_agre_usu += "</div>";
                modal_agre_usu += "<div class='' id='cont_h1_soli'>";
                modal_agre_usu += "<label for='crear_adm' class='form-label'>Administrador:</label>";
                modal_agre_usu += "<select class='form-control' id='adm_act_adm' name='adm_act_adm'></select>";
                modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label class='form_label' for='piso_usu'>Piso:</label>";
				modal_agre_usu += "<input type='number' class='form-control' id='piso_usu' name='piso_usu' maxlength='2'>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label class='form_label' for='unidad_usu'>Unidad:</label>";
				modal_agre_usu += "<select class='form-control' id='unidad_usu' name='unidad_usu'></select>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='modal-footer justify-content-center'>";
				modal_agre_usu += "<button type='button' class='btn btn-success'  id='btn_agregar_usu' name='btn_agregar_usu' onclick='agregar_nue_usu(1)'>Guardar1</button>";
				modal_agre_usu += "<button type='button' class='btn btn-success'  id='btn_agregar_usu2' name='btn_agregar_usu2' onclick='agregar_nue_usu(2)' style='display: none;'>Guardar2</button>";
				modal_agre_usu += "</div><div id='rr'></div>";
				modal_agre_usu += "</form>";
				$("#exampleModal2").modal("show");
				$("#modal2").html(modal_agre_usu);
				usuario.mostrar_opc_mod_act_desc();
				usuario.mostrar_opc_mod_per();
				usuario.mostra_opc_uni_tod();
}
// enviar formulario de modal agregar nuevo usuario
function agregar_nue_usu(num){
	if(num == 1){
		if($("#cedula2").val() != ""){
			if($("#crear_nom").val() != ""){
				if( $("#adm_correo").val() != ""){
					if(expresiones_re.email($("#adm_correo").val()) == true){
						if($("#piso_usu").val() != ""){
							usuario.agre_usu_adm($("#cedula2").val(), $("#crear_nom").val(),  $("#act_act_adm").val(), $("#adm_act_adm").val(), $("#adm_correo").val(), $("#piso_usu").val(), $("#unidad_usu").val());
						}else{
							$("#rr").html(accion.mensaje_alerta("danger", "Campo piso esta vacio", "view/images/icono_danger.png"));
						}
					}else{
						$("#rr").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
					}
				}else if($("#adm_correo").val() === ""){
					$("#rr").html(accion.mensaje_alerta("danger", "Campo correo vacio", "view/images/icono_danger.png"));
				}
			}else{
				$("#rr").html(accion.mensaje_alerta("danger", "Campo nombre vacio", "view/images/icono_danger.png"));
			}
		}else{
			$("#rr").html(accion.mensaje_alerta("danger", "Ingresa una cedula", "view/images/icono_danger.png"));
		}
	}else{
		// si cedula estavacia
		if($("#cedula2").val() != ""){
			if($("#nombre2").val() != ""){
				if( $("#adm_correo").val() != ""){
					if(expresiones_re.email($("#adm_correo").val()) == true){
						if($("#piso_usu").val() != ""){
							usuario.agre_usu_adm($("#cedula2").val(), $("#nombre2").val(),  $("#act_act_adm").val(), $("#adm_act_adm").val(), $("#adm_correo").val(), $("#piso_usu").val(), $("#unidad_usu").val(), 2);
						}else{
							$("#rr").html(accion.mensaje_alerta("danger", "Campo piso vacio", "view/images/icono_danger.png"));
						}
					}else{
						$("#rr").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
					}
				}else if($("#adm_correo").val() === ""){
					$("#rr").html(accion.mensaje_alerta("danger", "Campo correo vacio", "view/images/icono_danger.png"));
				}
			}else{
				$("#rr").html(accion.mensaje_alerta("danger", "Campo nombre vacio", "view/images/icono_danger.png"));
			}
		}else{
			$("#rr").html(accion.mensaje_alerta("danger", "Ingresa una cedula", "view/images/icono_danger.png"));
		}

	}
}

// buscar personal en vsaime al precionar enter en el campo cedula
function cedulaBuscar(event, num) {
	if (event.keyCode === 13) {
		$("#cedula").prop('disabled', true);
		$("#btn_agregar_usu").prop('disabled', true);
		const div = $('#buscando_ci');
		const h4 = $("<h4 class='my-1'>Buscando <i class='fas fa-spinner fa-spin' style='color: green;'></i></h4>");
		div.append(h4);
		if (num == 1) {
			usuario.buscar_usu_vsaime($("#cedula").val(), $("#cedula"), $("#btn_agregar_usu"), div, $("#nac").val());	
		}else{
			usuario.buscar_usu_vsaime($("#cedula").val(), $("#cedula"), $("#btn_agregar_usu"), div, $("#nac").val());	
		}
	}
}

// hacer click en un valor del select
function buscar_nombre(e){
	usuario.mostra_nombre(e);
}

// mostrar modal al hacer click en modificar usuario como administrador
function modificar_usu(id_usuario){
	$("#error_soli_exp3").html("");
	$("#cedula_esco").html("");
	$("#cedula").val("")
	usuario.usu_editar(id_usuario);
	usuario.mostrar_opc_mod_act_desc();
	usuario.mostrar_opc_mod_per();
	$("#exampleModal3").modal("show");
};

// funcion selecionar si esta activo no
function sel_act(){
	$("#act_act").val($("#act_act_adm").val());
}
function sel_adm(){
	$("#adm_act").val($("#adm_act_adm").val());
}
// agregar fecha
$("#btn_agregar_fe").on("click", function(){
	let fecha_poner = $("#fecha_r").val();
	$("#adm_fec").val(fecha_poner);
}); 
// btn de modal 3 actualizar datos de usuarios y modificar cedula
$("#btn_acttualizar_usu").on("click", function(){
	if($("#cedula").val() === ""){
		$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Ingrese una cedula", "view/images/icono_danger.png"));
		return;
	}
	if($("#cor_act_adm").val() != " "){
		if(expresiones_re.email($("#cor_act_adm").val()) == true){
			usuario.actualizar_usu_adm($("#cor_act_adm").val(), $("#id_usu").val(), $("#act_act").val(), $("#adm_act").val(), $("#cedula").val());

		}else{
			$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
		}
	}else{
		$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Campo correo esta vacio", "view/images/icono_danger.png"));
	}		
});

// btn2 de modal 3 actualizar datos del usuario y no midificara la cedula
$("#btn_acttualizar_usu2").on("click", function(){
	if($("#cor_act_adm").val() != " "){
		if(expresiones_re.email($("#cor_act_adm").val()) == true){
			usuario.actualizar_usu_adm($("#cor_act_adm").val(), $("#id_usu").val(), $("#act_act").val(), $("#adm_act").val(), null);
		}else{
			$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
		}
	}else{
		$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Campo correo esta vacio", "view/images/icono_danger.png"));
	}	

});
function mos_modal_contra(id_usuario){
	// alert(id_usuario);
	let i_u_asd = id_usuario;
	let modal_cam_contra = "<h4 class='text-center' id='id_tit_mod1'>¿Deseas cambiar la contraseña?</h4>"; 
	modal_cam_contra += "<form action='>";
	modal_cam_contra += "<div class='modal-footer justify-content-center'>";
	modal_cam_contra += "<button type='button' class='btn btn-success'  id='btn_act_cont' name='btn_act_cont' onclick='fun_com_con("+id_usuario+")'>Si</button>";
	modal_cam_contra += "</div><div id='rr'></div>";
	modal_cam_contra += "</form>";
	$("#modal2").html(modal_cam_contra);
	$("#id_usu_mo_con").val(id_usuario);
	$("#exampleModal2").modal("show");
}
// enviar fomulario en modal para comprobar y guardar contraseña
function fun_com_con(id_u_cc){
	usuario.cam_contra_adm(id_u_cc);
	$('#btn_act_cont').attr('disabled', 'disabled');
}    
// boton de administrador 2 transacciones usuarios mostrar  tabla transacciones usuarios
$("#opc_adm_2").on("click",()=>{
	usuario.usus_login_transacciones();
});
 //3ra opcion analistas y empleados como administrador 
$("#opc_adm_3").on("click", ()=>{
	usuario.mos_tabla_emp_ana();
});
// btn modificar analista y empleado modal
function modal_mod_ana_e(id){
	let modal_mod_ana_e = "<h2 class='text-center' id='id_tit_mod1'>Modificar analistas y empleados</h2>"; 
	modal_mod_ana_e += "<form action='>";
	modal_mod_ana_e += "<div class='mb-3 cont_mod1_entregado'>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='unidad_ana_e' class='form-label'>Unidad: </label>";
	modal_mod_ana_e += "<input type='text' class='form-control mb-2' id='unidad_ana_e' name='unidad_ana_e' disabled='true'>";
	modal_mod_ana_e += "<select class='form-control' id='id_unidad' value='hola' onclick='usuario.select_r_a_e(3, this.value)'>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='id_usu_mo_con' class='form-label'>Tipo: </label>";
	modal_mod_ana_e += "<input type='hidden' id='id_ana_emp' name='id_ana_emp' value='"+id+"'>";
	modal_mod_ana_e += "<input type='text' class=' mx-1 px-1' id='val_tipo' name='val_tipo' disabled='true'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='act_contra2' class='form-label'>Activo: </label>";
	modal_mod_ana_e += "<input type='text' class=' mx-1 px-1' id='val_activo' name='val_activo' disabled='true'>";
	modal_mod_ana_e += "<select class='from-control' id='id_activo' name='id_activo' onclick='usuario.select_r_a_e(2, this.value)'>";
	modal_mod_ana_e += "<option value='N'>N</option>";
	modal_mod_ana_e += "<option value='S'>S</option>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='modal-footer justify-content-center'>";
	modal_mod_ana_e += "<button type='button' class='btn btn-success'  id='btn_act_cont' name='btn_act_cont' onclick='usuario.obt_reg_r_a_e()'>Guardar cambios</button>";
	modal_mod_ana_e += "</div><div id='rr'></div>";
	modal_mod_ana_e += "</form>";
	$("#modal2").html(modal_mod_ana_e);
	usuario.agre_act_tip(id);
	$("#exampleModal2").modal("show");
};

// boton de mi perfil
$("#opnb_perfil").on("click", ()=>{
	usuario.mi_perfil();
});
// boton guardar datos del formulario mi perfil
function guardar_per(){
	let inp_nom = $("#nombre_per").val();
	if(inp_nom === ""){
		$("#resp_login").html(accion.mensaje_alerta("danger", "Campo nombre esta vacio", "view/images/icono_danger.png"));
	}else if(inp_nom.length <= 3){
		$("#resp_login").html(accion.mensaje_alerta("danger", "El campo nombre debe tener 4 caracteres como minimo", "view/images/icono_danger.png"));
	}else{
		usuario.actualizar_mi_perfil(inp_nom);
	}	
}

// btn cambiar contraseña por el usuario mi perfil
function cambiar_contra_per(){
	let modal_mod_ana_e = "<h2 class='text-center' id='id_tit_mod1'>Cambiar mi contraseña</h2>"; 
	modal_mod_ana_e += "<form action='>";
	modal_mod_ana_e += "<div class='mb-3 cont_mod1_entregado'>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_actual' class='form-label'>Ingresa tu contraseña: </label>";
	modal_mod_ana_e += "<input type='password' class='form-control mx-1 px-1' id='contra_actual' name='contra_actual' style='width: 100%;'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_n1' class='form-label'>Ingresa tu nueva contraseña: </label>";
	modal_mod_ana_e += "<input type='password' class='form-control mx-1 px-1' id='contra_n1' name='contra_n1' style='width: 100%;'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_n2' class='form-label'>Vuelve a ingresar tu nueva contraseña:  </label>";
	modal_mod_ana_e += "<input type='password' class='form-control mx-1 px-1' id='contra_n2' style='width: 100%;'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='modal-footer justify-content-center'>";
	modal_mod_ana_e += "<button type='button' class='btn btn-success'  id='btn_act_cont' name='btn_act_cont'  onclick='btn_act_con()'>Cambiar contraseña</button>";
	modal_mod_ana_e += "</div><div id='rr'></div>";
	modal_mod_ana_e += "</form>";
	$("#modal2").html(modal_mod_ana_e);
	$("#exampleModal2").modal("show");
}
// boton dentro dentro del modal cambiar contraseña cambiar contraseña
function btn_act_con(){
	let inp_cont_act = $("#contra_actual").val();
	let inp_cont_n1 = $("#contra_n1").val();
	let inp_cont_n2 = $("#contra_n2").val();
	if(inp_cont_act === "" || inp_cont_n1 === "" || inp_cont_n2 === ""){
		$("#rr").html(accion.mensaje_alerta("danger", "Algun campo esta vacio", "view/images/icono_danger.png"));
	}else if(inp_cont_n1.length < 5 || inp_cont_n2.length < 5){
		$("#rr").html(accion.mensaje_alerta("danger", "Los campos de contraseñas deben tener minimo 5 caracteres", "view/images/icono_danger.png"));
	}else if(inp_cont_n1 != inp_cont_n2){
		$("#rr").html(accion.mensaje_alerta("danger", "Las contraseñas no coinsiden", "view/images/icono_danger.png"));
	}else{
		usuario.camb_contra_perfil(inp_cont_act, inp_cont_n1, inp_cont_n2);
	}
}
// mostrar modal agregar emplado y analista
function mos_mod_agre_ana_emp(){
	let modal_mod_ana_e = "<h2 class='text-center' id='id_tit_mod1'>Agregar personal</h2>";
	modal_mod_ana_e += "<form action='>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='nombre' class='form-label'>Nombre </label>";
	modal_mod_ana_e += "<input type='text' class='form-control' placeholder='Ingresa el nombre' id='nombre' name='nombre'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='piso' class='form-label'>Piso </label>";
	modal_mod_ana_e += "<input type='number' class='form-control' placeholder='Ingresa el piso' id='piso' name='piso' maxlength='2'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='mb-3' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='id_unidad' class='form-label'>Unidad </label>";
	modal_mod_ana_e += "<select class='form-control' id='id_unidad' name='id_unidad'>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='modal-footer justify-content-center'>";
	modal_mod_ana_e += "<button type='button' class='btn btn-success'  id='btn_act_cont' name='btn_act_cont' onclick='btn_agre_ana()'>Guardar cambios</button>";
	modal_mod_ana_e += "</div><div id='rr'></div>";
	modal_mod_ana_e += "</form>";
	$("#modal2").html(modal_mod_ana_e);
	usuario.mostrar_unidad();
	$("#exampleModal2").modal("show");
}
// btn agregar un analista o empleado
function btn_agre_ana(){
	let nombre = $("#nombre").val();
	let piso = $("#piso").val();
	let unidad = $("#id_unidad").val();
	if(nombre === "" || piso === "" ){
		$("#rr").html(accion.mensaje_alerta("danger", "Algun campo esta vacio", "view/images/icono_danger.png"));
	}else{
		usuario.agre_ana_emp(nombre, piso, unidad);
	}
}

// btn navbar transacciones analistas y empleados
$("#opc_adm_4").on("click", ()=>{
	usuario.mos_tabla_tran_emp_ana();
});