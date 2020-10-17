$(document).ready(function(){
    $('#cpf').mask('000.000.000-00', {reverse: true});
    $('#data').mask('00/00/0000');

    $('.owl-carousel').owlCarousel({
        margin: 15,
        nav: false,
        loop: false,
        autoWidth: false,
        items: 3,
        responsive:{
            0: {
                items: 1.2,
                loop: true,
            },
            768: {
                items: 2,
                loop: true,
            },
            992: {
                items: 3,
            }
        },
    });
});