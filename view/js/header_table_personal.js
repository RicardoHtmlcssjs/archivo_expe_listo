function header_table_personal(tit_f, img_logo_ht){
	let header_tab_perso = "<div class='px-3 py-1 cont_tit_tabla bg-success mb-1'>";
            header_tab_perso += "<img src='"+img_logo_ht+"' class='logo_titulo mx-1'><h5 class='text_titulo_tat'>"+tit_f+"</h5>";
        header_tab_perso += "</div>";
       return header_tab_perso;
}