$(document).ready(function(){
   //selected option in mainCategory dropdown changed
   $('#mainCategorySelect').change(function () {
      var categoryMultiSelect = $('#categorySelect');
      var newMainCategory = $(this).find('option:selected').val();

      //display and re-enable all options in category multiselect
      var allOptions = categoryMultiSelect.find('option');
      allOptions.prop('disabled', false);
      allOptions.show();
      //hide and disable selected option in mainCategory dropdown in category multiselect
      var optionElementInCategoryList = allOptions.filter('[value=' +  newMainCategory +']');
      optionElementInCategoryList.prop('disabled', true);
      optionElementInCategoryList.prop('selected', false);
      optionElementInCategoryList.hide();
   });
});