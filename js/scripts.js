$(document).ready(function(){
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#data').mask('00/00/0000');

    $('#assistir-video').click(function() {

        var $nomeUsuario = $('#usuario').text();
        var $nomeVideo = $(this).data('video');
        var $nomeEmpresa = $(this).data('empresa');

        dataLayer.push({
            'usuario': $nomeUsuario,
            'video': $nomeVideo,
            'empresa': $nomeEmpresa
        });
    });

    $('#filtro').on('change', function() {
        if (this.value) {
            window.location.href = '/?categoria='+ this.value;
        }
    });
});