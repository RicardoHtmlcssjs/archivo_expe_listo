class Usuarios{
	session(){
		$.ajax({
			url: "model/ajax/ajax_session.php",
			type: "POST",
			success: function(result){
				if(result == 1){
					usuario.mostrar_personal(result);
				}else if(result == 1.1){
					usuario.mostrar_personal(result);
					usuario.mostrar_usuario();
				}
			},
			error: function(error){
				console.log(error);
			}

		});
	}
	logout(){
		$.ajax({
			url: "model/ajax/logout_session.php",
			type: "POST",
			success: function(result){
				if(result = 1){
					window.location ="index.php";
				}

			},
			error: function(error){
				console.log(error);
			}

		});
	}
	login_usuario(){
		let usuario_l = $("#usuario").val();
		let contrasena = $("#contrasena").val(); 
		$.ajax({
			url: "model/ajax/ajax_login_user.php",
			type: "POST",
			data: {
				usuario_l: usuario_l, contrasena: contrasena
			},
			datatype: "json",
			success: function(result){
				if (result == 2) {
					$("#resp_login").html((accion.mensaje_alerta("danger", "Algun campo esta vacio", "view/images/icono_danger.png")));
				}else if(result == 1 || result == 1.1){
					usuario.mostrar_personal(result);
					usuario.mostrar_usuario();
					if(result == 1.1){
						usuario.mostrar_exp_mas_3_dias_soli();
					}
				}else if(result == 0){
					$("#resp_login").html((accion.mensaje_alerta("danger", "Usuario o contraseña son incorrecta", "view/images/icono_danger.png")));
				}else if(result == 3){
					$("#resp_login").html((accion.mensaje_alerta("danger", "El usuario no esta activo, comunicate con el administrador", "view/images/icono_danger.png")));
				}else{
					alert(result);
					$("#resp_login").html((accion.mensaje_alerta("danger", "Ha ocurrido un error", "view/images/icono_danger.png")));
				};

			},
			error: function(error){
				console.log(error);
			}

		});
	};
	// mostrar nombre usuario en el navbar al lado del btn cerrar secion
	mostrar_usuario(){ 
		$.ajax({
			url: "model/ajax/ajax_mostrar_usuario.php",
			type: "POST",
			success: function(result){
				$("#nom_usu_log_header").html("<i class='px-1 mr-4' id='nom_usu_log_header' name='nom_usu_log_header'><b>"+ result +"</b></i>");
			},
			error: function(error){
				console.log(error);
			}

		});
	};
	// mostrar expedientes solictados con mas de 3 dias de retraso 
	mostrar_exp_mas_3_dias_soli(){ 
		$.ajax({
			url: "model/ajax/ajax_mostrar_exp_mas_3_dias_soli.php",
			type: "POST",
			success: function(result){
				if(result > 0){
					$("#exampleModal4").modal("show");
					$("#cant_expe").append(`Hay ${result} expedientes que fueron solicitados y tienen mas de 3 dias de retraso`);
				}
			},
			error: function(error){
				console.log(error);
			}

		});
	};
	// mostrar pesonal luego de logearse y btn navbar personal
	mostrar_personal(num){
				$("#cuerpo").css("width", "80%");
				$("#navbar-le").removeClass("dsp_no");
				if(num == 1){
					$("#opc_admin").css("display","none");
				}
				$("#btn_cerrar_ss").removeClass("dps_none");
				$("#navbar-le").addClass("fondo_le");
				$("#opnb2").removeClass("opnb");
				$("#opnb_perfil").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_4").removeClass("opnb");
				$("#opnb1").addClass("opnb"); 

		$("#cuerpo").html(tabla_personal());
		$('#datatable_users').DataTable({
			"scrollY": "100vh",
    		"scrollCollapse": true,
			"ajax":{
				"url": "model/ajax/ajax_mostrar_usu.php",
				"type": "POST",
				"dataSrc":""
			},
			"columns":[
				{"data": null,"orderable": false, "searchable": true,
					render: function(data, type, row, meta) {
					return `<button type="button" class="btn btn-primary btn-sm py-0 px-1" onclick="edit_exp(${row.cedula})">E</button> ${row.cedula}`;
					}
				},
				{"data": "nombres",
				"searchable": true},
				{"data": "cargo", "searchable": true},
				{"data": "dstatus", "searchable": true},
				{"data": "cstatus", "searchable": false},
				{"data": null,
					className: 'text-center py-0 px-1',
					render: function(data, type, row, meta) {
					return `${row.nfil}-${row.ncol}`;
				}
				},
				{"data": "statra", "searchable": false},
				{"data": "destno"},
				{
					"data": null,
					className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        return `<img src='./view/images/icono_pdf.png' width='45px' style="cursor: pointer; border-radius: 5px;" class="btn_subir_exp" onclick="" id="btn_expe_pdf" name="btn_expe_pdf">`;
                    }
				},
				{
                    "data": null
                    ,
                    orderable: false,
                    className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        console.log()
                        
                        return "<button class='btn btn-primary btn-xs' onclick='hh("+ row.cedula +")'>S</button>";
                    }
                }
			],
			ordering: false,
			language: {
				lengthMenu: "Mostrar _MENU_ registros por pagina",
				zeroRecords: "Ningun usuario encontrado",
				info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
				infoEmpty: "Ningun usuario encontrado",
				infoFiltered: "(filtrados desde _MAX_ registros totales)",
				search: "Buscar...",
				loadingRecords: "Cargando...",
				paginate: {
					first: "Primero",
					last: "Ultimo",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});

		//Creamos una fila en el head de la tabla y lo clonamos para cada columna
		// $('#datatable_users thead tr').clone(true).appendTo( '#datatable_users thead' );

		// $('#datatable_users thead tr:eq(1) th').each( function (i) {
		// 	var title = $(this).text(); //es el nombre de la columna
		// 	$(this).html( '<input type="text" placeholder="Search...'+title+'" />' );
	 
		// 	$( 'input', this ).on( 'keyup change', function () {
		// 		if ( table.column(i).search() !== this.value ) {
		// 			table
		// 				.column(i)
		// 				.search( this.value )
		// 				.draw();
		// 		}
		// 	} );
		// });
	};
	// agregar expediente
	agre_expe(cedula, nombre, cargo, estatus, region, fila, columna){
		$.ajax({
			url: "model/ajax/ajax_agre_expe.php",
			type: "POST",
			data: {
				cedula, nombre, cargo, estatus, region, fila, columna
			},
			success: function(result){
				if(result == 0){
					$("#rr").html(accion.mensaje_alerta("danger", "La cedula ya existe", "view/images/icono_danger.png"));
				}else if(result == 1){
					usuario.mostrar_personal();
					$("#exampleModal2").modal("hide");
					var notification = alertify.notify('Expediente creado exitosamente', 'success', 5, function(){  console.log('dismissed'); });
				}else{
					$("#rr").html(accion.mensaje_alerta("danger", "Ha ocurrido un error", "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// obetener registro del usuario a editar
	obtener_reg_edi_exp(ci){
		$.ajax({
			url: "model/ajax/ajax_obtener_reg_edi_exp.php",
			type: "POST",
			data: {
				ci
			},
			success: function(result){
				let r = JSON.parse(result);
				$.each(r, function(index, element){
					$("#cedula2").val(element.cedula);
					$("#crear_nom").val(element.nombres);
					$("#cargo_val").val(element.desc_cargo);
					$("#fila").val(element.nfil);
					$("#columna").val(element.ncol);
					$("#status_val").val(element.dstatus);
					$("#region_val").val(element.nombreprpyac);
				});
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// opcion navbar 1 mostrar los expedientes sin devolber
	expedi_sn_devolver(){
		$.ajax({
			url: "model/ajax/ajax_expedientes_s_devol.php",
			type: "POST",
			success: function(result){
				$("#cuerpo").html(expedientes_sn_dev2());
				$("#cont_2_tbl").append(header_table_personal("Expedientes sin devolver","view/images/expedientes.png"));
				if(result == 0){
					$("#tbl_exp_sd").html("");
					$("#sin_fondo1").html(accion.mensaje_alerta("success", "Todos los expedientes han sido devueltos", "view/images/icono_bien.png"));
				}else{
					$("#tbody_r").append(result);
				}
				$("#opnb_perfil").removeClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_4").removeClass("opnb");
				$("#opnb2").addClass("opnb");
			},
			error: function(error){
				console.log(error);
			}
		});

	}
	// MOSTRAR STATUS EN EL SELECT DE AGREGAR UN EXPEDIENTE
	mostrar_estatus(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_estatus.php",
			type: "POST",
			success: function(result){
				$("#estatus").html(result);
				// alert(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar regiones en los select de agregar un expediente
	mostrar_region(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_region.php",
			type: "POST",
			success: function(result){
				$("#region").html(result);
				// alert(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar  cargos en el select de agregar expediente
	mostrar_cargo(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_cargo.php",
			type: "POST",
			success: function(result){
				$("#cargo").html(result);
				// alert(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// ver cargo actual de un personal
	cargo_act(id_cargo_act){
		$.ajax({
			url: "model/ajax/ajax_cargo_act.php",
			type: "POST",
			data: {
				id_cargo_act
			},
			success: function(result){
				$("#cargo_val").val(result);
				$("#buscar_cargo").prop('disabled', false);
				// alert(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// buscar cargo y mostrarlo en el select
	buscar_cargo(val_car_bus, num){
		$.ajax({
			url: "model/ajax/ajax_buscar_cargo.php",
			type: "POST",
			data: {
				val_car_bus: val_car_bus
			},
			success: function(result){
				if(num == 1){
					$("#cargo").html(result);
					$("#btn_agregar_usu").prop('disabled', false);
					$("#btn_agregar_usu2").prop('disabled', false);
					$("#buscar_cargo").prop('disabled', false);
					// $("#cargo").html(result);
					// alert(result);
				}else if(num == 2){
					$("#cargo").html(result);
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// 
	// guardar edicion de expediente
	guardar_edit_exp(cedula_vieja, cedula, nombre, cargo, status, region, fila ,columna){
		$.ajax({
			url: "model/ajax/ajax_guardar_edit_exp.php",
			type: "POST",
			data: {
				cedula_vieja, cedula, nombre, cargo, status, region, fila, columna
			},
			success: function(result){
				if(result == 0){
					$("#rr").html(accion.mensaje_alerta("danger", "La cedula ya exise", "view/images/icono_danger.png"));
				}else if(result == 1){
					var notification = alertify.notify('El expediente ha sido editado exitosamente', 'success', 5, function(){  console.log('dismissed'); });
					$("#exampleModal2").modal("hide");
					usuario.mostrar_personal();
				}else{
					$("#rr").html(accion.mensaje_alerta("danger", "Ha ocurrido un error", "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	expedientes_soli_personal(ci){
		$.ajax({
			url: "model/ajax/ajax_expedientes_solicitados.php",
			type: "POST",
			data: {
				ci: ci
			},
			success: function(result){
				if(result == 0){
					result = "<input type='hidden' value='"+ci+"' id='ci_per_solic_expe'>";
					result += accion.mensaje_alerta('danger', 'Personal sin solicitud de expediente', 'view/images/icono_danger.png');
					$('#exp_soli').html(accion.boton('Solicitar expediente','success', 'view/images/icono_expediente.png', "onclick='most_mod_agr("+ci+")'"));
					$('#exp_soli').append(result);
				}else if(result == 2){
					usuario.expe_espera_recivir(ci);
				}else{
					$('#exp_soli').html(accion.boton('Solicitar expediente','success', 'view/images/icono_expediente.png', "onclick='most_mod_agr("+ci+")'"));
					$('#exp_soli').append(result);
					usuario.expe_espera_recivir(ci);
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// pdf 
	expediente_pdf(){
		var parametros = new FormData($("#area-arrastrar")[0]);
		$.ajax({
		  type: 'POST',
		  url: 'model/ajax/ajax_subir_expediente.php',
		  contentType: false,
		  processData: false,
		  data:{parametros}, 
		  success:function(response) {
			alert(response);
			//   if(response == 'success') {
			//       console.log('Archivo subido');
			//       //Llamando mi funcion
			//       mensajeToast();
			//   } else {
			//       console.log('Error al subir Archivo');
			//   }
			//   //Limpio el input type File
			//   $('.file').val('');
		  },
		  error: function(error){
			alert(error);
		  }
	  });
	}
	// clase si falta por entregar el expediente borrar el boton de solicitar expediente
	expe_espera_recivir(ci){
		$.ajax({
			url: "model/ajax/ajax_borar_btn_espera_exp.php",
			type: "POST",
			data: {
				ci: ci
			},
			success: function(result){
				if(result == 0){
					$('#most_mod_agr').remove();

					// Crea un div con contenido
					let divConContenido = $(`<div style="display: flex;">${accion.boton('Devolver expediente','success', 'view/images/icono_expediente.png', "onclick='modal2_devol_exp_per("+ci+")'")}${accion.boton('Editar observacion','success', 'view/images/pen_edit.png', "onclick='modal_edit_observacion("+ci+")'")}</div>`);
					$("#exp_soli").prepend(divConContenido);
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	//entregar expediente solicitado
	debolver_exp(ci){
		$.ajax({
			url: "model/ajax/ajax_debolver_expe_solo.php",
			type: "POST",
			data: {
				ci: ci
			},
			success: function(result){
				// alert(result);
				// if(result == 1){
					$("#exampleModal2").modal("hide");
					// alert(result);
					usuario.expedi_sn_devolver();
				// }else{
				// 	alert("Ha ocurrido un error");
				// }
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// expedientes en pdf subir
	subir_expediente_pdf(){
		$.ajax({
			url: "model/ajax/ajax_subir_expediente.php",
			type: "POST",
			data: {
				sal: sal
			},
			success: function(result){
				alert(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrarobservacion en el campo observacion al resivir expediente
	editar_observacion(ci){
		$.ajax({
			url: "model/ajax/ajax_editar_observacion.php",
			type: "POST",
			data: {
				ci: ci
			},
			success: function(result){
				$("#observacion_act").val(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// guardar al editar observacion
	guardar_edit_obs(ci, observacion_nv, opc){
		$.ajax({
			url: "model/ajax/ajax_guardar_edit_obs.php",
			type: "POST",
			data: {
				ci: ci, observacion_nv: observacion_nv, opc: opc
			},
			success: function(result){
				$("#exampleModal2").modal("hide");
				if(opc == 1){
					usuario.expedientes_soli_personal(ci);
					var notification = alertify.notify('La observacion ha sido editada exitosamente', 'success', 5, function(){  console.log('dismissed'); });
				}else if(opc == 2){
					usuario.expedi_sn_devolver();
					var notification = alertify.notify('La observacion ha sido editada exitosamente', 'success', 5, function(){  console.log('dismissed'); });
				}
				
				
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrara todos las analistas
	selec_analis(val1, ci_per_s){
		$.ajax({
			url: "model/ajax/ajax_solitar_exp_ana.php",
			type: "POST",
			data: {
				val1: val1, ci_per_s: ci_per_s
			},
			success: function(result){
				$("#cont_h2_soli").html(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	};
	expediente_entregado(analis, ci_entregar_exp, observacion){
		$.ajax({
			url: "model/ajax/ajax_entregar_expe.php",
			type: "POST",
			data: {
				analis: analis, ci_entregar_exp: ci_entregar_exp, observacion: observacion
			},
			success: function(result){
				$("#exampleModal2").modal("hide");
				usuario.expedientes_soli_personal(ci_entregar_exp);
				var notification = alertify.notify('El expediente fue entregado exitosamente', 'success', 5, function(){  console.log('dismissed'); });
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	debolver_expediente(ci){
		$.ajax({
			url: "model/ajax/ajax_recivir_expe.php",
			type: "POST",
			data: {
				ci: ci
			},
			success: function(result){
				$("#exampleModal2").modal("hide");
				usuario.expedientes_soli_personal(ci);
				var notification = alertify.notify('El expediente fue debuelto', 'success', 5, function(){  console.log('dismissed'); });
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar tabla usuarios como administrador
	usus_login(){
				$("#opnb_perfil").removeClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opnb2").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_1").addClass("opnb");


		// $("#cuerpo").html("");
		$("#cuerpo").html(tabla_usuario_login());
		$("#cont_2_tbl").append(header_table_personal("Administrador - Usuarios","view/images/expedientes.png"));
		$('#table_reg').DataTable({
			"ajax":{
				"url": "model/ajax/ajax_mostrar_usu_login.php",
				"type": "POST",
				"dataSrc": ""
			},
			"columns":[
				{"data": "login"},
				{"data": "sysnombre"},
				{
                    "data": null,
                    orderable: false,
                    className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        return "<button class='btn btn-primary btn-xs' onclick='mos_modal_contra("+ row.idusuario +")'>Cambiar</button>";
                    }
                },
				{"data": "syscedula"},
                {"data": "correo"},
				{"data": "desc_activo"},
				{"data": "sysfechal"},
				{"data": "desc_permisos"},
				{
                    "data": null,
                    orderable: false,
                    className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        return "<button class='btn btn-primary btn-xs' onclick='modificar_usu("+ row.idusuario +")'>Editar</button>";
                    }
                }
			],
			ordering: true,
			language: {
				lengthMenu: "Mostrar _MENU_ registros por pagina",
				zeroRecords: "Ningun usuario encontrado",
				info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
				infoEmpty: "Ningun usuario encontrado",
				infoFiltered: "(filtrados desde _MAX_ registros totales)",
				search: "Buscar...",
				loadingRecords: "Cargando...",
				paginate: {
					first: "Primero",
					last: "Ultimo",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});
	}
	// mostrar opc de select activo
	mostrar_opc_mod_act_desc(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_activo.php",
			type: "POST",
			success: function(result){
				$("#act_act_adm").html(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mmostrar opc de select permisos
	mostrar_opc_mod_per(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_permisos.php",
			type: "POST",
			success: function(result){
				$("#adm_act_adm").html(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar opc de unidad a la que pertenese todas
	mostra_opc_uni_tod(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_unidad_usu_cre.php",
			type: "POST",
			success: function(result){
				$("#unidad_usu").html(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar en el modal 3
	usu_editar(id_usuario){
		$.ajax({
			url: "model/ajax/ajax_usu_editar.php",
			type: "POST",
			data: {
				id_usuario: id_usuario
			},
			success: function(result){
				let r = JSON.parse(result);
				$.each(r, function(index, element){
					$("#id_usu").val(element.idusuario);
					// $("#usu_act_adm").val(element.login);
					$("#cor_act_adm").val(element.correo);
					$("#nom_act_adm").val(element.sysnombre);
					if(element.syscedula == 0 || element.syscedula == null){
						$("#cont_ci_usu_edi").show();
						$("#cedula_esco").show();
						$("#btn_acttualizar_usu2").hide();
						$("#btn_acttualizar_usu").show();
					}else{
						$("#btn_acttualizar_usu").hide();
						$("#btn_acttualizar_usu2").show();
						$("#cont_ci_usu_edi").hide();
						$("#cedula_esco").hide();
					}
					$("#act_act").val(element.desc_activo);
					$("#adm_fec").val(element.sysfechal);
					$("#adm_act").val(element.desc_permisos);
				});
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// limpiar inp tablas usuarios administrador
	limpiar2(inp){
			$("#inp").val("");
			this.usus_login();
	}
	// actualizar datos del usuario como administrador
	actualizar_usu_adm(cor, id_u, act, adm, ci){
		$.ajax({
			url: "model/ajax/ajax_actualizar_usu_adm.php",
			type: "POST",
			data: {
				cor: cor, id_u: id_u, act: act, adm: adm, ci: ci
			},
			success: function(result){
				if(result == 0){
					$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "El correo ya exise", "view/images/icono_danger.png"));
				}else if(result == 2){
					$("#exampleModal3").modal("hide");
					$("#usu_act_adm").val("");
					$("#nom_act_adm").val("");
					usuario.usus_login();
					var notification = alertify.notify('Los datos del usuarios fueron actualizados exitosamente', 'success', 5, function(){  console.log('dismissed'); });
				}else if (result == 3){
					$("#error_soli_exp3").html(accion.mensaje_alerta("danger", "La cedula ya existe", "view/images/icono_danger.png"));
				}else{
					$("#error_soli_exp3").html(accion.mensaje_alerta("danger", result, "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// cambiar contraseña de usuario y verificar si se puede ingresar
	cam_contra_adm(id){
		$.ajax({
			url: "model/ajax/ajax_cam_contra_adm.php",
			type: "POST",
			data: {
				id: id
			},
			success: function(result){
				if(result == 2){
					$("#rr").html(accion.mensaje_alerta("danger", "El usuario debe tener un correo, para poder cambiar su contraseña", "view/images/icono_danger.png"));
				}else if(result == 1){
					var notification = alertify.notify('La contraseña fue cambiada exitosamente y fue enviada a el correo del usuario', 'success', 5, function(){  console.log('dismissed'); });
					$("#exampleModal2").modal("hide");
				}else if(result == 0){
					$("#rr").html(accion.mensaje_alerta("danger", "No se pudo enviar el correo pero la contraseña fue cambiada", "view/images/icono_danger.png"));
				}else if(result == 30){
					$("#rr").html(accion.mensaje_alerta("danger", "Debes cambiar la cedula del usuario ya que esta vacia o es 0", "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	usus_login_transacciones(){
				$("#cuerpo").html("");
				$("#opnb_perfil").removeClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opnb2").removeClass("opnb");
				$("#opc_adm_2").addClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_4").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#cuerpo").html(table_usu_trans());
				$("#cont_2_tbl").append(header_table_personal("Administrador - Transacciones usuarios","view/images/expedientes.png"));


		$('#table_reg').DataTable({
			"ajax":{
				"url": "model/ajax/ajax_usus_login_transacciones.php",
				"type": "POST",
				"dataSrc": ""
			},
			"columns":[
				{"data": "login"},
				{"data": "sysnombre"},
				{"data": "idd"},
				{"data": "fecha_tran"},
				{"data": "hora_tran"},
				{"data": "desc_tran"}
				
			],
			ordering: false,
			language: {
				lengthMenu: "Mostrar _MENU_ registros por pagina",
				zeroRecords: "Ningun usuario encontrado",
				info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
				infoEmpty: "Ningun usuario encontrado",
				infoFiltered: "(filtrados desde _MAX_ registros totales)",
				search: "Buscar...",
				loadingRecords: "Cargando...",
				paginate: {
					first: "Primero",
					last: "Ultimo",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});
	}
	// agregar un usuario como administrador
	agre_usu_adm(ci, nom, act, adm, corr, piso, unidad){
		$.ajax({
			url: "model/ajax/ajax_agre_usu_adm.php",
			type: "POST",
			data: {
				ci: ci, nom: nom, act: act, adm: adm, corr: corr, piso: piso, unidad: unidad
			},
			success: function(result){
				if(result == 3){
					$("#rr").html(accion.mensaje_alerta("danger", "La cedula ya existe", "view/images/icono_danger.png"));
				}else if(result == 2){
					$("#rr").html(accion.mensaje_alerta("danger", "Algun campo esta vacio", "view/images/icono_danger.png"));
				}else if(result == 1){
					$("#rr").html(accion.mensaje_alerta("success", "Usuario creado exitosamente y fue enviado un correo con su usuario y contraseña", "view/images/icono_bien.png"));
					$("#exampleModal2").modal("hide");
					var notification = alertify.notify('El usuario ha sido creado exitosamente y fue enviado un correo con su usuario y contraseña.', 'success', 5, function(){  console.log('dismissed'); });
					usuario.usus_login();

				}else if(result == 3){
					$("#rr").html(accion.mensaje_alerta("danger", "El usuario ya existe", "view/images/icono_danger.png"));
				}else if(result == 4){
					$("#rr").html(accion.mensaje_alerta("danger", "El correo ya existe", "view/images/icono_danger.png"));
				}
				else if(result == 0){
					$("#rr").html(accion.mensaje_alerta("danger", "No se pudo enviar la contraseña al correo, pero el usuario ha sido creado", "view/images/icono_danger.png"));
				}else{
					$("#rr").html(accion.mensaje_alerta("danger", "Ha ocurrido un error", "view/images/icono_danger.png"));
					alert(result);
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// buscar personal por cedula de vsaime
	buscar_usu_vsaime(ci, id_ci, id_btn_enviar, div, nac){
		$.ajax({
			url: "model/ajax/ajax_buscar_ci.php",
			type: "POST",
			data: {
				ci: ci, nac: nac
			},
			success: function(result){
				const objeto = JSON.parse(result);
				// alert(objeto[0]);
				if(objeto[0] == undefined){
					$("#nac").css("display", "none");
					$("#cedula").css("display", "none");
					$("#cedula_esco").css("display", "none");
					$("#btn_agr_ced_man1").css("display", "none");
					$("#btn_agr_ced_man2").css("display", "block");
					$("#btn_agregar_usu").css("display", "none");
					$("#btn_agregar_usu2").css("display", "block");
					$("#nombre2").css("display", "block");
					$("#cedula2").css("display", "block");
					$("#lb_cedula2").css("display", "block");
					$("#crear_nom").css("display", "none");
					$("#lb_crear_nom").css("display", "none");
					$("#buscando_ci").css("display", "none");
					$("#cedula2").val("");
					$("#cedula2").removeAttr("readonly");
					$("#crear_nom").val("");
				}else{
					$("#cedula_esco").html(result);
					id_ci.prop('disabled', false);
					id_btn_enviar.prop('disabled', false);
					div.html('');
					$("#cedula2").val(objeto[0]);
					$("#crear_nom").val(objeto[1]);
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar cedula de usuario a crear en el campo nombre
	mostra_nombre(ci){
			$.ajax({
				url: "model/ajax/ajax_mostrar_nombre.php",
				type: "POST",
				data: {
					ci: ci
				},
				success: function(result){
					// alert(result);
					$('#crear_nom').val(result);
				},
				error: function(error){
					console.log(error);
				}
			});
	}
	// mostrar tablas de empleados y analistas
	mos_tabla_emp_ana(){
				$("#opnb_perfil").removeClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opnb2").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#opc_adm_3").addClass("opnb");
				$("#opc_adm_4").removeClass("opnb");
				$("#cuerpo").html(expedientes_sn_dev());
				$("#cont_2_tbl").append(header_table_personal("Administrador - Empleados y analistas","view/images/expedientes.png"));
				$("#cont_2_tbl").append("<div><button class='btn btn-success' onClick='mos_mod_agre_ana_emp()'><i class='fa-solid fas fa-user-plus'></i></button></div>");

		$('#tbl_exp_sd').DataTable({
			"ajax":{
				"url": "model/ajax/ajax_mos_tabla_emp_ana.php",
				"type": "POST",
				"dataSrc": ""
			},
			"columns":[
				{"data": "snombres"},
				{"data": "micro"},
				{"data": "piso"},
				{"data": "unombre"},
				{"data": "tipo"},
				{"data": "activo"},
				{
                    "data": null,
                    orderable: false,
                    className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        return "<button class='btn btn-primary btn-xs' onclick='modal_mod_ana_e("+ row.idsolicita +")'>Editar</button>";
                    }
                }
				
			],
			ordering: true,
			language: {
				lengthMenu: "Mostrar _MENU_ registros por pagina",
				zeroRecords: "Ningun usuario encontrado",
				info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
				infoEmpty: "Ningun usuario encontrado",
				infoFiltered: "(filtrados desde _MAX_ registros totales)",
				search: "Buscar...",
				loadingRecords: "Cargando...",
				paginate: {
					first: "Primero",
					last: "Ultimo",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});
	}
	// mostrar datos de unidad a modal agregar personal analista o empleado
	mostrar_unidad(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_unidad.php",
			type: "POST",
			success: function(result){
				$("#id_unidad").html(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// agrega analista o empleado
	agre_ana_emp(nombre, piso, unidad){
		$.ajax({
			url: "model/ajax/ajax_agre_ana_emp.php",
			type: "POST",
			data:{
				nombre: nombre, piso: piso, unidad: unidad
			},
			success: function(result){
				$("#exampleModal2").modal("hide");
				usuario.mos_tabla_emp_ana();
				var notification = alertify.notify('El personal solicitante ha sido creado exitosamente.', 'success', 5, function(){  console.log('dismissed'); });
			},
			error: function(error){
				console.log(error);
			}
		});
	}

	// agregar datos a el modal de la tabla analista y empleados al modificar uno como administrador
	agre_act_tip(id){
		$.ajax({
			url: "model/ajax/ajax_agre_act_tip.php",
			type: "POST",
			data: {
				id: id
			},
			success: function(result){
				let r = JSON.parse(result);
				$.each(r, function(index, element){
					$("#unidad_ana_e").val(element.unombre);
					$("#val_tipo").val(element.tipo);
					$("#val_activo").val(element.activo);
					usuario.mostrar_unidad_s_empleado_a();
				});
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// option del select de unidad solicitante modal analistas y empleados
	mostrar_unidad_s_empleado_a(){
		$.ajax({
			url: "model/ajax/ajax_mostrar_unidad_s_empleado_a.php",
			type: "POST",
			success: function(result){

				$("#id_unidad").append(result);
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// select option en el modal analistas y empleados
	select_r_a_e(ns1, val){
		if(ns1 == 1){
			$("#val_tipo").val(val);
		}else if(ns1 == 2){
			$("#val_activo").val(val);
		}else if(ns1 == 3){
			$("#unidad_ana_e").val(val);
		}
	}
	// obtner valores al guardar registros
	obt_reg_r_a_e(){
		let unidad = $("#unidad_ana_e").val();
		let activo = $("#val_activo").val();
		let id_ae = $("#id_ana_emp").val();
		this.guardar_r_a_e(unidad, activo, id_ae);
	}
	// guardar cambio en el modal analista y empleados
	guardar_r_a_e(unidad, activo, id_ae){
		$.ajax({
			url: "model/ajax/ajax_guardar_r_a_e.php",
			type: "POST",
			data: {
				unidad: unidad, activo: activo, id_ae: id_ae
			},
			success: function(result){
				$("#exampleModal2").modal("hide");
				usuario.mos_tabla_emp_ana();
				var notification = alertify.notify('El personal solicitante ha sido actualizado exitosamente.', 'success', 5, function(){  console.log('dismissed'); });
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// mostrar mi perfil
	mi_perfil(){
		$.ajax({
			url: "model/ajax/ajax_perfil.php",
			type: "POST",
			success: function(result){
				$("#cuerpo").html("");
				$("#opnb_perfil").addClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opnb2").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opc_adm_4").removeClass("opnb");
				$("#cuerpo").html(result);
				$("#cont_2_tbl").append(header_table_personal("Mi perfil - usuario","view/images/expedientes.png"));
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// actualzar datos de mi perfil
	actualizar_mi_perfil(nom){
		$.ajax({
			url: "model/ajax/ajax_actualizar_perfil.php",
			type: "POST",
			data: {
				nom: nom
			},
			success: function(result){
				if(result == 1){
					$("#resp_login").html(accion.mensaje_alerta("success", "El Nombre fue actualizado exitosamente", "view/images/icono_bien.png"));
					usuario.mostrar_usuario();
				}else{
					$("#resp_login").html(accion.mensaje_alerta("danger", "Ha ocurrido un error ", "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// cambiar contraseña de mi perfil
	camb_contra_perfil(cont_v, cont_n1, cont_n2){
		$.ajax({
			url: "model/ajax/ajax_cam_cont_perfil.php",
			type: "POST",
			data: {
				cont_v: cont_v, cont_n1: cont_n1, cont_n2: cont_n2
			},
			success: function(result){
				if(result == 0){
					$("#rr").html(accion.mensaje_alerta("danger", "Contraseña incorrecta", "view/images/icono_danger.png"));
				}else if(result == 1){
					$("#exampleModal2").modal("hide");
					$("#modal2").html("");
					$("#resp_login").html(accion.mensaje_alerta("success", "Contraseña cambianda exitosamente", "view/images/icono_bien.png"));
				}else if(result == 2){
					$("#rr").html(accion.mensaje_alerta("danger", "La contraseña ya existe", "view/images/icono_danger.png"));
				}else{
					$("#rr").html(accion.mensaje_alerta("danger", "Ha ocurrido un error", "view/images/icono_danger.png"));
				}
			},
			error: function(error){
				console.log(error);
			}
		});
	}
	// tabla de transaccion analistas y empleados
	mos_tabla_tran_emp_ana(){
		// $.ajax({
		// 	url: "model/ajax/ajax_mos_tabla_tran_emp_ana.php",
		// 	type: "POST",
		// 	success: function(result){
		// 		$("#cuerpo").html("");
				$("#opc_adm_4").addClass("opnb");
				$("#opnb1").removeClass("opnb");
				$("#opnb2").removeClass("opnb");
				$("#opc_adm_2").removeClass("opnb");
				$("#opc_adm_1").removeClass("opnb");
				$("#opc_adm_3").removeClass("opnb");
				$("#opnb_perfil").removeClass("opnb");
				$("#cuerpo").html(table_ana_emp_trans());
				$("#cont_2_tbl").append(header_table_personal("Administrador - Transacciones Analistas y empleados","view/images/expedientes.png"));
				
		$('#table_reg').DataTable({
			"ajax":{
				"url": "model/ajax/ajax_mos_tabla_tran_emp_ana.php",
				"type": "POST",
				"dataSrc": ""
			},
			"columns":[
				{"data": "snombres"},
				{"data": "login"},
				{"data": "fecha_tran"},
				{"data": "hora_tran"},
				{"data": "desc_tran"}
				
			],
			ordering: false,
			language: {
				lengthMenu: "Mostrar _MENU_ registros por pagina",
				zeroRecords: "Ningun usuario encontrado",
				info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
				infoEmpty: "Ningun usuario encontrado",
				infoFiltered: "(filtrados desde _MAX_ registros totales)",
				search: "Buscar...",
				loadingRecords: "Cargando...",
				paginate: {
					first: "Primero",
					last: "Ultimo",
					next: "Siguiente",
					previous: "Anterior"
				}
			}
		});
	}
}
let usuario = new Usuarios();
usuario.session();