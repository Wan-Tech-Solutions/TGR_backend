@extends('admin.layouts.admin_master')

<!-- FullCalendar CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css" rel="stylesheet" />

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<!-- ApexCharts CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.32.0/dist/apexcharts.css">

<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Calendar</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Calendar</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-n5">
                            <img src="{{ asset('backend/images/logos/dark-logo.png') }}" class="dark-logo" alt="Logo-Dark" style="height: 70px; width:110px; padding-bottom:20px" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body calender-sidebar app-calendar">
                <div id="calendar"></div>
            </div>
        </div>

        <!-- BEGIN MODAL -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Add / Edit Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <label class="form-label">Event Title</label>
                                    <input id="event-title" type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-12 mt-6">
                                <div>
                                    <label class="form-label">Event Color</label>
                                </div>
                                <div class="d-flex">
                                    <div class="n-chk">
                                        <div class="form-check form-check-primary form-check-inline">
                                            <input class="form-check-input" type="radio" name="event-level" value="Danger" id="modalDanger" />
                                            <label class="form-check-label" for="modalDanger">Danger</label>
                                        </div>
                                    </div>
                                    <div class="n-chk">
                                        <div class="form-check form-check-warning form-check-inline">
                                            <input class="form-check-input" type="radio" name="event-level" value="Success" id="modalSuccess" />
                                            <label class="form-check-label" for="modalSuccess">Success</label>
                                        </div>
                                    </div>
                                    <div class="n-chk">
                                        <div class="form-check form-check-success form-check-inline">
                                            <input class="form-check-input" type="radio" name="event-level" value="Primary" id="modalPrimary" />
                                            <label class="form-check-label" for="modalPrimary">Primary</label>
                                        </div>
                                    </div>
                                    <div class="n-chk">
                                        <div class="form-check form-check-danger form-check-inline">
                                            <input class="form-check-input" type="radio" name="event-level" value="Warning" id="modalWarning" />
                                            <label class="form-check-label" for="modalWarning">Warning</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-6">
                                <div>
                                    <label class="form-label">Enter Start Date</label>
                                    <input id="event-start-date" type="date" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-12 mt-6">
                                <div>
                                    <label class="form-label">Enter End Date</label>
                                    <input id="event-end-date" type="date" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success btn-update-event" data-fc-event-public-id="">Update changes</button>
                        <button type="button" class="btn btn-primary btn-add-event">Add Event</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MODAL -->
    </div>
</div>

<!-- jQuery (needed by Bootstrap and DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<!-- ApexCharts JS -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.32.0/dist/apexcharts.min.js"></script>

<script>
    let calendar;
    let events = []; // Store events

    document.addEventListener('DOMContentLoaded', function() {
        // FullCalendar initialization
        var calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            dateClick: function(info) {
                // Open modal to add event
                $('#eventModal').modal('show');
                $('#event-start-date').val(info.dateStr);
                $('#event-end-date').val(info.dateStr);
            },
            eventClick: function(info) {
                // Open modal to edit event
                $('#eventModal').modal('show');
                $('#event-title').val(info.event.title);
                $('#event-start-date').val(info.event.start.toISOString().split('T')[0]);
                $('#event-end-date').val(info.event.end ? info.event.end.toISOString().split('T')[0] : '');
                $('.btn-update-event').data('fc-event-public-id', info.event.id);
            }
        });
        calendar.render();

        // Add event handler
        $('.btn-add-event').on('click', function() {
            const title = $('#event-title').val();
            const startDate = $('#event-start-date').val();
            const endDate = $('#event-end-date').val();
            const color = $('input[name="event-level"]:checked').val();

            if (title && startDate) {
                const newEvent = {
                    id: Date.now(), // Unique ID for the event
                    title: title,
                    start: startDate,
                    end: endDate,
                    color: color
                };
                events.push(newEvent);
                calendar.addEvent(newEvent);
                $('#eventModal').modal('hide');
                $('#event-title').val('');
                $('#event-start-date').val('');
                $('#event-end-date').val('');
            }
        });

        // Update event handler
        $('.btn-update-event').on('click', function() {
            const eventId = $(this).data('fc-event-public-id');
            const title = $('#event-title').val();
            const startDate = $('#event-start-date').val();
            const endDate = $('#event-end-date').val();
            const eventToUpdate = events.find(event => event.id === eventId);

            if (eventToUpdate) {
                eventToUpdate.title = title;
                eventToUpdate.start = startDate;
                eventToUpdate.end = endDate;
                calendar.updateEvent(eventToUpdate);
                $('#eventModal').modal('hide');
            }
        });
    });

    // Example of initializing DataTables (if you need it)
    $(document).ready(function() {
        $('#example').DataTable(); // Replace #example with your table ID
    });

    // Example of initializing an ApexChart (if you need it)
    var options = {
        series: [{
            name: 'Sales',
            data: [10, 20, 30, 40]
        }],
        chart: {
            type: 'line',
            height: 350
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr']
        }
    };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

