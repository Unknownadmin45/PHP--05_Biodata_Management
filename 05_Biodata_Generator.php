<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: 05_Login.php");
    exit();
}

include '05_Database.php';

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generate_pdf'])) {
    require('fpdf186/fpdf.php');
    $biodata_id = $_POST['biodata_id'];

    $sql = "SELECT * FROM Biodata WHERE id=$biodata_id AND user_id=$user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        class PDF extends FPDF
        {
            function Header()
            {
                $this->SetFont('Times', 'B', 14);
                $this->Image('05_Background.jpg', 0, 0, 210, 297); // Set image as full-page background
                $this->Image('05_Logo.png', 95, 10, 20, 20); // Center the logo horizontally (95) and place it at 10 units from the top with a width of 20 units
                $this->Ln(18); // Move to the next line after the logo
                $this->SetTextColor(184, 134, 11); // Set text color to dark golden (RGB: 184, 134, 11)
                $this->Cell(0, 10, '||Shree Ganeshaya Namaha||', 0, 1, 'C');
                $this->Ln(10);
            }

        }

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Times', 'B', 18); // Change font to Times New Roman
        $pdf->SetTextColor(153, 51, 0); // Set text color to blend of dark red and dark gold
        $pdf->Cell(0, 10, '*Biodata*', 0, 1, 'C');
        $pdf->Ln(8);
        
                // Define left padding
        $left_padding = 17.5; // Adjust the value as needed
        $pdf->SetFont('Times', 'B', 16); // Change font to Times New Roman
        $pdf->SetTextColor(139, 0, 0); // Set text color to dark red (RGB: 139, 0, 0)
                // Personal details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(0, 10, 'Personal Details', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Full Name:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['full_name'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Birth Name:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['birth_name'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Birth Date:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['birth_date'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Birth Place:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['birth_place'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Birth Time:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['birth_time'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Rashi/Zodiac Sign:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['rashi'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Mangal Dosh:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['mangal_dosh'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Marital Status:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['marital_status'], 0, 1, 'L');

        $pdf->Ln(10); // Add a blank line

        // Family details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(0, 10, 'Family Details', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Gotra:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['gotra'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Mamkul:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['mamkul'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Family Type:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['family_type'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Father\'s Name:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['father_name'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Father\'s Occupation:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['father_occupation'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Mother\'s Name:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['mother_name'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Mother\'s Occupation:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['mother_occupation'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Siblings:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['siblings'], 0, 1, 'L');

        $pdf->Ln(10); // Add a blank line
        $pdf->Ln(10); // Add a blank line

        // Education and occupation
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(0, 10, 'Education and Occupation', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Highest Education:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['highest_education'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Additional Degree:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['additional_degree'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Occupation:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['occupation'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Annual Income:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['annual_income'], 0, 1, 'L');

        $pdf->Ln(10); // Add a blank line

        // Physical attributes
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(0, 10, 'Physical Attributes', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Height:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['height'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Weight:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['weight'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Complexion:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['complexion'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Blood Type:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['blood_type'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Physical Status:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['physical_status'], 0, 1, 'L');

        $pdf->Ln(10); // Add a blank line

        // Contact and location
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(0, 10, 'Contact and Location', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Contact:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['contact'], 0, 1, 'L');
        $pdf->SetX($left_padding);
        $pdf->Cell(50, 10, 'Location:', 0, 0, 'L');
        $pdf->Cell(0, 10, $row['location'], 0, 1, 'L');


        $pdf->Output();
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $full_name = $_POST['full_name'];
    $birth_name = $_POST['birth_name'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $birth_time = $_POST['birth_time'];
    $rashi = $_POST['rashi'];
    $mangal_dosh = $_POST['mangal_dosh'];
    $marital_status = $_POST['marital_status'];
    $gotra = $_POST['gotra'];
    $mamkul = $_POST['mamkul'];
    $family_type = $_POST['family_type'];
    $father_name = $_POST['father_name'];
    $father_occupation = $_POST['father_occupation'];
    $mother_name = $_POST['mother_name'];
    $mother_occupation = $_POST['mother_occupation'];
    $siblings = $_POST['siblings'];
    $highest_education = $_POST['highest_education'];
    $additional_degree = $_POST['additional_degree'];
    $occupation = $_POST['occupation'];
    $annual_income = $_POST['annual_income'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $complexion = $_POST['complexion'];
    $blood_type = $_POST['blood_type'];
    $physical_status = $_POST['physical_status'];
    $contact = $_POST['contact'];
    $location = $_POST['location'];

    $sql = "INSERT INTO Biodata (user_id, full_name, birth_name, birth_date, birth_place, birth_time, rashi, mangal_dosh, marital_status, gotra, mamkul, family_type, father_name, father_occupation, mother_name, mother_occupation, siblings, highest_education, additional_degree, occupation, annual_income, height, weight, complexion, blood_type, physical_status, contact, location) 
    VALUES ('$user_id', '$full_name', '$birth_name', '$birth_date', '$birth_place', '$birth_time', '$rashi', '$mangal_dosh', '$marital_status', '$gotra', '$mamkul', '$family_type', '$father_name', '$father_occupation', '$mother_name', '$mother_occupation', '$siblings', '$highest_education', '$additional_degree', '$occupation', '$annual_income', '$height', '$weight', '$complexion', '$blood_type', '$physical_status', '$contact', '$location')";

    if ($conn->query($sql) === TRUE) {
        echo "New biodata created successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

        //Delete functionality

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $biodata_id = $_POST['biodata_id'];
    $sql = "DELETE FROM Biodata WHERE id=$biodata_id AND user_id=$user_id";
    if ($conn->query($sql) === TRUE) {
        echo "Biodata deleted successfully.";
    } else {
        echo "Error deleting biodata: " . $conn->error;
    }
}

$sql = "SELECT * FROM Biodata WHERE user_id=$user_id";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Biodata Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional custom styles -->
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background */
        }
        .container {
            margin-top: 20px;
        }
        .biodata-card {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }
        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="my-4">Welcome to Biodata Management</h2>
        <h3>Create New Biodata</h3>
        <form method="post" action="" class="form">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="birth_name">Birth Name:</label>
                <input type="text" id="birth_name" name="birth_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date:</label>
                <input type="date" id="birth_date" name="birth_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="birth_place">Birth Place:</label>
                <input type="text" id="birth_place" name="birth_place" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="birth_time">Birth Time:</label>
                <input type="time" id="birth_time" name="birth_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rashi">Rashi/Zodiac Sign:</label>
                <input type="text" id="rashi" name="rashi" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mangal_dosh">Mangal Dosh:</label>
                <input type="text" id="mangal_dosh" name="mangal_dosh" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="marital_status">Marital Status:</label>
                <input type="text" id="marital_status" name="marital_status" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="gotra">Gotra:</label>
                <input type="text" id="gotra" name="gotra" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mamkul">Mamkul:</label>
                <input type="text" id="mamkul" name="mamkul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="family_type">Family Type:</label>
                <input type="text" id="family_type" name="family_type" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name:</label>
                <input type="text" id="father_name" name="father_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="father_occupation">Father's Occupation:</label>
                <input type="text" id="father_occupation" name="father_occupation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mother_name">Mother's Name:</label>
                <input type="text" id="mother_name" name="mother_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="mother_occupation">Mother's Occupation:</label>
                <input type="text" id="mother_occupation" name="mother_occupation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="siblings">Siblings:</label>
                <textarea id="siblings" name="siblings" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="highest_education">Highest Education:</label>
                <input type="text" id="highest_education" name="highest_education" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="additional_degree">Additional Degree:</label>
                <input type="text" id="additional_degree" name="additional_degree" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" id="occupation" name="occupation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="annual_income">Annual Income:</label>
                <input type="text" id="annual_income" name="annual_income" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="height">Height:</label>
                <input type="text" id="height" name="height" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" id="weight" name="weight" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="complexion">Complexion:</label>
                <input type="text" id="complexion" name="complexion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="blood_type">Blood Type:</label>
                <input type="text" id="blood_type" name="blood_type" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="physical_status">Physical Status:</label>
                <input type="text" id="physical_status" name="physical_status" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" id="location" name="location" class="form-control" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Create</button>
        </form>

        <h3 class="my-4">Your Biodatas</h3>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="biodata-card">
                    <h4><?php echo htmlspecialchars($row["full_name"]); ?></h4>
                    <p><strong>Birth Name:</strong> <?php echo htmlspecialchars($row["birth_name"]); ?></p>
                    <p><strong>Birth Date:</strong> <?php echo htmlspecialchars($row["birth_date"]); ?></p>
                    <p><strong>Birth Place:</strong> <?php echo htmlspecialchars($row["birth_place"]); ?></p>
                    <p><strong>Birth Time:</strong> <?php echo htmlspecialchars($row["birth_time"]); ?></p>
                    <p><strong>Rashi/Zodiac Sign:</strong> <?php echo htmlspecialchars($row["rashi"]); ?></p>
                    <p><strong>Mangal Dosh:</strong> <?php echo htmlspecialchars($row["mangal_dosh"]); ?></p>
                    <p><strong>Marital Status:</strong> <?php echo htmlspecialchars($row["marital_status"]); ?></p>
                    <p><strong>Gotra:</strong> <?php echo htmlspecialchars($row["gotra"]); ?></p>
                    <p><strong>Mamkul:</strong> <?php echo htmlspecialchars($row["mamkul"]); ?></p>
                    <p><strong>Family Type:</strong> <?php echo htmlspecialchars($row["family_type"]); ?></p>
                    <p><strong>Father's Name:</strong> <?php echo htmlspecialchars($row["father_name"]); ?></p>
                    <p><strong>Father's Occupation:</strong> <?php echo htmlspecialchars($row["father_occupation"]); ?></p>
                    <p><strong>Mother's Name:</strong> <?php echo htmlspecialchars($row["mother_name"]); ?></p>
                    <p><strong>Mother's Occupation:</strong> <?php echo htmlspecialchars($row["mother_occupation"]); ?></p>
                    <p><strong>Siblings:</strong> <?php echo htmlspecialchars($row["siblings"]); ?></p>
                    <p><strong>Highest Education:</strong> <?php echo htmlspecialchars($row["highest_education"]); ?></p>
                    <p><strong>Additional Degree:</strong> <?php echo htmlspecialchars($row["additional_degree"]); ?></p>
                    <p><strong>Occupation:</strong> <?php echo htmlspecialchars($row["occupation"]); ?></p>
                    <p><strong>Annual Income:</strong> <?php echo htmlspecialchars($row["annual_income"]); ?></p>
                    <p><strong>Height:</strong> <?php echo htmlspecialchars($row["height"]); ?></p>
                    <p><strong>Weight:</strong> <?php echo htmlspecialchars($row["weight"]); ?></p>
                    <p><strong>Complexion:</strong> <?php echo htmlspecialchars($row["complexion"]); ?></p>
                    <p><strong>Blood Type:</strong> <?php echo htmlspecialchars($row["blood_type"]); ?></p>
                    <p><strong>Physical Status:</strong> <?php echo htmlspecialchars($row["physical_status"]); ?></p>
                    <p><strong>Contact:</strong> <?php echo htmlspecialchars($row["contact"]); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row["location"]); ?></p>
                    
                    <form method='post' action='' class="mt-2">
                        <input type='hidden' name='biodata_id' value='<?php echo $row["id"]; ?>'>
                        <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                    </form>
                    <form method='post' action='05_Edit_Biodata.php' class="mt-2">
                        <input type='hidden' name='biodata_id' value='<?php echo $row["id"]; ?>'>
                        <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                    </form>
                    <form method='post' action='' class="mt-2">
                        <input type='hidden' name='biodata_id' value='<?php echo $row["id"]; ?>'>
                        <button type='submit' name='generate_pdf' class='btn btn-info'>Generate PDF</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No biodatas found.</p>";
        }
        ?>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
