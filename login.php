

    <?php

    // Include config file

    require_once 'config.php'; //database connection string file



    // Define variables and initialize with empty values

    $username = $password = $center = "";

    $username_err = $password_err = $center_err = "";



    // Processing form data when form is submitted

    if($_SERVER["REQUEST_METHOD"] == "POST"){



        // Check if username is empty

        if(empty(trim($_POST["username"]))){

            $username_err = 'Please enter username.';

        } else{

            $username = trim($_POST["username"]);

        }



        // Check if password is empty

        if(empty(trim($_POST['password']))){

            $password_err = 'Please enter your password.';

        } else{

            $password = trim($_POST['password']);

        }

        // Check if center is empty

        if(empty(trim($_POST['center']))){

            $center_err = 'Please Select your Center.';

        } else{

            $center = trim($_POST['center']);

        }


        // Validate credentials

        if(empty($username_err) && empty($password_err) && empty($center_err)){

            // Prepare a select statement

            $sql = "SELECT username, password, center FROM users WHERE username = ?"; //need center also



            if($stmt = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters

                mysqli_stmt_bind_param($stmt, "s", $param_username);



                // Set parameters

                $param_username = $username;




                // Attempt to execute the prepared statement

                if(mysqli_stmt_execute($stmt)){

                    // Store result

                    mysqli_stmt_store_result($stmt);



                    // Check if username exists, if yes then verify password

                    if(mysqli_stmt_num_rows($stmt) == 1){

                        // Bind result variables

                        mysqli_stmt_bind_result($stmt, $username, $hashed_password, $center);

                        if(mysqli_stmt_fetch($stmt)){

                            if(password_verify($password, $hashed_password)){

                                /* Password is correct, so start a new session and

                                save the username to the session */

                                session_start();

                                $_SESSION['username'] = $username;

                                header("location: dashboard.php");

                            } else{

                                // Display an error message if password is not valid

                                $password_err = 'The password you entered was not valid.';

                            }

                        }

                    } else{

                        // Display an error message if username doesn't exist

                        $username_err = 'No account found with that username.';

                    }

                } else{

                    echo "Oops! Something went wrong. Please try again later.";

                }

            }



            // Close statement

            mysqli_stmt_close($stmt);

        }



        // Close connection

        mysqli_close($link);

    }

    ?>

    <!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <style type="text/css">

        body{ font: 14px sans-serif; }

        .wrapper{ width: 350px; padding: 20px; }

    </style>

</head>

<body>

    <div class="wrapper">

        <h2>Login</h2>

        <p>Please fill in your credentials to login.</p>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                <label>Username</label>

                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">

                <span class="help-block"><?php echo $username_err; ?></span>

            </div>

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                <label>Password</label>

                <input type="password" name="password" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>

            </div>


            <div class="form-group">
            <label for="center">Select Center</label>
              <select class="form-control" name="center" value="<?php echo $center; ?>">
                  <option></option>
                  <option>Hyderabad</option>
                  <option>Karimnagar</option>
                  <option>Nalgonda</option>
                  <option>Khammam</option>
                  <option>Mahabubnagar</option>
                  <option>Warangal</option>
                </select>
                <span class="help-block"><?php echo $center_err; ?></span>
            </div>

            <div class="form-group">

                <input type="submit" class="btn btn-primary" value="Login">

            </div>

            <span class="data-toggle" title="Contact Administrator">Forgot Password?</span>


            <p>Register <a href='register.php'>Here</a></p>

        </form>

    </div>

</body>

</html>
