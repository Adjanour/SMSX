const scheduledTimeInput = document.getElementById('scheduledTime');
    const timeLabel = document.getElementById('time-label');

    scheduledTimeInput.addEventListener('change', function() {
        const selectedDateTime = new Date(scheduledTimeInput.value);
        const formattedDateTime = selectedDateTime.toLocaleString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
        });
        timeLabel.textContent = 'Message will be sent at: ' + formattedDateTime;
        console.log('Selected Date and Time:', selectedDateTime);
    });