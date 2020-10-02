
$('#document').ready(function ()
{
    var answerElement = document.getElementsByName('ExerciseForm[question_type]')[0].value;
    $('.conditional-field').hide();
    if (answerElement == 1)
    {
        elementToShowTowChoice = $('.filter-exercise-tow_choice-field');
        elementToShowTowChoice.show();
        $('.answerOption').show();
        $('.filter-right-answer-type-field').show();
    }
    else if (answerElement == 2)
    {
        elementToShowTowChoice   = $('.filter-exercise-tow_choice-field');
        elementToShowTowChoice.show();
        elementToShowFourChoice  = $('.filter-exercise-four_choice-field');
        elementToShowFourChoice.show();
        $('.filter-right-answer-type-field').show();
    }
    else if (answerElement == 3)
    {
        $('.filter-right-answer-type-field').show();
    }
});


$('.answerOption').change(function(){
    var container = $(this).parents().eq(3);
    alert('test');
    var chk_all = container.find('.chk_all');
    if(container.find('.checkbox:not(:checked)').length == 0)
    {
        chk_all.prop('checked', true);
    }
    else
    {
        chk_all.prop('checked', false);
    }
});

function myFunctionAnswer()
{
    var i             = document.getElementsByName('answerOption')[0].id;
    var answerElement = document.getElementsByName('answerOption')[0].value;
    if (answerElement == 'right')
    {
        document.getElementsByName('ExerciseForm[' + i + '][answer_a]')[0].value = 'True';
        document.getElementsByName('ExerciseForm[' + i + '][answer_b]')[0].value = 'False';
    }
};









