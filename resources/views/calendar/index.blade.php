@extends('setup.master')
@section('content')
    <style>
        @media print {
            .fc-month-button {
                display: none;

            }

            .fc-agendaDay-button {
                display: none;

            }

            .fc-agendaWeek-button {
                display: none;

            }

            .fc-today-button {
                display: none;

            }

            .fc-next-button {
                display: none;
            }

            .fc-prev-button {
                display: none;

            }

        }
    </style>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}

    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Calendar -->
                                <div class="col-auto float-right ml-auto">
                                    <a href="#" class="btn add-btn printBtn-calendar"><i class="fa fa-print"></i>
                                        Print</a>
                                </div>
                                <div id="calendar"></div>
                                <!-- /Calendar -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /Page Header -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Calendar -->
                            <div id="calendar"></div>
                            <!-- /Calendar -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /Page Content -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Task Planner </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-calendar">
                        <div class="form-group">
                            <label class="col-form-label">Title:</label>
                            <input type="text" class="form-control " id="title">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Description:</label>
                            <input type="text" class="form-control" id="description">
                        </div>
                        <div class="form-group ">
                            <label class="col-form-label">Select priority:</label>
                            <select class=" form-control perioty" name="add_perioty">
                                <option value=" " disabled selected>Select Perority:</option>
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary savedata" id="saveBtn">Save</button>
                </div>
                </form>

            </div>
        </div>
    </div>





    <div class="modal fade" id="updateModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Task Planner </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data" id="my-form">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Title:</label>
                            <input type="text" name="title" class="form-control title">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-form-label">Description:</label>
                            <input type="text" name="decription" class="form-control decription">

                        </div>

                        <div class="form-group ">
                            <label class="col-form-label">Select Perority:</label>
                            <select class=" form-control  " name="up_cat_id">
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                            </select>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary updatedata" id="update">Send message</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <!-- /Add Event Modal -->

    <!-- Event Modal -->
    <div class="modal custom-modal fade" id="event-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-success submit-btn save-event">Create event</button>
                    <button type="button" class="btn btn-danger submit-btn delete-event"
                        data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Event Modal -->

    <!-- Add Category Modal-->
    <div class="modal custom-modal fade" id="add-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add a category</h4>
                </div>
                <div class="modal-body p-20">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="col-form-label">Category Name</label>
                                <input class="form-control" placeholder="Enter name" type="text"
                                    name="category-name">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Choose Category Color</label>
                                <select class="form-control" data-placeholder="Choose a color..." name="category-color">
                                    <option value="success">Success</option>
                                    <option value="danger">Danger</option>
                                    <option value="info">Info</option>
                                    <option value="pink">Pink</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="orange">Orange</option>
                                    <option value="brown">Brown</option>
                                    <option value="teal">Teal</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger save-category" data-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Category Modal-->

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: '/rgms/calender',
                eventRender: function(event, element, view) {
                    var date = new Date(); //this is your todays date

                    if (event.puriety == 'Low') {
                        $(element).css("backgroundColor", "#078CCD");
                        $(element).css("color", "white");
                        $(element).css("font-size", "15px");

                    }
                    if (event.puriety == 'High') {
                        $(element).css("backgroundColor", "#0B8043");
                        $(element).css("color", "white");
                        $(element).css("font-size", "15px");


                    }
                    if (event.puriety == 'Medium') {
                        $(element).css("backgroundColor", "#3F51B5");
                        $(element).css("color", "white");
                        $(element).css("font-size", "15px");


                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    // var title = prompt('Event Title:');
                    $('#exampleModal').modal('toggle');

                    $('#saveBtn').click(function() {
                        // alert('asda');

                        let title = $('#title').val();

                        let des = $('#description').val();
                        let puriety = $('select[name="add_perioty"]').val();
                        // alert(puriety);
                        // let puriety = $('.perioty option:selected').text();
                        // date_default_timezone_set("Asia/Karachi");
                        //   dd(date('h:i:s a'));
                        var start_date = moment(start).format('YYYY-MM-DD');
                        var end_date = moment(end).format('YYYY-MM-DD');
                        // alert(title );
                        $.ajax({
                            url: "/rgms/full-calender/action",
                            dataType: 'json',
                            type: "post",
                            data: {
                                title: title,
                                des: des,
                                start: start_date,
                                end: end_date,
                                puriety: puriety,
                                type: 'add'
                            },
                            success: function(response) {

                                if (response.errors) {
                                    displayerror("All Feilds Are Rquired");
                                    calendar.fullCalendar('refetchEvents');

                                }
                                if (response.success) {
                                    $('#exampleModal').modal('hide')
                                    $('#form-calendar').trigger("reset");
                                    calendar.fullCalendar('refetchEvents');
                                    displayMessage("Add Event Successfully");
                                }
                            }
                        });

                    });

                },
                editable: true,
                eventResize: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/rgms/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            if (response.errors) {
                                displayMessage("errors");
                                calendar.fullCalendar('refetchEvents');

                            } else {
                                calendar.fullCalendar('refetchEvents');
                                displayMessage("Event drop Successfully");
                            }
                        }
                    })
                },
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: "/rgms/full-calender/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function(response) {
                            calendar.fullCalendar('refetchEvents');
                            displayMessage("Event drop Successfully");
                        }
                    })
                },

                eventClick: function(event) {
                    $('#updateModel').modal('toggle')

                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var newnn = event.title;
                    var des = event.decription;

                    var pur = event.puriety;
                    // console.log(puriety);

                    let purietysds = $('select[name="up_cat_id"]').val(pur);
                    var t = $('.title').val(newnn);
                    var desss = $('.decription').val(des);
                    var descnew = desss.val();
                    var newt = t.val();
                    var newp = purietysds.val();

                    // alert(newt);
                    // alert(newp);
                    // alert(descnew);


                    // alert(pur);
                    //  var t= $('.title').val(newnn);

                    var id = event.id;
                    // $('select[name="up_cat_id"]')


                    // $('select[name="up_cat_id"]')

                    $('.updatedata').click(function() {
                        var puredescription = $('.decription').val();
                        var title_latest = $('.title').val();
                        var purietyssds = $('select[name="up_cat_id"]').val();

                        // alert(wasie_id);
                        $.ajax({
                            url: "/rgms/full-calender/action",
                            type: "POST",
                            data: {
                                title: title_latest,
                                des: puredescription,
                                purety: purietyssds,
                                id: id,
                                type: 'latest_update'
                            },
                            success: function(response) {
                                $('#updateModel').modal('hide');

                                calendar.fullCalendar('refetchEvents');
                                displayMessage("Event drop Successfully");
                            }
                        })
                    });


                }
            });
            $("#exampleModal").on("hidden.bs.modal", function() {
                $('#saveBtn').unbind();
            });

            $("#updateModel").on("hidden.bs.modal", function() {
                $('#update').unbind();
            });

            $('.printBtn-calendar').on('click', function() {

                $.print("#calendar");
            });
        });

        function displayMessage(message) {

            toastr.options = {
  "debug": false,
  "onclick": null,
  "fadeIn": 100,
  "fadeOut": 1000,
  "timeOut": 1000,
  "extendedTimeOut": 1000
}
            toastr.success(message);
        }

        function displayerror(message) {
            toastr.options = {
  "debug": false,
  "onclick": null,
  "fadeIn": 100,
  "fadeOut": 1000,
  "timeOut": 1000,
  "extendedTimeOut": 1000
}
toastr.error(message);

        }
    </script>
@endsection
