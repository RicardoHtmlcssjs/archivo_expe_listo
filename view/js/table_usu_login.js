function tabla_usuario_login(){
	let tab_perso = "<div class='p-3' style='width: 100%;'>";
        tab_perso += "<div class='col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0 cont_col_tab1' style='padding: 0px;'>";
            tab_perso += "<div id='cont_2_tbl'>";
            tab_perso += "</div>";
            tab_perso += "<div><button class='btn btn-success' id='agregar_usu' name='agregar_usu' onclick='modal_agreagar_usu()'><i class='fa-solid fas fa-user-plus'></i></button>";
            tab_perso += "</div>"; 
            tab_perso += "<table style='width: 100%;' id='table_reg'>";
                tab_perso += "<thead class='thead_tab1'";
                    tab_perso += "<tr>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Usuario</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Nombres</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Contraseña</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Correo</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Activo</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Fecha de registro</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Administrador</th>";
                        tab_perso += "<th class='text-center tit_c_tab1'>Accion</th>";
                    tab_perso += "</tr>";
                tab_perso += "</thead>";
                tab_perso += "<tbody class='tbody_tab1' id='tbody_r'>";
                tab_perso += "</tbody>";
            tab_perso += "</table>";
    tab_perso += "</div>";
    tab_perso += "<div id='sin_fondo1'>";
    tab_perso += "</div>";
    tab_perso += "<div id='exp_soli'></div>";
    tab_perso += "</div>";

    return tab_perso;
}