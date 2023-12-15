function table_usu_trans(){
    let tab_usu_trans = "<div class='p-3' style='width: 100%;'>";
        tab_usu_trans += "<div class='col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0 cont_col_tab1' style='padding: 0px;'>";
        tab_usu_trans += "<div id='cont_2_tbl'>";
            tab_usu_trans += "</div>";
                tab_usu_trans += "<table style='width: 100%;' id='table_reg'>";
                    tab_usu_trans += "<thead class='thead_tab1'";
                        tab_usu_trans += "<tr>";
                            tab_usu_trans += "<th class='text-center tit_c_tab1'>Usuario</th>";
                         tab_usu_trans += "<th class='text-center tit_c_tab1'>Nombres</th>";
                            tab_usu_trans += "<th class='text-center tit_c_tab1'>Administrador</th>";
                            tab_usu_trans += "<th class='text-center tit_c_tab1'>Fecha</th>";
                            tab_usu_trans += "<th class='text-center tit_c_tab1'>Hora</th>";
                            tab_usu_trans += "<th class='text-center tit_c_tab1'>Acciòn</th>";
                        tab_usu_trans += "</tr>";                        
                    tab_usu_trans += "</thead>";
                    tab_usu_trans += "<tbody class='tbody_tab1' id='tbody_r'>";
                    tab_usu_trans += "</tbody>";
                tab_usu_trans += "</table>";
            tab_usu_trans += "</div>";
    tab_usu_trans += "<div id='sin_fondo1'>";
    tab_usu_trans += "</div>";
    tab_usu_trans += "<div id='exp_soli'></div>";
    tab_usu_trans += "</div>";

    return tab_usu_trans;
};