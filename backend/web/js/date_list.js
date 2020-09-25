function myFunctionYear()
{
    var yearElement = document.getElementsByName('year')[0].value;
    var varSelected = document.getElementById('yearId').options[document.getElementById('yearId').selectedIndex].text;
    if (yearElement != null)
    {
        window.location.href = "year-view?year=" + varSelected;
    }
};

function myFunctionMonth($year)
{
    var monthElement = document.getElementsByName('month')[0].value;
    if (monthElement != null)
    {
        window.location.href = "month-view?year=" + $year + "&month=" + monthElement;
    }
};


$('#document').ready(function () {
    var month = document.getElementsByClassName("selectElement")[0].id;
    document.getElementById(month).value = month;
});