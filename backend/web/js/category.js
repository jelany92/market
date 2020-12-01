function mainCategoryFunction()
{
    var mainCategory = document.getElementsByClassName('mainCategory')[0].value;
    $('.subcategory-field').show().attr(mainCategory);
};


