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

