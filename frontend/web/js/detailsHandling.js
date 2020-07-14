jQuery(document).ready(function () {
    jQuery('div[function="1"]').find('input:radio').change(function () {
        var jQThis = jQuery(this);
        var fId = jQThis.data('functionid');
        var cIdList = [jQThis.data('categoryid')];
        var val = jQThis.val();
        var cName = jQThis.data('categoryname');
        //if need be, hide no-value-error for just rated function
        jQThis.closest('div.function').find('div.no-value-error').fadeOut();
        // Mark function as answered
        jQThis.closest('div.function').addClass('alert-success');
        //find all radio buttons with the same fId and value but different cId
        var cloneFunctionRadios = jQuery('div[function="1"]').find('input:radio[data-functionid="' + fId + '"][data-categoryid!="' + cIdList[0] + '"][value="' + val + '"]');

        cloneFunctionRadios.each(function () {
            jQThis = jQuery(this);
            //push cId of radios with same fId onto list
            cIdList.push(jQThis.data('categoryid'));
            //if need be, hide no-value-error for just rated function
            jQThis.closest('div.function').find('div.no-value-error').fadeOut();

            //get all error divs for functions already rated, fill in category name and show
            var alreadyAnsweredError = jQThis.closest('div.function').find('div.already-answered-error');
            alreadyAnsweredError.find('.already-answered-category-name').text(cName);
            alreadyAnsweredError.show();
            // Mark function as answered
            jQThis.closest('div.function').addClass('alert-success');

            var radios = jQThis.closest('div[function="1"]').find('input:radio');
            //disable and auto select all radios with same fId
            radios.attr('disabled', 'true');
            radios.filter('[value="' + val + '"]').attr('checked', true);
        });

        var additionBooleans = jQuery('input:checkbox[data-functionid="' + fId + '"]');
        additionBooleans.filter('[name="requires-explanation"]').prop('disabled', false);
        if (val == 5) {
            additionBooleans.filter('[name="test-criteria"]').prop('checked', true);
            additionBooleans.filter('[name="test-criteria"]').prop('disabled', true);
        } else if (val == 1 || val == 2) {
            additionBooleans.filter('[name="test-criteria"]').prop('checked', false);
            additionBooleans.filter('[name="test-criteria"]').prop('disabled', true);
        } else {
            additionBooleans.filter('[name="test-criteria"]').prop('disabled', false);
        }
        var testcriteria = additionBooleans.filter('[name="test-criteria"]').prop('checked') ? 1 : 0;

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {dataKey: dataKey, fId: fId, cIdList: cIdList, value: val, testCriteria: testcriteria}
        });

    });

    jQuery('.checkbox').change(function () {
        var fId = $(this).data('functionid');

        var additionBooleans = jQuery('input:checkbox[data-functionid="' + fId + '"]');

        var testcriteria = additionBooleans.filter('[name="test-criteria"]').prop('checked') ? 1 : 0;
        var explain = additionBooleans.filter('[name="requires-explanation"]').prop('checked') ? 1 : 0;
        $.ajax(
            {
                url: ajaxCheckboxTypeUrl,
                type: 'POST',
                data: {testCriteria: testcriteria, explain: explain, fId: fId, dataKey: dataKey}
            }
        );
    });

    jQuery('.save-category').click(function () {
        var btn = jQuery(this);
        var cId = jQuery(this).data('categoryid');
        var categoryDiv = jQuery('#category_' + cId);
        var functionContainers = categoryDiv.find('div.function');

        var currentPanelHead = jQuery('#heading' + (btn.data('panelid'))).parent();
        var currentPanel = jQuery('#heading' + (btn.data('panelid'))).parent().parent();
        var nextPanel = jQuery('#heading' + (btn.data('panelid') + 1));

        //Traverse each function container of the category container and check if it has a checked radio button
        var error = false;
        functionContainers.each(function () {
            var containerDiv = jQuery(this);
            var checked = containerDiv.find('input:radio:checked');
            if (!checked.length) {
                //if none is checked, toggle error bool and show error div for that specific function container
                error = true;
                containerDiv.find('div.no-value-error').fadeIn();
            }
        });
        if (error) {
            btn.removeClass('btn-success');
            btn.addClass('btn-danger');
            currentPanelHead.removeClass('alert-success');
            currentPanelHead.addClass('alert-danger');
        } else {
            btn.removeClass('btn-danger');
            btn.addClass('btn-success');
            currentPanelHead.removeClass('alert-danger');
            currentPanelHead.addClass('alert-success');
            //open next panel and scroll to it
            nextPanel.trigger('click');
            setTimeout(function () {
                $('html, body').scrollTop(currentPanelHead.offset().top - 65);
            }, 1);
        }
        return false;
    });
});