
<div class="col-md-7" id="events">

	<div class="modal fade slow" id="eventCreateModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

	  	<div class="modal-dialog">

	    	<div class="modal-content">

		      	<div class="modal-header">

	        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

	        		<h4 class="modal-title" id="editModalLabel"><i class="fa fa-plus"></i> &nbsp;Create Event&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event will be made visible to the users of Student Portal only after Co-Curricular affairs secretary's approval."></i>]</h4>

	      		</div>

		      	<div class="modal-body">

		      		    <form role="form">

					  		<div class="form-group">

					   			<label for="eventClub">Event Organizer</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. It can either be a club or a special interest group or an individual"></i>]

					    		<input type="text" name="eventClub" class="form-control input-sm" style="background-color:white !important;border-radius:0px;" id="createEventOrganizerName" placeholder="Organizer Name">

					  		</div>      		    

					  		<div class="form-group">

					   			<label for="eventName">Event Name</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. Give an appropriate event name"></i>]

					    		<input type="text" name="eventName" class="form-control input-sm" style="background-color:white !important;border-radius:0px;" id="createEventName" placeholder="Event Name">

					  		</div>

					  		<div class="form-group">

					   			 <label for="eventContent">Event Details</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. Event Details maximum length 1000 characters."></i>]

					   			 <textarea type="text" name="eventContent" style="background-color:white;border-radius:0px;resize:none;" class="form-control" id="createEventContent"></textarea>

					  		</div>

					 		<!--  <div class="form-group">

					 			  <label for="fileInput">Attach Images </label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Optional. You can attach upto 1 image per event. Maximum image size allowed 1MB. Allowed extensions are .jpg, .png"></i>]

					  			  <input name="fileInput[]" type="file"  id="createEventFileInput" multiple="">

					  		</div> -->

					 		 <div class="form-group">

					    			<label for="shareWith">Share With</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Leaving it untouched makes the event visible to everyone. Examples would be like COE12, B.Tech12, etc. You can share the post with multiple groups by separating the groups with commas."></i>]

					    			<input value="All" name="createEventSharedWith" class="form-control"type="text" id="createEventSharedWith">

					  		</div>

					  		<div class="form-group col-md-6">

					  			<label for="eventVenue">Event Venue (*)</label>

					    		<input name="createEventVenue" class="form-control"type="text" id="createEventVenue">

					  		</div>
					  		
					  		<div class="form-group col-md-6">

					  			<label for="eventVenue">Event Date (*)</label>

					    		<input name="createEventDate" data-date-format="dd/mm/yyyy"  class="datepicker form-control" type="text" id="createEventDate">

					  		</div>

					  		<div class="form-group col-md-6">

					  			<label for="eventTime">Event Time</label>

					 			<input class="form-control clockpicker" name="createEventTime" id="createEventTime">

					  		</div>

					  		<div class="form-group col-md-6">

						  		<label for="eventType">Event Duration</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event Type. If it is a competition you will be given an option of posting winners on this page."></i>]

						  			<div class="row">

						  				<div class="col-md-6">

						  					<input type="number" name="eventDurationHours" id="createEventDurationHours" class="form-control"/>

				  						</div>

				  						<div class="col-md-6">

						  					<select type="text" name="eventDurationMinutes" id="createEventDurationMinutes" class="form-control">

						  						<option val="00">00</option>

						  						<option val="15">15</option>

						  						<option val="30">30</option>

						  						<option val="45">45</option>

					  						</select>

				  						</div>

			  						</div>
					  		</div>

					  		<div class="form-group">

						  		<label for="eventType">Event Type</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event Type. If it is a competition you will be given an option of posting winners on this page."></i>]

						  		<select type="select" class="form-control" id="createEventType" name="createEventType">

						  			<option val="competition">Competition</option>

						  			<option val="others">Others</option>

					  			</select>

					  		</div>

						</form>

					<button onclick="createEventSP();" class="btn btn-primary">Create Event</button>

		      	</div>

	    	</div>

	    </div>

	</div>


	<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

	  	<div class="modal-dialog">

	    	<div class="modal-content">

	    		<div id="editEventId" class="hidden"></div>

		      	<div class="modal-header">

	        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

	        		<h5 class="modal-title" id="editModalLabel"><i class="fa fa-pencil"></i> &nbsp;Edit Event&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event will be made visible to the users of Student Portal only after Co-Curricular affairs secretary's approval."></i>]</h5>

	      		</div>

		      	<div class="modal-body">

		      		    <form role="form">

					  		<div class="form-group">

					   			<label for="eventClub">Event Organizer</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. It can either be a club or a special interest group or an individual"></i>]

					    		<input type="text" name="eventClub" class="form-control input-sm" style="background-color:white !important;border-radius:0px;" id="editEventOrganizerName" placeholder="Organizer Name">

					  		</div>      		    

					  		<div class="form-group">

					   			<label for="eventName">Event Name</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. Give an appropriate event name"></i>]

					    		<input type="text" name="eventName" class="form-control input-sm" style="background-color:white !important;border-radius:0px;" id="editEventName" placeholder="Event Name">

					  		</div>

					  		<div class="form-group">

					   			 <label for="eventContent">Event Details</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Required. Event Details maximum length 1000 characters."></i>]

					   			 <textarea type="text" name="eventContent" style="background-color:white;border-radius:0px;resize:none;" class="form-control" id="editEventContent"></textarea>

					  		</div>

					 		<!--  <div class="form-group">

					 			  <label for="fileInput">Attach Images </label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Optional. You can attach upto 1 image per event. Maximum image size allowed 1MB. Allowed extensions are .jpg, .png"></i>]

					  			  <input name="fileInput[]" type="file"  id="createEventFileInput" multiple="">

					  		</div> -->

					 		 <div class="form-group">

					    			<label for="shareWith">Share with</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Leaving it untouched makes the event visible to everyone. Examples would be like COE12, B.Tech12, etc. You can share the post with multiple groups by separating the groups with commas."></i>]

					    			<input name="editEventSharedWith" value="All" class="form-control"type="text" id="editEventSharedWith">

					  		</div>

					  		<div class="form-group col-md-6">

					  			<label for="eventVenue">Event Venue (*)</label>

					    		<input name="editEventVenue" class="form-control"type="text" id="editEventVenue">

					  		</div>
					  		
					  		<div class="form-group col-md-6">

					  			<label for="eventVenue">Event Date (*)</label>

					    		<input name="editEventDate" data-date-format="dd/mm/yyyy"  class="datepicker form-control" type="text" id="editEventDate">

					  		</div>

					  		<div class="form-group col-md-6">

					  			<label for="eventTime">Event Time</label>

					 			<input class="form-control clockpicker" name="editEventTime" id="editEventTime">

					  		</div>

					  		<div class="form-group col-md-6">

						  		<label for="eventType">Event Duration</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event Duration is in hours:minutues format."></i>]

						  			<div class="row">

						  				<div class="col-md-6">

						  					<input type="number" name="eventDurationHours" id="editEventDurationHours" class="form-control"/>

				  						</div>

				  						<div class="col-md-6">

						  					<select type="text" name="eventDurationMinutes" id="editEventDurationMinutes" class="form-control">

						  						<option val="00">00</option>

						  						<option val="15">15</option>

						  						<option val="30">30</option>

						  						<option val="45">45</option>

					  						</select>

				  						</div>

			  						</div>
					  		</div>

					  		<div class="form-group">

						  		<label for="eventType">Event Type</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event Type. If it is a competition you will be given an option of posting winners on this page."></i>]

						  		<select type="select" class="form-control" id="editEventType" name="editEventType">

						  			<option val="competition">Competition</option>

						  			<option val="others">Others</option>

					  			</select>

					  		</div>

					  		<div class="form-group">

						  		<label for="eventStatus">Event Status</label>&nbsp;&nbsp;[<i class="fa fa-question popOver" data-trigger="hover click" data-toggle="popover" data-content="Event Status. If you want to postpone the event or cancel it or put it on hold please update this field."></i>]

						  		<select type="select" class="form-control" id="editEventStatus" name="editEventType">

						  			<option val="asScheduled">As Scheduled</option>

						  			<option val="postponed">Pospone</option>

						  			<option val="hold">On Hold</option>

						  			<option val="cancel">Cancel</option>

					  			</select>

					  		</div>

						</form>

					<button onclick="editedEventSend();" class="btn btn-primary">Edit Event</button>

		      	</div>

	    	</div>

	    </div>


	</div>

	<div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

	  	<div class="modal-dialog">

	    	<div class="modal-content">

		      	<div class="modal-header">

	        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

	        		<h4 class="modal-title" id="deleteEventModal"><i class="fa fa-pencil"></i> &nbsp;Delete Event</h4>

	      		</div>

	      		<div id="deleteEventId" class="hidden"></div>

		      	<div class="modal-body">

		      		    <form role="form">

					  		<div class="form-group">

					   			<label for="deleteEventQuestion">Do you want to delete this event?</label>

					    		<!-- <input type="email" name="eventClub" class="form-control input-sm" style="background-color:white !important;border-radius:0px;" id="editEventClubName" placeholder="Club Name"> -->

					  		</div>      		    

						</form>

					<button onclick="deleteEventSend();" class="btn btn-primary">Delete Event</button>

		      	</div>

	    	</div>

	    </div>

	</div>

	<div id="eventArea">



	</div><!-- end id eventArea -->

	

</div>

<style>

	.venueDateTimeEvent{
		padding-top:8px;
		/*padding-bottom:5px;*/
	}
	
	p{
		text-align:justify;
	}
	
	.visibleHidden{
		position:absolute;
		visibility:hidden;
	}
	
	#eventNameTime{
		margin-top:5px;
	}
	
	#eventPostedTime, #editEvent{
		margin-top:5px;
	}
	
	.popOver{
		color:gray;
	}

	.event{
		background-color:#fff;
	}

</style>



<style>
.clockpicker-popover{
	z-index:99999;
}

</style>