jQuery(document).ready(function ($)
{
    $(".answer-form").submit(function (event)
    {
        event.preventDefault(); // stopping submitting
        var data = $(this).serializeArray();
        var url  = $(this).attr('action');
        $.ajax({
            url     : url,
            type    : 'post',
            dataType: 'json',
            data    : data
        })
            .done(function (response)
            {
                if (response.data.success == true)
                {
                    //alert("Wow you commented");
                }
            })
            .fail(function ()
            {
                console.log("error");
            });

    });
});

function myFunctionNextQuestion($id)
{
    var mainCategory = document.getElementsByClassName('card sub-card card-open');
    alert(mainCategory);
    var name = mainCategory.collapse('hide');
    $('.subcategory-field').show().attr(mainCategory);

};
