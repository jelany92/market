function myFunctionMainCategory()
{
    var mainCategoryElement = document.getElementsByName('mainCategory')[0].value;
    if (mainCategoryElement !== '')
    {
        window.location.href = "main-category?mainCategoryId=" + mainCategoryElement;
    }
};

function myFunctionSubcategory(mainCategoryId)
{
    var subcategoryElement = document.getElementsByName('subcategory')[0].value;
    if (subcategoryElement != null)
    {
        if (mainCategoryId != null)
        {
            window.location.href = "main-category?mainCategoryId=" + mainCategoryId + "&subcategoryId=" + subcategoryElement;
        }
        else
        {
            window.location.href = "subcategory?subcategoryId=" + subcategoryElement;

        }
    }
};

function myFunctionDate(mainCategoryId, subcategoryElement)
{
    var dateElement = document.getElementsByName('date')[0].value;
    if (dateElement != null)
    {
        window.location.href = "main-category?mainCategoryId=" + mainCategoryId + "&subcategoryId=" + subcategoryElement + "&date=" + dateElement;
    }
};

$('#document').ready(function ()
{
    var subcategoryElement                             = document.getElementsByClassName("selectSubcategoryElement")[0].id;
    document.getElementById(subcategoryElement).value  = subcategoryElement;
    var mainCategoryElement                            = document.getElementsByClassName("selectMainCategoryElement")[0].id;
    document.getElementById(mainCategoryElement).value = mainCategoryElement;
    var dateElement                                    = document.getElementsByClassName("selectDateElement")[0].id;
    document.getElementById(dateElement).value         = dateElement;
});


function myFunctionMonth($year)
{
    var subcategoryElement = document.getElementsByName('subcategory')[0].value;
    if (monthElement != null)
    {
        window.location.href = "month-view?year=" + $year + "&month=" + monthElement;
    }
};
