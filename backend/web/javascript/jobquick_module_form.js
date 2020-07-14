$('.request-only-checkbox').change(function () {
    var gotChecked = $(this).prop('checked');
    var companyScaleId = $(this).data('scale-id');
    $('div[data-scale-id="' + companyScaleId + '"]').find('input[type=text]').prop('disabled', gotChecked);
});