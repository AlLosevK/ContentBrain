(document).ready(function () {
    $('.approvecontent2__button-item').on('click', function () {
        $('.approvecontent2__button-item').removeClass('approvecontent2__button');
        $(this).addClass('approvecontent2__button-active');

        if ($('.approvecontent2__button-item').hasClass("approvecontent2__button-active")) {
            $('.resources').fadeIn(10);
        }
    })
})