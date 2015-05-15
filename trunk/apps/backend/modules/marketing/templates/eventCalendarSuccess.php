<link rel="stylesheet" type="text/css" href="/template/inspinia/css/plugins/fullcalendar/fullcalendar.css"/>
<link rel="stylesheet" type="text/css" media="print" href="/template/inspinia/css/plugins/fullcalendar/fullcalendar.print.css"/>
<link rel="stylesheet" type="text/css" href="/js/jquery/timepicker/jquery-ui-timepicker-addon.css"/>

<style type="text/css">
    #calendar span {
        color: #ffffff;
        font-size: small;
    }
</style>

<script type="text/javascript" src="/template/inspinia/js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/template/inspinia/js/jquery-ui-1.10.4.min.js"></script>
<script type="text/javascript" src="/js/jquery/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="/js/jquery/timepicker/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/fullcalendar/moment.min.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script type="text/javascript" src="/template/inspinia/js/plugins/validate/jquery.validate.min.js"></script>
<script type="text/javascript">
    $(function () {

        // Init calendar.
        $("#calendar").fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: {
                url: "<?php echo url_for("marketing/eventCalendar") ?>",
                type: 'POST',
                data: {
                    act: "load" // Start & end date is auto included by plugin.
                },
                error: function () {
                }
            },
            dayClick: function (date, jsEvent, view) {
                // Auto fill datetime for new event upon clicking on day in calendar.
                if ($("#event_id").val().length) {
                    // Clear existing data.
                    $("#btnCancel").trigger("click");
                }

                $("#date_start").val(date.format("YYYY-MM-DD 00:00"));
                $("#date_end").val(date.format("YYYY-MM-DD 23:59"));
            },
            eventDrop: function(event, delta, revertFunc) {
                addChangedEvent(event);
            },
            eventResize: function(event, delta, revertFunc) {
                addChangedEvent(event);
            },
            eventClick: function(calEvent, jsEvent, view) {
                editEvent(calEvent);
            }
        });

        var changedEvents = [];

        function addChangedEvent(event) {
            // Capture edited events from calendar drag & drop actions.
            var found = false;

            for (var i = 0; i < changedEvents.length; i++) {
                if (changedEvents[i].id == event.id) {
                    // Event already exists, replace it.
                    changedEvents[i] = event;
                    found = true;
                }
            }

            if (!found) {
                // Record is new, add into array.
                changedEvents.push(event);
            }

            if ($("#event_id").val() == event.id) {
                // Update detail form.
                var form = $("#newForm");

                $("#date_start", form).val(event.start.format("YYYY-MM-DD HH:mm"));
                $("#date_end", form).val(event.end.format("YYYY-MM-DD HH:mm"));
            }
        }

        $("#btnSaveCalendar").click(function() {
            // POST changed events to server via JSON format.
            if (changedEvents != null) {
                var events = [];

                // Parse event object to array item.
                for (var i = 0; i < changedEvents.length; i++) {
                    var event = changedEvents[i];
                    var obj = {
                        "id": event.id,
                        "event_title": event.title,
                        "date_start": event.start,
                        "date_end": event.end
                    };

                    if (obj.date_start != null)
                        obj.date_start = obj.date_start.format("YYYY-MM-DD HH:mm");

                    if (obj.date_end != null)
                        obj.date_end = obj.date_end.format("YYYY-MM-DD HH:mm");

                    events.push(obj);
                }

                $("#events").val(JSON.stringify(events));
            } else {
                // No changed event available.
                $("#events").val("");
            }

            $("#calendarForm").submit();
        });

        // Init datetimepicker.
        $("#date_start, #date_end").datetimepicker({
            dateFormat: 'yy-mm-dd',
            timeFormat: 'HH:mm'
        });

        $("#all_day").change(function() {
            // Format time upon option changing.
            // Time is not being used in all day event.
            var displayTime = !$(this).prop("checked");

            $("#date_start, #date_end").datetimepicker("option", "showTime", displayTime);
            $("#date_start, #date_end").datetimepicker("option", "showHour", displayTime);
            $("#date_start, #date_end").datetimepicker("option", "showMinute", displayTime);

            if (!displayTime) {
                checkAllDayDatetimeFormat();
            }
        });

        $("#date_start, #date_end").change(function() {
            if ($("#all_day").prop("checked")) {
                checkAllDayDatetimeFormat();
            }
        });

        $.validator.addMethod("datetimeFormat", function(value, element) {
            // Accept only yyyy-MM-dd HH:mm
            return moment(value, 'YYYY-MM-DD HH:mm', true).isValid();
        });

        $("#newForm").validate({
            messages : {
                "date_start": {
                    datetimeFormat: "Invalid date format."
                },
                "date_end": {
                    datetimeFormat: "Invalid date format."
                }
            },
            rules : {
                "event_title" : {
                    required: true
                },
                "event_detail" : {
                    required: true
                },
                "date_start" : {
                    required: true,
                    datetimeFormat: true
                },
                "date_end" : {
                    required: true,
                    datetimeFormat: true
                }
            },
            submitHandler: function(form) {
                if ($("#act").val() == "delete") {
                    form.submit();
                    return true;
                }

                var confirmMsg = "Confirm create new event?";

                if ($("#event_id").val().length) {
                    confirmMsg = "Confirm save event details?";
                }

                if (confirm(confirmMsg)) {
                    waiting();
                    form.submit();
                }

                return false;
            }
        });

        $("#btnDelete").click(function() {
            if (confirm("Confirm delete this event?")) {
                $("#act").val("delete");

                $("#newForm").validate().cancelSubmit = true;
                $("#newForm").submit();
            }
        });

        $("#btnCancel").click(function() {
            // Reset all form inputs to blank.
            var form = $("#newForm");

            $("h3", form).html("Create New Event");
            $("#act", form).val("new");
            $("#event_id", form).val("");
            $("#event_title", form).val("");
            $("#event_detail", form).val("");
            $("#date_start", form).val("");
            $("#date_end", form).val("");
            $("#all_day", form).prop("checked", false);

            $("#btnDelete", form).hide();
            $("#btnCancel", form).hide();
        });
    });

    function checkAllDayDatetimeFormat() {
        // Ensure inputted datetime format is correct.
        $("#date_start, #date_end").each(function() {
            if ($(this).val().length) {
                if ($("#all_day").prop("checked")) {
                    $(this).val(moment($(this).val(), "YYYY-MM-DD HH:mm").format("YYYY-MM-DD 00:00"));
                }
            }
        });
    }

    function editEvent(event) {
        var form = $("#newForm");

        $("h3", form).html("Edit Event");
        $("#act", form).val("new");
        $("#event_id", form).val(event.id);
        $("#event_title", form).val(event.title);
        $("#event_detail", form).val(event.detail);
        $("#date_start", form).val(event.start.format("YYYY-MM-DD HH:mm"));
        $("#date_end", form).val(event.end.format("YYYY-MM-DD HH:mm"));
        $("#all_day", form).prop("checked", (event.all_day == "Y"));

        $("#btnDelete", form).show();
        $("#btnCancel", form).show();
    }
</script>

<div style="padding: 10px; top: 30px; position: absolute; width: 1100px">
    <div class="portlet">
        <div class="portlet-header">Event Calendar</div>
        <div class="portlet-content">

            <form id="calendarForm" method="post" action="<?php echo url_for("/marketing/eventCalendar") ?>">

                <input type="hidden" name="act" value="calendar">
                <input type="hidden" id="events" name="events" value="">

                <table width="100%" border="0">
                    <tr>
                        <td colspan="2"><br>
                            <?php if ($sf_flash->has('successMsg')): ?>
                                <div class="ui-widget">
                                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                         class="ui-state-highlight ui-corner-all">
                                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                                      class="ui-icon ui-icon-info"></span>
                                            <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($sf_flash->has('errorMsg')): ?>
                                <div class="ui-widget">
                                    <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
                                         class="ui-state-error ui-corner-all">
                                        <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                                                      class="ui-icon ui-icon-alert"></span>
                                            <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><br>

                            <div id='calendar'></div>

                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            * Please save your changes before moving to different page.
                            <br><br>
                            <button type="button" id="btnSaveCalendar">Save</button>
                        </td>
                    </tr>
                </table>
            </form>

            <br>
            <hr>


            <form id="newForm" method="post" action="<?php echo url_for("/marketing/eventCalendar") ?>">

                <input type="hidden" id="act" name="act" value="new">
                <input type="hidden" id="event_id" name="event_id" value="">

                <h3>Create New Event</h3>

                * Click an item in calendar to edit event details.

                <table width="100%" border="0">
                    <tr>
                        <th class="caption">Event Title</th>
                        <td class="value">
                            <input type="text" id="event_title" name="event_title" size="80">
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Event Details</th>
                        <td class="value">
                            <textarea id="event_detail" name="event_detail" rows="3" cols="80"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">All Day</th>
                        <td class="value">
                            <label>
                                <input type="checkbox" id="all_day" name="all_day" value="Y">
                                &nbsp;* Time is not allowed for all day event.
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Date Start</th>
                        <td class="value">
                            <input type="text" id="date_start" name="date_start">
                        </td>
                    </tr>
                    <tr>
                        <th class="caption">Date End</th>
                        <td class="value">
                            <input type="text" id="date_end" name="date_end">
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit">Submit</button>&nbsp;&nbsp;
                            <button type="button" id="btnDelete" style="display: none;">Delete</button>&nbsp;&nbsp;
                            <button type="button" id="btnCancel" style="display: none;">Cancel</button>
                        </td>
                    </tr>
                </table>
            </form>

        </div>
    </div>
</div>