function approveEvent(e, t) {
    $.post("/4pi/handlers/eventHandlers/approveEvent.php", {
        _eventId: e,
        _status: t
    }).error(function() {
        alert("Server overload. Please try again.:(")
    }).success(function(t) {
        1 == checkData(t) && $("#" + e).find(".approve").remove()
    })
}

function eventInsert(e, t, n) {
    var a = "";
    a += '<div class="row event" id="' + t.eventIdHash + '" style="border:1px solid #cecece;margin-bottom:10px;">', 1 == t.isCOCAS && 1 != t.isApproved ? (a += '<div class="row approve" style="padding-top:10px;">', a += '<div class="col-md-6 text-center">', a += '<button class="btn btn-success btn-md" onclick="approveEvent(\'' + t.eventIdHash + "',1)\">Approve</button>", a += "</div>", a += '<div class="col-md-6 text-center">', a += '<button class="btn btn-danger btn-md" onclick="approveEvent(\'' + t.eventIdHash + "',-1)\">Reject</button>", a += "</div>", a += "</div>") : 1 != t.isCOCAS && 1 != t.isApproved && (a += "<br/><p class='text-center' style='color:red'>Your events is sent for approval</p>"), a += '<div id="eventSharedWith" class="hidden" >' + t.sharedWith + "</div>", a += '<div id="eventStatus" class="hidden" >' + t.eventStatus + "</div>", a += '<div id="eventType" class="hidden">' + t.eventType + "</div>", a += '<div id="eventCategory" class="hidden">' + t.eventCategory + "</div>", a += '<div class="row" id="eventNameTime">', a += '<div class="col-md-8 text-left" id="eventNameAndClub">', a += '<div style="font-size:18px;"><b><span id="eventName" class="text-bold">' + t.eventName + '</span></b> by <span id="eventOrganizer" class="text-bold">' + t.eventOrgName + "</span></div>", a += "</div>";
    var i = iso8601ToReadable(t.eventTimestamp);
    1 == t.eventOwner ? (a += '<div class="col-md-3 col-md-offset-1 text-right"  id="editEvent">', a += '<p class="text-right">', a += '<span id="eventPostedTime">', a += '<small><time class="timeago" id="eventPostedTimeValue" datetime="' + t.eventTimestamp + '" title="' + i + '">' + t.eventTimestamp + "</time></small>", a += '</span>&nbsp;&nbsp;<i class="fa fa-pencil" title="Edit Event" onclick="editEvent(\'' + t.eventIdHash + "');\"></i>&nbsp;", a += '<i class="fa fa-trash" title="Delete Event" onclick="deleteEvent(\'' + t.eventIdHash + "');\"></i></p>", a += "</div>") : (a += '<div class="col-md-3 col-md-offset-1 text-right" id="eventPostedTime">', a += '<small><time class="timeago" id="eventPostedTimeValue" datetime="' + t.eventTimestamp + '" title="' + i + '">' + t.eventTimestamp + "</time></small>", a += "</div>"), a += "<br/>", a += '<div class="row" style="padding-top:20px;">', a += '<div class="col-md-12">', a += '<p id="eventContent" class="break-word" style="white-space:pre-wrap">' + t.eventContent + "</p>", a += "</div>", a += "</div>", a += '<div class="row" id="eventDetails">', a += '<div class="col-md-10 col-md-offset-1">', a += '<div class="btn-group btn-group-justified">', a += '<div class="btn-group">', a += '<button type="button" class="btn btn-default"  style="cursor:default !important"  title="Event Venue"><p  style="cursor:default !important" class="venueDateTimeEvent text-center" ><i style="cursor:default !important"  class="fa fa-map-marker" title="Venue"></i>&nbsp;&nbsp;<span id="eventVenue">' + t.eventVenue + "</span></p></button>", a += "</div>", a += '<div class="btn-group">', a += '<button type="button" class="btn btn-default" style="cursor:default !important"  title="Event Date"><p style="cursor:default !important"  class="venueDateTimeEvent text-center"><i  style="cursor:default !important"  class="fa fa-calendar" title="Date"></i>&nbsp;&nbsp;<span id="eventDate">' + t.eventDate + "</span></p></button>", a += "</div>", a += '<div class="btn-group">', a += '<button type="button" class="btn btn-default" style="cursor:default !important"  title="Event Time" ><p  style="cursor:default !important"  class="venueDateTimeEvent text-center"><i  style="cursor:default !important"  class="fa fa-clock-o" title="Time"></i>&nbsp;<span id="eventTime">' + t.eventTime + "</span></p></button>", a += "</div>", a += '<div class="btn-group">', a += '<button type="button" class="btn btn-default" style="cursor:default !important" title="Event Duration"><p  style="cursor:default !important"  class="venueDateTimeEvent text-center"><i style="cursor:default !important"  class="fa fa-arrows-h" title="Duration"></i>&nbsp;<span id="eventDurationHours">' + t.eventDurationHrs + '</span>:<span id="eventDurationMinutes">' + t.eventDurationMin + "</span>&nbsp;hrs</p></button>", a += "</div>", a += "</div>", a += "</div>", a += "</div>", a += "<br/>", a += '<div class="row" id="eventIcons">', a += '<div class="col-md-2 col-md-offset-1">', a += '<span id="eventAttendeeNumber" ><i class="fa fa-check" style="padding-top:7px;" title="No of Attenders"></i>&nbsp;<span id="eventAttendersValue">' + t.attendCount + "</span></span>", a += "</div>", a += '<div class="col-md-4 col-md-offset-1">', a += '<p style="padding-top:7px;"><b>Event status:</b>' + t.eventStatus + "</p>", a += "</div>", 1 != n && (a += '<div class="col-md-2 col-md-offset-1 text-left">', 1 != t.isAttender ? (a += '<button class="btn btn-sm btn-success" id="attend" onclick="attendEvent(\'' + t.eventIdHash + '\');"><i class="fa fa-check"></i>&nbsp; Attend</button>', a += '<button class="btn btn-sm btn-danger visibleHidden" style="cursor:not-allowed !important"  id="attending"> Attending</button>') : a += '<button class="btn btn-sm btn-danger"  style="cursor:not-allowed !important"  id="attending">Attending</button>', a += "</div>"), a += "</div>", a += "<br/>", a += "</div>", a += "</div>", "first" == e ? $("#eventArea").prepend(a).hide().fadeIn("slow") : $("#eventArea").append(a).hide().fadeIn("slow")
}

function editEvent(e) {
    $("#editEventModal").modal("show"), $("#editEventModal").find("#editEventId").html(e);
    var t = $("#" + e).find("#eventOrganizer").html(),
        n = $("#" + e).find("#eventName").html(),
        a = $("#" + e).find("#eventContent").html(),
        i = $("#" + e).find("#eventSharedWith").html(),
        d = $("#" + e).find("#eventVenue").html(),
        o = $("#" + e).find("#eventDate").html(),
        s = $("#" + e).find("#eventTime").html(),
        v = $("#" + e).find("#eventDurationHours").html(),
        l = $("#" + e).find("#eventDurationMinutes").html(),
        r = $("#" + e).find("#eventType").html(),
        c = ($("#" + e).find("#eventStatus").html(), $("#" + e).find("#eventCategory").html());
       	m = o.split("/");
       	o = m[1]+"/"+m[0]+"/"+m[2];
       	// alert(o);
    $("#editEventModal").find("#editEventOrganizerName").val(t), $("#editEventModal").find("#editEventName").val(n), $("#editEventModal").find("#editEventContent").val(a), $("#editEventModal").find("#editEventSharedWith").val(i), $("#editEventModal").find("#editEventVenue").val(d), $("#editEventModal").find("#editEventDate").val(o), $("#editEventModal").find("#editEventTime").val(s), $("#editEventModal").find("#editEventDurationHours").val(v), $("#editEventModal").find("#editEventDurationMinutes").val(l), $("#editEventModal").find("#editEventType").val(r), $("#editEventModal").find("#editEventStatus").val("As Scheduled"), $("#editEventModal").find("#editEventCategory").val(c), $("#editEventModal").find("#editEventId").html(e)
}

function modifyEvent(e, t) {
    $("#" + t).find("#eventOrganizer").html(e.eventOrgName), $("#" + t).find("#eventName").html(e.eventName), $("#" + t).find("#eventContent").html(e.eventContent), $("#" + t).find("#eventSharedWith").html(e.sharedWith), $("#" + t).find("#eventVenue").html(e.eventVenue), $("#" + t).find("#eventDate").html(e.eventDate), $("#" + t).find("#eventTime").html(e.eventTime), $("#" + t).find("#eventDurationHours").html(e.eventDurationHrs), $("#" + t).find("#eventDurationMinutes").html(e.eventDurationMin), $("#" + t).find("#eventType").html(e.eventType), $("#" + t).find("#eventStatus").html(e.eventStatus), $("#" + t).find("#eventCategory").html(e.eventCategory)
}

function editedEventSend() {
    $("#editEventModal").find("#loadingImage").removeClass("hidden"), $("#editEventModal").find("#editEventButton").hide();
    var e = $("#editEventModal").find("#editEventId").html(),
        t = $("#editEventModal").find("#editEventOrganizerName").val(),
        n = $("#editEventModal").find("#editEventName").val(),
        a = $("#editEventModal").find("#editEventContent").val(),
        i = $("#editEventModal").find("#editEventSharedWith").val(),
        d = $("#editEventModal").find("#editEventVenue").val(),
        o = $("#editEventModal").find("#editEventDate").val(),
        s = $("#editEventModal").find("#editEventTime").val(),
        v = $("#editEventModal").find("#editEventDurationHours").val(),
        l = $("#editEventModal").find("#editEventDurationMinutes").val(),
        r = $("#editEventModal").find("#editEventStatus").val(),
        c = $("#editEventModal").find("#editEventType").val(),
        p = $("#editEventModal").find("#editEventCategory").val();
        m = o.split("/")
        o = m[1]+"/"+m[0]+"/"+m[2]
    0 == t.length || 0 == n.length || 0 == a.length || a.length > 1e4 || 0 == d.length || 0 == o.length ? alert("Please fill in the required fields.") : $.post("./handlers/eventHandlers/editEvent.php", {
        _eventId: e,
        _eventOrgName: t,
        _eventName: n,
        _content: a,
        _sharedWith: i,
        _venue: d,
        _eventDate: o,
        _eventTime: s,
        _eventDurationHrs: v,
        _eventDurationMin: l,
        _status: r,
        _eventType: c,
        _eventCategory: p
    }).error(function() {}).success(function(t) {console.log(t);
        1 == checkData(t) ? ($("#editEventModal").modal("hide"), $("#editEventModal").find("#loadingImage").addClass("hidden"), $("#editEventModal").find("#editEventButton").show(), t = JSON.parse(t), modifyEvent(t, e)) : ($("#editEventModal").find("#loadingImage").addClass("hidden"), $("#editEventModal").find("#editEventButton").show())
    })
}

function createEventSP() {
    $("#eventCreateModal").find("#loadingImage").removeClass("hidden"), $("#eventCreateModal").find("#createEventButton").hide(), $(".row .eventMenu").find("#createEventButton").find("i").addClass("fa-spin");
    var e = $("#createEventOrganizerName").val().trim(),
        t = $("#createEventName").val().trim(),
        n = $("#createEventContent").val().trim(),
        a = $("#createEventSharedWith").val().trim(),
        i = $("#createEventVenue").val().trim(),
        d = $("#createEventDate").val().trim();
        var o = d.split("/");
        d = o[1]+"/"+o[0]+"/"+o[2];
    var s = $("#createEventTime").val().trim(),
        v = $("#createEventDurationHours").val().trim(),
        l = $("#createEventDurationMinutes").val().trim(),
        r = $("#createEventType").val().trim(),
        c = $("#createEventCategory").val().trim();
    0 == e.length || 0 == t.length || 0 == n.length || 0 == i.length || 0 == d.length ? alert("Please fill in the required fields.") : n.length > 1e4 ? alert("Please limit the event content to 1000 characters.") : $.post("./handlers/eventHandlers/createEvent.php", {
        _eventOrgName: e,
        _eventName: t,
        _content: n,
        _sharedWith: a,
        _venue: i,
        _eventDate: d,
        _eventTime: s,
        _eventDurationHrs: v,
        _eventDurationMin: l,
        _eventType: r,
        _eventCategory: c
    }).error(function() {
        alert("Server Overload. Please try again.")
    }).success(function(e) {
        1 == checkData(e) ? (x = JSON.parse(e), eventInsert("first", x, 2), $(".timeago").timeago(), $(".row .eventMenu").find("#createEventButton").find("i").removeClass("fa-spin"), $("#eventCreateModal").modal("hide"), $("#eventCreateModal").find("#loadingImage").addClass("hidden"), $("#eventCreateModal").find("#createEventButton").show(), $("#createEventOrganizerName").val(""), $("#createEventName").val(""), $("#createEventName").val(""), $("#createEventContent").val(""), $("#createEventSharedWith").val("All"), $("#createEventVenue").val(""), $("#createEventDate").val(""), $("#createEventTime").val(""), $("#createEventDurationHours").val("2"), $("#createEventDurationMinutes").val("00"), $("#createEventType").val("competition"), $("#createEventCategory").val("technical")) : ($("#eventCreateModal").find("#loadingImage").addClass("hidden"), $("#eventCreateModal").find("#createEventButton").show())
    })
}

function attendEvent(e) {
    x = $("#" + e).find("#eventIcons").find("#eventAttendeeNumber").find("#eventAttendersValue").html(), y = parseInt(x), y += 1, $("#" + e).find("#eventIcons").find("#eventAttendeeNumber").find("#eventAttendersValue").html(y), $.post("./handlers/eventHandlers/attendEvent.php", {
        _eventId: e
    }).error(function() {}).success(function(t) {
        t = t.trim(), 1 == checkData(t) && ($("#" + e).find("#evenAttendeeNumber").html(t.eventAttendeeCount), $("#" + e).find("#attend").toggleClass("visibleHidden"), $("#" + e).find("#attending").toggleClass("visibleHidden"))
    })
}

function deleteEvent(e) {
    $("#deleteEventModal").modal("show"), $("#deleteEventModal").find("#deleteEventId").html(e)
}

function deleteEventSend() {
    var e = $("#deleteEventModal").find("#deleteEventId").html();
    $("#deleteEventModal").modal("hide"), $("#" + e).hide(), $.post("./handlers/eventHandlers/deleteEvent.php", {
        _eventId: e
    }).error(function() {}).success(function(t) {
        1 == t && $("#" + e).remove()
    })
}

function latestEventsFetch(e, t) {
    $("#loadMoreEventsButton").html("Loading").attr("onclick", ""), $(".row .eventMenu").find("#latestEventsButton").find("i").addClass("fa-spin"), -1 == t && $(".event").remove();
    var n = [],
        a = 0;
    $(".event").each(function() {
        n[a] = $(this).attr("id"), a++
    }), $.post("/4pi/handlers/eventHandlers/latestEvents.php", {
        _sgk: n,
        _refresh: t
    }).error(function() {
        alert("Server overload error. Please try again. :("), $("#loadMoreEventsButton").html("Load more").attr("onclick", "fetchMoreEvents();")
    }).success(function(t) {
        if ($("#inViewElement").html("1001"), $(".row .eventMenu").find("#latestEventsButton").find("i").removeClass("fa-spin"), $(".row .eventMenu").find("#latestEventsButton").css({
                "box-shadow": "inset #000 0px 3px 0 0",
                "border-top": "1px solid black"
            }), $(".row .eventMenu").find("#upcomingEventsButton").css({
                "box-shadow": "inset #5CB85C 0px 3px 0 0",
                "border-top": "1px solid #5CB85C"
            }), $(".row .eventMenu").find("#eventWinnersButton").css({
                "box-shadow": "inset #D9534F 0px 3px 0 0",
                "border-top": "1px solid #D9534F"
            }), "empty" == e && $(".event").each(function() {
                $(this).remove()
            }), t = t.trim(), 1 == checkData(t))
            if (404 != t) {
                var n = JSON.parse(t);
                for (a = 0; a < n.length; a++) eventInsert("last", n[a], 2);
                $(".timeago").timeago(), $("#loadMoreEventsButton").html("Load more").attr("onclick", "fetchMoreEvents();")
            } else $("#eventEmptyMessage").find("#messageEmpty").html("No events to display."), $("#loadMoreEventsButton").hide();
        $(".row .eventMenu").find("#latestEventsButton").find("i").removeClass("fa-spin")
    })
}

function upcomingEventsFetch(e, t) {
    $("#loadMoreEventsButton").html("Loading").attr("onclick", ""), $(".row .eventMenu").find("#upcomingEventsButton").find("i").addClass("fa-spin"), -1 == t && $(".event").remove();
    var n = [],
        a = 0;
    $(".event").each(function() {
        n[a] = $(this).attr("id"), a++
    }), $.post("/4pi/handlers/eventHandlers/upcomingEvents.php", {
        _refresh: t,
        _sgk: n
    }).error(function() {
        alert("Server overload error. Please try again. :(")
    }).success(function(t) {
        if ($("#inViewElement").html("1002"), $(".row .eventMenu").find("#upcomingEventsButton").find("i").removeClass("fa-spin"), $(".row .eventMenu").find("#latestEventsButton").css({
                "box-shadow": "inset #428BCA 0px 3px 0 0",
                "border-top": "1px solid #428BCA"
            }), $(".row .eventMenu").find("#upcomingEventsButton").css({
                "box-shadow": "inset #000 0px 3px 0 0",
                "border-top": "1px solid #000"
            }), $(".row .eventMenu").find("#eventWinnersButton").css({
                "box-shadow": "inset #D9534F 0px 3px 0 0",
                "border-top": "1px solid #D9534F"
            }), t = t.trim(), "empty" == e && $(".event").each(function() {
                $(this).remove()
            }), 1 == checkData(t))
            if (404 != t) {
                var n = JSON.parse(t);
                for (a = 0; a < n.length; a++) eventInsert("last", n[a], 2);
                $(".timeago").timeago(), $("#loadMoreEventsButton").html("Load more").attr("onclick", "fetchMoreEvents();")
            } else $("#eventEmptyMessage").find("#messageEmpty").html("No events to display."), $("#loadMoreEventsButton").hide();
        $(".timeago").timeago(), $(".row .eventMenu").find("#upcomingEventsButton").find("i").removeClass("fa-spin")
    })
}

function pastCompetitionsFetch(e, t) {
    $("#loadMoreEventsButton").html("Loading").attr("onclick", ""), $(".row .eventMenu").find("#eventWinnersButton").find("i").addClass("fa-spin"), -1 == t && $(".event").remove();
    var n = [],
        a = 0;
    $(".event").each(function() {
        n[a] = $(this).attr("id"), a++
    }), $.post("/4pi/handlers/eventHandlers/pastEvents.php", {
        _call: t,
        _sgk: n
    }).error(function() {
        alert("Server overload error. Please try again. :(")
    }).success(function(t) {
        if ($("#inViewElement").html("1003"), $(".row .eventMenu").find("#eventWinnersButton").find("i").removeClass("fa-spin"), $(".row .eventMenu").find("#latestEventsButton").css({
                "box-shadow": "inset #428BCA 0px 3px 0 0",
                "border-top": "1px solid #428BCA"
            }), $(".row .eventMenu").find("#upcomingEventsButton").css({
                "box-shadow": "inset #5CB85C 0px 3px 0 0",
                "border-top": "1px solid #5CB85C"
            }), $(".row .eventMenu").find("#eventWinnersButton").css({
                "box-shadow": "inset #000 0px 3px 0 0",
                "border-top": "1px solid #000"
            }), t = t.trim(), "empty" == e && $(".event").each(function() {
                $(this).remove()
            }), 1 == checkData(t))
            if (404 != t) {
                var n = JSON.parse(t);
                for (a = 0; a < n.length; a++) eventInsert("last", n[a], 1);
                $(".timeago").timeago(), $("#loadMoreEventsButton").html("Load more").attr("onclick", "fetchMoreEvents();")
            } else $("#eventEmptyMessage").find("#messageEmpty").html("No events to display."), $("#loadMoreEventsButton").hide()
    }), $(".row .eventMenu").find("#eventWinnersButton").find("i").removeClass("fa-spin")
}
$(document).ready(function() {
    $(".datepicker").datepicker({}), $(".datepicker").css({
        "z-index": "1052"
    });
    var e = $("#eventCreateModal").find("#createEventTime");
    e.clockpicker({
        placement: "top",
        align: "left",
        donetext: "Done",
        autoclose: "true"
    });
    var t = $("#editEventModal").find("#editEventTime");
    t.clockpicker({
        placement: "top",
        align: "left",
        donetext: "Done",
        autoclose: "true"
    }), $(".popOver").popover()
}), $(".popOver").popover(), $("time.timeago").timeago();