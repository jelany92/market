$('#presentation-modal').on('show.bs.modal', function (e) {
    var functionId = $(e.relatedTarget).data('function-id');
    var modal = $(e.target);
    var container  = modal.find('.modal-body');
    var divToView = container.find('#modal-function-' + functionId);
    showSpinnerHideRest(container);

    if(divToView.length == 0)
    {
        $.ajax({
            method: 'POST',
            url: ajaxLoadPresentationUrl,
            data: { id: functionId },
            dataType: 'html',
        }).done(function (response) {
            container.append(response);
            divToView = container.find('#modal-function-' + functionId);
            showCarouselHideSpinner(functionId, container, false);
        }).fail(function () {
            container.find('.modal-loading-spinner').fadeOut('fast', function () {
                container.find('.alert-danger').fadeIn('fast');
            });
        });
    }
    else
    {
        showCarouselHideSpinner(functionId, container, true);
    }
});

function showCarouselHideSpinner(functionId, container, jumpToFirstSlide) {
    var carouselContainer = $('#modal-function-' + functionId);
    carouselContainer.find('div[id^="carousel-"],div[id*=" carousel-"]').carousel(0);
    container.find('#modal-spinner-div').hide();
    carouselContainer.show();

}

function showSpinnerHideRest(container) {
    container.find('.modal-contained-div').hide();
    container.find('.alert-danger').hide();
    container.find('.modal-loading-spinner').show();
    container.find('#modal-spinner-div').show();
}