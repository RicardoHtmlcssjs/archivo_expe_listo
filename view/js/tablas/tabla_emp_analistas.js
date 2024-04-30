function expedientes_sn_dev(){
    let tab_exp_sin_dev = "<div class='P-3' style='width: 100%;'>";
        tab_exp_sin_dev += "<div class='col-sm-12 col-md-12 col-lg-12 col-xl-12 px-0 cont_col_tab1' style='padding: 0px;'>";
            tab_exp_sin_dev += "<div id='cont_2_tbl'>";
            tab_exp_sin_dev += "</div>";
            tab_exp_sin_dev += "<table id='tbl_exp_sd' style='width: 100%;'>";
                tab_exp_sin_dev += "<thead class='thead_tab1'";
                    tab_exp_sin_dev += "<tr>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Cedula</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Nombre</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Micro</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Piso</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Unidad</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Tipo</th>";
                        tab_exp_sin_dev +="<th class='text-center tit_c_tab1'>Activo</th>";
                        tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Accion</th>";
                        // tab_exp_sin_dev += "<th class='text-center tit_c_tab1'>Entregado por</th>";
                    tab_exp_sin_dev += "</tr>";
                tab_exp_sin_dev += "</thead>";
                tab_exp_sin_dev += "<tbody class='tbody_tab1' id='tbody_r'>";
                tab_exp_sin_dev += "</tbody>";
            tab_exp_sin_dev += "</table>";
    tab_exp_sin_dev += "</div>";
    tab_exp_sin_dev += "<div id='sin_fondo1'>";
    tab_exp_sin_dev += "</div>";
    tab_exp_sin_dev += "<div id='exp_soli'></div>";
    return tab_exp_sin_dev;
}