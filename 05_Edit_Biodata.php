<?php
session_start();
include '05_Database.php';

// Check if biodata_id is set
if (!isset($_GET['biodata_id']) && !isset($_POST['biodata_id'])) {
    die('Biodata ID not provided.');
}

$biodata_id = isset($_POST['biodata_id']) ? $_POST['biodata_id'] : $_GET['biodata_id'];

// Handle form submission for editing biodata
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $full_name = $_POST['full_name'];
    $birth_name = $_POST['birth_name'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $birth_time = $_POST['birth_time'];
    $rashi = $_POST['rashi'];
    $mangal_dosh = $_POST['mangal_dosh'];
    $gotra = $_POST['gotra'];
    $mamkul = $_POST['mamkul'];
    $blood_type = $_POST['blood_type'];
    $marital_status = $_POST['marital_status'];
    $highest_education = $_POST['highest_education'];
    $additional_degree = $_POST['additional_degree'];
    $occupation = $_POST['occupation'];
    $annual_income = $_POST['annual_income'];
    $family_type = $_POST['family_type'];
    $father_name = $_POST['father_name'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_occupation = $_POST['mother_occupation'];
    $siblings = $_POST['siblings'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $complexion = $_POST['complexion'];
    $blood_type = $_POST['blood_type'];
    $physical_status = $_POST['physical_status'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE Biodata SET full_name=?, birth_name=?, birth_date=?, birth_place=?, birth_time=?, rashi=?, mangal_dosh=?, gotra=?, mamkul=?, blood_type=?, marital_status=?, highest_education=?, additional_degree=?, occupation=?, annual_income=?, family_type=?, father_name=?, father_occupation=?, mother_name=?, mother_occupation=?, siblings=?, height=?, weight=?, complexion=?, blood_type=?, physical_status=?, contact=?, location=? WHERE id=? AND user_id=?");

    // Bind parameters
    $user_id = $_SESSION['user_id']; // Get user ID from session
    $stmt->bind_param('ssssssssssssssssssssssssssssss', $full_name, $birth_name, $birth_date, $birth_place, $birth_time, $rashi, $mangal_dosh, $gotra, $mamkul, $blood_type, $marital_status, $highest_education, $additional_degree, $occupation, $annual_income, $family_type, $father_name, $father_occupation, $mother_name, $mother_occupation, $siblings, $height, $weight, $complexion, $blood_type, $physical_status, $contact, $location, $biodata_id, $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Biodata updated successfully.";
    } else {
        echo "Error updating biodata: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Fetch existing biodata for editing
if (isset($biodata_id)) {
    $stmt = $conn->prepare("SELECT * FROM Biodata WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $biodata_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $biodata = $result->fetch_assoc();
        // Populate form fields with existing biodata
    } else {
        echo "Biodata not found.";
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Biodata</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional custom styles -->
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background */
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Edit Biodata</h2>
        <form method="post" action="">
            <!-- Populate form fields with existing biodata -->
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo htmlspecialchars($biodata['full_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="birth_name">Birth Name:</label>
                <input type="text" id="birth_name" name="birth_name" class="form-control" value="<?php echo htmlspecialchars($biodata['birth_name']); ?>">
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date:</label>
                <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?php echo htmlspecialchars($biodata['birth_date']); ?>">
            </div>
            <div class="form-group">
                <label for="birth_place">Birth Place:</label>
                <input type="text" id="birth_place" name="birth_place" class="form-control" value="<?php echo htmlspecialchars($biodata['birth_place']); ?>">
            </div>
            <div class="form-group">
                <label for="birth_time">Birth Time:</label>
                <input type="time" id="birth_time" name="birth_time" class="form-control" value="<?php echo htmlspecialchars($biodata['birth_time']); ?>">
            </div>
            <div class="form-group">
                <label for="rashi">Rashi:</label>
                <input type="text" id="rashi" name="rashi" class="form-control" value="<?php echo htmlspecialchars($biodata['rashi']); ?>">
            </div>
            <div class="form-group">
                <label for="mangal_dosh">Mangal Dosh:</label>
                <input type="text" id="mangal_dosh" name="mangal_dosh" class="form-control" value="<?php echo htmlspecialchars($biodata['mangal_dosh']); ?>">
            </div>
            <div class="form-group">
                <label for="gotra">Gotra:</label>
                <input type="text" id="gotra" name="gotra" class="form-control" value="<?php echo htmlspecialchars($biodata['gotra']); ?>">
            </div>
            <div class="form-group">
                <label for="mamkul">Mamkul:</label>
                <input type="text" id="mamkul" name="mamkul" class="form-control" value="<?php echo htmlspecialchars($biodata['mamkul']); ?>">
            </div>
            <div class="form-group">
                <label for="blood_type">Blood Type:</label>
                <input type="text" id="blood_type" name="blood_type" class="form-control" value="<?php echo htmlspecialchars($biodata['blood_type']); ?>">
            </div>
            <div class="form-group">
                <label for="marital_status">Marital Status:</label>
                <input type="text" id="marital_status" name="marital_status" class="form-control" value="<?php echo htmlspecialchars($biodata['marital_status']); ?>">
            </div>
            <div class="form-group">
                <label for="highest_education">Highest Education:</label>
                <input type="text" id="highest_education" name="highest_education" class="form-control" value="<?php echo htmlspecialchars($biodata['highest_education']); ?>">
            </div>
            <div class="form-group">
                <label for="additional_degree">Additional Degree:</label>
                <input type="text" id="additional_degree" name="additional_degree" class="form-control" value="<?php echo htmlspecialchars($biodata['additional_degree']); ?>">
            </div>
            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" id="occupation" name="occupation" class="form-control" value="<?php echo htmlspecialchars($biodata['occupation']); ?>">
            </div>
            <div class="form-group">
                <label for="annual_income">Annual Income:</label>
                <input type="text" id="annual_income" name="annual_income" class="form-control" value="<?php echo htmlspecialchars($biodata['annual_income']); ?>">
            </div>
            <div class="form-group">
                <label for="family_type">Family Type:</label>
                <input type="text" id="family_type" name="family_type" class="form-control" value="<?php echo htmlspecialchars($biodata['family_type']); ?>">
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name:</label>
                <input type="text" id="father_name" name="father_name" class="form-control" value="<?php echo htmlspecialchars($biodata['father_name']); ?>">
            </div>
            <div class="form-group">
                <label for="father_occupation">Father's Occupation:</label>
                <input type="text" id="father_occupation" name="father_occupation" class="form-control" value="<?php echo htmlspecialchars($biodata['father_occupation']); ?>">
            </div>
            <div class="form-group">
                <label for="mother_name">Mother's Name:</label>
                <input type="text" id="mother_name" name="mother_name" class="form-control" value="<?php echo htmlspecialchars($biodata['mother_name']); ?>">
            </div>
            <div class="form-group">
                <label for="mother_occupation">Mother's Occupation:</label>
                <input type="text" id="mother_occupation" name="mother_occupation" class="form-control" value="<?php echo htmlspecialchars($biodata['mother_occupation']); ?>">
            </div>
            <div class="form-group">
                <label for="siblings">Siblings:</label>
                <input type="text" id="siblings" name="siblings" class="form-control" value="<?php echo htmlspecialchars($biodata['siblings']); ?>">
            </div>
            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" id="height" name="height" class="form-control" value="<?php echo htmlspecialchars($biodata['height']); ?>">
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight" class="form-control" value="<?php echo htmlspecialchars($biodata['weight']); ?>">
            </div>
            <div class="form-group">
                <label for="complexion">Complexion:</label>
                <input type="text" id="complexion" name="complexion" class="form-control" value="<?php echo htmlspecialchars($biodata['complexion']); ?>">
            </div>
            <div class="form-group">
                <label for="physical_status">Physical Status:</label>
                <input type="text" id="physical_status" name="physical_status" class="form-control" value="<?php echo htmlspecialchars($biodata['physical_status']); ?>">
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($biodata['contact']); ?>">
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" value="<?php echo htmlspecialchars($biodata['location']); ?>">
            </div>
            <input type="hidden" name="biodata_id" value="<?php echo htmlspecialchars($biodata_id); ?>">
            <button type="submit" name="update" class="btn btn-primary">Update Biodata</button>
        </form>
    </div>
</body>
</html>
