<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intern Task 1</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        .table-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <!-- Form Section -->
        <div class="form-container">
            <h2 class="text-center mb-4">Contact Form</h2>
            
            <form action="submit.php" method="post" id="contactForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Full name</label>
                    <input type="text" 
                           class="form-control" 
                           id="username" 
                           name="username" 
                           placeholder="Enter your name">
                    <span class="error" id="username-error"></span>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           placeholder="Enter your email">
                    <span class="error" id="email-error"></span>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" 
                           class="form-control" 
                           id="phone" 
                           name="phone" 
                           placeholder="98/97XXXXXXXX">
                    <span class="error" id="phone-error"></span>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" 
                           class="form-control" 
                           id="subject" 
                           name="subject" 
                           placeholder="Enter subject">
                    <span class="error" id="subject-error"></span>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" 
                              id="message" 
                              name="message" 
                              rows="4" 
                              placeholder="Enter your message"></textarea>
                    <span class="error" id="message-error"></span>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <div id="successMessage" 
                 class="alert alert-success mt-3" 
                 style="display: none;">
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <h3 class="text-center mb-4">Submitted Entries</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Submitted At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config.php';
                        
                        $sql = "SELECT * FROM users ORDER BY created_at DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['username'] . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . $row['subject'] . "</td>";
                                echo "<td>" . $row['message'] . "</td>";
                                echo "<td>" . $row['created_at'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No entries found</td></tr>";
                        }
                        
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>