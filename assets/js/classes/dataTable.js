export const dataTable = (url, table)=>{
    $(document).ready( ()=> {
        if($(table)){
            
            $(table).DataTable({
                layout: {
                    topStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5']
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": -1 } // O índice -1 refere-se à última coluna
                ],
                serverSide: true,
                processing:true,
                ajax:{
                    url,
                    data:{
                        "_csrf":$("#_csrf").val(),
                        'fetchApi':true,
                    }
                },
                language:{
                    url:"https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                },
                
            });
        }
    });
}