
    // Function to format the date and time
    function formatDateTime(dateTime) {
        // Convert the date and time to a string
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
            };
            
            const formattedDate = dateTime.toLocaleDateString('en-US', options);
            
            // Remove the "at" from the formatted date
            return formattedDate.replace(' at', ' ');
    }

    // Function to update the displayed date and time
    function updateDateTime() {
        const currentDateTime = new Date();
        const formattedDateTime = formatDateTime(currentDateTime);

        const currentDateTimeElement = document.getElementById('currentDateTime');
        currentDateTimeElement.textContent = ` ${formattedDateTime}`;
    }

    // Call the updateDateTime function initially to display the current date and time
    updateDateTime();

    // Update the displayed date and time every second
    setInterval(updateDateTime, 1000);

