<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FullCalendar in CodeIgniter 4</title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div id="calendar"></div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js"></script>
    
    <script>
        $(document).ready(function () {
            const calendarEl = document.getElementById('calendar');
 
            // Initialize FullCalendar
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
 
                // Load events from the server or use static events for testing
                events: [
                    {
                        title: 'Event 1',
                        start: '2023-10-01'
                    },
                    {
                        title: 'Event 2',
                        start: '2023-10-05',
                        end: '2023-10-07'
                    }
                ],
 
                // Add event
                select: function (info) {
                    const title = prompt('Título del evento:');
                    if (title) {
                        calendar.addEvent({
                            title: title,
                            start: info.startStr,
                            end: info.endStr,
                            allDay: info.allDay
                        });
                    }
                },
 
                // Delete event
                eventClick: function (info) {
                    if (confirm('¿Deseas eliminar este evento?')) {
                        info.event.remove();
                    }
                }
            });
 
            calendar.render();
        });
    </script>
</body>
</html>