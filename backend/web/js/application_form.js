jQuery(document).ready(function($) {
    $(".question-form").submit(function(event) {
        event.preventDefault(); // stopping submitting
        var data = $(this).serializeArray();
        var url = $(this).attr('action');
        alert(url);
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: data
        })
            .done(function(response) {
                if (response.data.success == true) {
                    alert("Wow you commented");
                }
            })
            .fail(function() {
                console.log("error");
            });

    });
});

$('body .container').on('afterInit', 'form.applicationForm', function (event)
{
    alert('test');
    var formsUninitialized = $('form.applicationForm, form.ajaxDeleteForm').filter(function ()
    {
        return $(this).data('yiiActiveForm') === undefined;
    });

    if (formsUninitialized.length === 0)
    {
        //Fail save to kill off submit event if for whatever reason none of the other listeners catches the event
        $('body .container').on('submit', 'form.applicationForm, form.ajaxDeleteForm', function (event)
        {
            event.preventDefault();
            return false;
        });

        $('button.ajaxButton:not(.cantAddMore)').prop('disabled', false);
    }
});