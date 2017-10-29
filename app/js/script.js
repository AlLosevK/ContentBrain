$(document).ready(function () {
    $('.approvecontent2__button-item').on('click', function () {
        $('.approvecontent2__button-item').removeClass('approvecontent2__button-active');
        $(this).addClass('approvecontent2__button-active');

        if ($('.js-show__button-things').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-thing').fadeIn(10);
        }

        if ($('.js-show__button-how').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-how').fadeIn();
        }

        if ($('.js-show__button-introdution').hasClass("approvecontent2__button-active")) {
            $('.resources-item').fadeOut(0);
            $('.js-show-block-introdution').fadeIn();
        }
    })
})