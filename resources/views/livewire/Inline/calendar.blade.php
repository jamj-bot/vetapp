<div>
    <div id="calendar-container" wire:ignore>
        <div id="calendar"></div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>

<script>
      document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar')
        const calendar = new FullCalendar.Calendar(calendarEl, {
        //initialView: 'timeGridWeek', //listWeek  timeGridWeek dayGridMonth
        initialView: 'timeGridFourDay',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'timeGridDay,timeGridFourDay,timeGridWeek,dayGridMonth'
        },
        nowIndicator: true,
        allDaySlot: false,
        slotEventOverlap: false ,
        eventMinHeight: 20,
        eventMaxStack: 1,
        slotMinTime: '09:00:00',
        slotMaxTime: '18:00:00',
        slotDuration: '00:10:00',
        hiddenDays: [0],
        views: {
            timeGridFourDay: {
                type: 'timeGrid',
                duration: { days: 4 },
                buttonText: '4 day'
            }
        },
        //eventColor: 'green',
        events: {!! json_encode($this->events) !!}
        //events: 'https://fullcalendar.io/api/demo-feeds/events.json'
        })
        calendar.render()
      })

</script>