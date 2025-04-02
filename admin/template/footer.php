document.querySelector('.full-width-container').appendChild(notificationsSection);
            notificationsSection.style.display = 'none';


            document.querySelector('.full-width-container').appendChild(gradesSection);
            gradesSection.style.display = 'none';


            gradesButton.addEventListener('click', function() {

                scheduleSection.style.display = 'none';
                notificationsSection.style.display = 'none';
                mainGrid.style.display = 'none';

                gradesSection.style.display = 'block';


                gradesButton.style.backgroundColor = '#8BC34A';
                notificationsButton.style.backgroundColor = '#B0E4C4';
            });

            notificationsButton.addEventListener('click', function() {

                scheduleSection.style.display = 'none';
                gradesSection.style.display = 'none';
                mainGrid.style.display = 'none';


                notificationsSection.style.display = 'block';

                notificationsButton.style.backgroundColor = '#8BC34A';
                gradesButton.style.backgroundColor = '#B0E4C4';
            });


            const dashboardButton = document.querySelector('.sidebar-btn:nth-child(1)');
            dashboardButton.addEventListener('click', function() {

                scheduleSection.style.display = 'block';
                mainGrid.style.display = 'grid';


                notificationsSection.style.display = 'none';
                gradesSection.style.display = 'none';


                notificationsButton.style.backgroundColor = '#B0E4C4';
                gradesButton.style.backgroundColor = '#B0E4C4';
                dashboardButton.style.backgroundColor = '#8BC34A';
            });


            dashboardButton.style.backgroundColor = '#8BC34A';
        });
    </script>

</body>

</html>