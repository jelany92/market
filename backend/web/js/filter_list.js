function myFunctionSubcategory()
{
    var subcategoryElement = document.getElementsByName('subcategory')[0].value;
    if (subcategoryElement != null)
    {
        window.location.href = "index?subcategoryId=" + subcategoryElement;
    }
};

$('#document').ready(function ()
{
    var subcategoryElement                             = document.getElementsByClassName("selectSubcategoryElement")[0].id;
    document.getElementById(subcategoryElement).value  = subcategoryElement;
});