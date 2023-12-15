function mostrar_tabla(){
	$('#datatable_users').DataTable({
			"ajax":{
				"url": "datatable.php",
				"type": "POST",
				"dataSrc":""
			},
			"columns":[
				{"data": "id_controle"},
				{"data": "cedula"},
				{"data": "fdevolucion"},
				{
                    "data": null,
                    orderable: false,
                    className: 'text-center py-0 px-1',
                    render: function(data, type, row, meta) {
                        console.log()
                        // return '<a class="me-2 btn btn-sm rounded-0 py-0 edit_data btn-primary" href="javascript:void(0)" data-id="' + (row.id) + '">Editar</a><a class="btn btn-sm rounded-0 py-0 delete_data btn-danger" href="javascript:void(0)" data-id="' + (row.id) + '">Eliminar</a>';
                        return "<button class='btn btn-primary' onclick='alert("+ row.id_controle +")'>Editar</button><button class='btn btn-danger' onclick='alert("+ row.id_controle +")'>Eliminar</button>";
                    }
                }
			],
			// cuantas mostrar por paginas
			// "pageLength": 2
			// que la tabla pueda ser destruible
			// "destroy": true
			// dar clase de bootstrap de datatabletargets: [0, 1, 2] }],
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
};