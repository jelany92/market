<?php


namespace backend\components;

use Yii;
use yii\helpers\Url;

class FullCalenderEvent
{
    /**
     * 'dayClick'           => new \yii\web\JsExpression('// wenn ein auswälleen
     * function(date, jsEvent, view) {
     * window.location.href = "' . Url::toRoute([
     * '/site/view/',
     * 'date' => '',
     * ]) . '" + date.format("YYYY-MM-DD");
     * }
     * '),
     *
     * @return string
     */
    public static function addEvent(): string
    {
        $addEvent = Yii::t('app', 'Add Event');
        $AEurl    = Url::to(["site/view"]);
        $JSEvent  = <<<EOF
	function(allDay) {
		var date = moment(allDay).format("YYYY-MM-DD");
		$.ajax({
		   url: "{$AEurl}",
		   data: { date : date},
		   type: "GET",
		   success: function(data) {
			   $(".modal-body").addClass("row");
			   $(".modal-header").html('<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>{$addEvent}</h3>');
			   $('.modal-body').html(data);
			   $('#eventModal').modal();
		   }
	   	});
			}
EOF;
        return $JSEvent;
    }

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