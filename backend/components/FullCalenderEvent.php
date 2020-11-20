<?php


namespace backend\components;

use Yii;
use yii\helpers\Url;

class FullCalenderEvent
{

    /**
     * url:"{$UEurl}";
     *
     * @return string
     */
    public static function eventClick(): string
    {
        $updateEvent  = Yii::t('app', 'Update Event');
        $JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
	    var eventId = calEvent.id;
		$.ajax({
		   url: calEvent.rendering,
		   data: { event_id : eventId},
		   type: "GET",
		   success: function(data) {
			   $(".modal-body").addClass("row");
			   $(".modal-header").html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3> {$updateEvent} </h3>');
			   $('.modal-body').html(data);
			   $('#eventModal').modal();
		   }
	   	});
		$(this).css('border-color', 'red');
	}
EOF;
        return $JSEventClick;
    }
}