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
    $('.block__btn').on('click', function(){
        var ourInput = $(this).prev('.block__input')
        if ($(this).hasClass('is-active')) {
        $(this).removeClass('is-active')
        ourInput.attr('readonly', true)
        $(this).text('Edit input')
    } else {
        $(this).addClass('is-active')
        $(this).text('Save this')
        ourInput.removeAttr('readonly').focus()
        ourInput.setSelectionRange(ourInput.val().length, ourInput.val().length);
    }
    })
})
