jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        //alert(index);
        jQuery(this).html("Question: " + (index + 1));
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Question: " + (index + 1));
    });
});

function myFunctionAnswer()
{
    var answerElement = document.getElementsByName('answerOption')[0].value;
    if (answerElement == 'right')
    {
        document.getElementsByName('ExerciseForm[' + i + '][answer_a]')[0].value = 'True';
        document.getElementsByName('ExerciseForm[' + i + '][answer_b]')[0].value = 'False';
    }
};
