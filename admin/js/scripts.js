$(document).ready(function(){
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#data').mask('00/00/0000');

    $('#inputGroupFile').on('change',function(e){
        var fileName = e.target.files[0].name;
        $(this).next('.custom-file-label').html(fileName);
    });

    $('#defaultCheck1').on('change', function(e) {
        $('#defaultIntro').toggleClass('d-none');
    });

    $("#sortable").sortable({
        items : ".row",
        update: function () {
            const id = $(this).data('destaque');
            const data = $(this).sortable('toArray', {
                attribute: 'data-id'
            });

            $.ajax({
                data: {
                    data: JSON.stringify(data),
                    id: id,
                },
                type: 'POST',
                url: '/admin/destaques/order.php',
                success: function (data) {
                    // console.log(data);
                }
            });
        }
    });

    $('#basicDatatable').DataTable({
        "info": false,
        "filter": true,
        "pageLength": 20,
        "pagingType": "numbers",
        "lengthChange": false,
        "columns": [
            null,
            {
                "orderable": false
            }
        ],
        "language": { search: "Procurar: " }
    });

    
    const listaCategorias = $.ajax({
        method: 'POST',
        url: '/admin/categorias/get.php',
        dataType: "json",
    });
    
    let tagCategoria = document.querySelector('#tagCategoria');

    listaCategorias.success((result) => {
        new Tagify(tagCategoria, {
            whitelist: result,
            duplicates: false,
            dropdown: {
                maxItems: 10,
                closeOnSelect: true,
            },
            enforceWhitelist: true
        });
    });

    const listaTemas = $.ajax({
        method: 'POST',
        url: '/admin/temas/get.php',
        dataType: "json",
    });

    let tagTema = document.querySelector('#tagTema');

    listaTemas.success((result) => {
        new Tagify(tagTema, {
            whitelist: result,
            duplicates: false,
            dropdown: {
                maxItems: 10,
                closeOnSelect: true,
            },
            enforceWhitelist: true
        });
    });

});
