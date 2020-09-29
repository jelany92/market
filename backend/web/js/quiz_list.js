function myFunctionAnswerType($i)
{
    var answerElement = document.getElementsByName('ExerciseForm[' + $i + '][question_type]')[0].value;
    $('.conditional-field').hide();
    if (answerElement == 1)
    {
        elementToShowTowChoice = $('.filter-exercise-tow_choice-field_' + $i);
        elementToShowTowChoice.show();
        $('.answerOption').show();
        $('.filter-right-answer-type-field').show();
    }
    else if (answerElement == 2)
    {
        elementToShowTowChoice   = $('.filter-exercise-tow_choice-field_' + $i);
        elementToShowTowChoice.show();
        elementToShowFourChoice  = $('.filter-exercise-four_choice-field_' + $i);
        elementToShowFourChoice.show();
        $('.filter-right-answer-type-field').show();
    }
    else if (answerElement == 3)
    {
        $('.filter-right-answer-type-field_' + $i).show();
    }
};

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

function myFunctionAnswer()
{
    var i             = document.getElementsByName('answerOption')[0].id;
    alert(i);
    var answerElement = document.getElementsByName('answerOption_' + i)[0].value;
    if (answerElement == 'right')
    {
        document.getElementsByName('ExerciseForm[' + i + '][answer_a]')[0].value = 'True';
        document.getElementsByName('ExerciseForm[' + i + '][answer_b]')[0].value = 'False';
    }
};

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});