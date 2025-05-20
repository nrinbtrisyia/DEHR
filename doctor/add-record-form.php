<div class="overlay">
    <div class="popup">
        <h2>Add New Record</h2>
        <a class="close" href="record.php">&times;</a>
        <div class="content">
            <form action="record.php?action=save-record" method="POST">
                <label for="patientID">Patient ID:</label>
                <input type="text" name="patientID" required><br>
                <label for="appointmentID">Appointment ID:</label>
                <input type="text" name="appointmentID" required><br>
                <label for="doctorID">Doctor ID:</label>
                <input type="text" name="doctorID" required><br>
                <label for="description">Description:</label>
                <textarea name="description" required></textarea><br>
                <label for="medicalPlan">Medical Plan:</label>
                <input type="text" name="medicalPlan" required><br>
                <label for="treatment">Treatment:</label>
                <input type="text" name="treatment" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</div>
