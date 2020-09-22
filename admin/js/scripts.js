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
});
