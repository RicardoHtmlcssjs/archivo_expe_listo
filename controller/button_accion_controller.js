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
	usuario.selec_analis($("#solicitante").val(), ci_per_s);
	usuario.entregado_por_exp();
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
// btn guardar solicitud de expediente
$("#agre_solicitar_exp").on("click", function(){
	if($("#analista").val() == null){
		$("#error_soli_exp1").html(accion.mensaje_alerta("danger", "Selecciona un solicitante", "view/images/icono_danger.png"));
	}else{
		$("#error_soli_exp1").html("");
		$("#exampleModal1").modal("hide");
		let ci_entregar_exp = $("#ci_per_agre_exp").val();
		let analis = $("#analista").val();
		let p_entregado = $("#entregado_por").val();
		usuario.expediente_entregado(analis, p_entregado, ci_entregar_exp);
		//$("#ci_per_agre_exp").val("");
		//$("#ci_per_agre_exp").val("");
		$("#solicitante").val("");

	};
});
// modal de devovelver expedientes solicitados - persona
function modal2_devol_exp_per(ci, opc){
	$("#exampleModal2").modal("show");
	let modal_dev_exp = "<h2 class='text-center' id='id_tit_mod1'>Recivir expediente</h2>";
        modal_dev_exp += "<form action='>";
		modal_dev_exp += "<div class='mb-3 cont_mod1_entregado' >";
        modal_dev_exp += "<label for='entregado_por1' class='form-label'>Recivido por: </label>";
        modal_dev_exp += "<div class='cont_h2_entre' id='cont_recivido_por_res'></div>";
        modal_dev_exp += "</div>";
		modal_dev_exp += "<div class='modal-footer justify-content-center'>";
		modal_dev_exp += "<button type='button' class='btn btn-success'  id='btn_recivir_expediente' name='agregar_r_l'>Guardar</button>";
		modal_dev_exp += "</div>";
		modal_dev_exp += "<div class='mb-2' id='error_soli_exp1'></div>";
		modal_dev_exp += "</form>";

	$("#modal2").html(modal_dev_exp);
	let ci_entregar_exp = $("#ci_per_solic_expe").val();
	usuario.recivido_por();
	$("#btn_recivir_expediente").on("click", function(){
		let per_recivido = $("#entregado_por").val();
		usuario.entregar_exdpediente(ci, per_recivido, opc);
	});
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
				modal_agre_usu += "<label for='crear_usu' class='form-label'>Ingresa el usuario: </label>";
				modal_agre_usu += "<input type='text' class='inp_bus_soli_mod1 ml-1 px-1' id='crear_usu' name='crear_usu' value=''>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label for='crear_nom' class='form-label'>Ingresa el nombre: </label>";
				modal_agre_usu += "<input type='text' class='inp_bus_soli_mod1 ml-1 px-1' id='crear_nom' name='crear_nom' value=''>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
				modal_agre_usu += "<label for='adm_correo' class='form-label'>Ingresa el correo: </label>";
				modal_agre_usu += "<input type='email' class='inp_bus_soli_mod1 ml-1 px-1' id='adm_correo' name='adm_correo' value=''>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='' id='cont_h1_soli'>";
                modal_agre_usu += "<label for='crear_act' class='form-label'>Activo:</label>";
                modal_agre_usu += "<select id='act_act_adm' name='act_act_adm'></select>";
                modal_agre_usu += "</div>";
                modal_agre_usu += "<div class='' id='cont_h1_soli'>";
                modal_agre_usu += "<label for='crear_adm' class='form-label'>Administrador:</label>";
                modal_agre_usu += "<select id='adm_act_adm' name='adm_act_adm'></select>";
                modal_agre_usu += "</div>";
				modal_agre_usu += "</div>";
				modal_agre_usu += "<div class='modal-footer justify-content-center'>";
				modal_agre_usu += "<button type='button' class='btn btn-success'  id='btn_agregar_usu' name='btn_agregar_usu' onclick='agregar_nue_usu()'>Guardar</button>";
				modal_agre_usu += "</div><div id='rr'></div>";
				modal_agre_usu += "</form>";
				$("#exampleModal2").modal("show");
				$("#modal2").html(modal_agre_usu);
				usuario.mostrar_opc_mod_act_desc();
				usuario.mostrar_opc_mod_per();
}
// enviar formulario de modal agregar nuevo usuario
function agregar_nue_usu(){
	if( $("#adm_correo").val() != ""){
		if(expresiones_re.email($("#adm_correo").val()) == true){
			usuario.agre_usu_adm($("#crear_usu").val(), $("#crear_nom").val(),  $("#act_act_adm").val(), $("#adm_act_adm").val(), $("#adm_correo").val());
		}else{
			$("#rr").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
		}
	}else if($("#adm_correo").val() === ""){
		$("#rr").html(accion.mensaje_alerta("danger", "Campo correo vacio", "view/images/icono_danger.png"));
	}else{
		usuario.agre_usu_adm($("#crear_usu").val(), $("#crear_nom").val(), $("#act_act_adm").val(), $("#adm_act_adm").val(), $("#adm_correo").val());
	}
}
// mostrar modal al hacer click en modificar usuario como administrador
function modificar_usu(id_usuario){
	$("#error_soli_exp3").html("");
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
// btn de modal 3 actualizar datos de usuarios
$("#btn_acttualizar_usu").on("click", function(){

	if($("#usu_act_adm").val() === ""){
		$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Campo usuario vacio", "view/images/icono_danger.png"));
	}else if($("#nom_act_adm").val() === ""){
		$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Campo nombre vacio", "view/images/icono_danger.png"));
	}else if($("#cor_act_adm").val() != " "){
		if(expresiones_re.email($("#cor_act_adm").val()) == true){
			usuario.actualizar_usu_adm($("#cor_act_adm").val(), $("#id_usu").val(), $("#usu_act_adm").val(), $("#nom_act_adm").val(), $("#act_act").val(), $("#adm_act").val());
		}else{
			$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "Correo invalido", "view/images/icono_danger.png"));
		}
	}else{
		usuario.actualizar_usu_adm($("#cor_act_adm").val(), $("#id_usu").val(), $("#usu_act_adm").val(), $("#nom_act_adm").val(), $("#act_act").val(), $("#adm_act").val());
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
	modal_mod_ana_e += "<div class='mb-1' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='unidad_ana_e' class='form-label'>Unidad: </label>";
	modal_mod_ana_e += "<input type='text' class='inp_bus_soli_mod1 mx-1 px-1' id='unidad_ana_e' name='unidad_ana_e' disabled='true'>";
	modal_mod_ana_e += "<select id='id_unidad' value='hola' onclick='usuario.select_r_a_e(3, this.value)'>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='id_usu_mo_con' class='form-label'>Tipo: </label>";
	modal_mod_ana_e += "<input type='hidden' id='id_ana_emp' name='id_ana_emp' value='"+id+"'>";
	modal_mod_ana_e += "<input type='text' class='inp_bus_soli_mod1 mx-1 px-1' id='val_tipo' name='val_tipo' disabled='true'>";
	modal_mod_ana_e += "<select id='id_tipo' value='hola' onclick='usuario.select_r_a_e(1, this.value)'>";
	modal_mod_ana_e += "<option value='E'>E</option>";
	modal_mod_ana_e += "<option value='S'>S</option>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='act_contra2' class='form-label'>Activo: </label>";
	modal_mod_ana_e += "<input type='text' class='inp_bus_soli_mod1 mx-1 px-1' id='val_activo' name='val_activo' disabled='true'>";
	modal_mod_ana_e += "<select id='id_activo' name='id_activo' onclick='usuario.select_r_a_e(2, this.value)'>";
	modal_mod_ana_e += "<option value='N'>N</option>";
	modal_mod_ana_e += "<option value='S'>S</option>";
	modal_mod_ana_e += "</select>";
	modal_mod_ana_e += "</div>";
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
	let inp_usu = $("#usuario_per").val();
	let inp_nom = $("#nombre_per").val();
	if(inp_usu === "" || inp_nom === ""){
		$("#resp_login").html(accion.mensaje_alerta("danger", "Algun campo esta vacio", "view/images/icono_danger.png"));
	}else if(inp_usu.length < 8){
		$("#resp_login").html(accion.mensaje_alerta("danger", "El campo usuario debe tener 8 caracteres como minimo", "view/images/icono_danger.png"));
	}else if(inp_nom.length < 8){
		$("#resp_login").html(accion.mensaje_alerta("danger", "El campo nombre debe tener 8 caracteres como minimo", "view/images/icono_danger.png"));
	}else{
		usuario.actualizar_mi_perfil(inp_usu, inp_nom);
	}	
}

// btn cambiar contraseña por el usuario mi perfil
function cambiar_contra_per(){
	let modal_mod_ana_e = "<h2 class='text-center' id='id_tit_mod1'>Cambiar mi contraseña</h2>"; 
	modal_mod_ana_e += "<form action='>";
	modal_mod_ana_e += "<div class='mb-3 cont_mod1_entregado'>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_actual' class='form-label'>Ingresa tu contraseña: </label>";
	modal_mod_ana_e += "<input type='password' class='inp_bus_soli_mod1 mx-1 px-1' id='contra_actual' name='contra_actual' style='width: 100%;'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_n1' class='form-label'>Ingresa tu nueva contraseña: </label>";
	modal_mod_ana_e += "<input type='password' class='inp_bus_soli_mod1 mx-1 px-1' id='contra_n1' name='contra_n1' style='width: 100%;'>";
	modal_mod_ana_e += "</div>";
	modal_mod_ana_e += "<div class='' id='cont_h1_soli'>";
	modal_mod_ana_e += "<label for='contra_n2' class='form-label'>Vuelve a ingresar tu nueva contraseña:  </label>";
	modal_mod_ana_e += "<input type='password' class='inp_bus_soli_mod1 mx-1 px-1' id='contra_n2' style='width: 100%;'>";
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
	}else if(inp_cont_n1.length < 8 || inp_cont_n2.length < 8){
		$("#rr").html(accion.mensaje_alerta("danger", "Los campos de contraseñas deben tener minimo 8 caracteres", "view/images/icono_danger.png"));
	}else if(inp_cont_n1 != inp_cont_n2){
		$("#rr").html(accion.mensaje_alerta("danger", "Las contraseñas no coinsiden", "view/images/icono_danger.png"));
	}else{
		usuario.camb_contra_perfil(inp_cont_act, inp_cont_n1, inp_cont_n2);
	}	
} 
// btn navbar transacciones analistas y empleados 
$("#opc_adm_4").on("click", ()=>{
	usuario.mos_tabla_tran_emp_ana();
});