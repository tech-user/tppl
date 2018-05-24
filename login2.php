

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

                        mysqli_stmt_bind_result($stmt, $username, $hashed_password, $center); //$hashed_password

                        if(mysqli_stmt_fetch($stmt)){

                            if(password_verify($password, $hashed_password)){    // $hashed_password

                                /* Password is correct, so start a new session and

                                save the username to the session */

                                session_start();

                                $_SESSION['username'] = $username;

                                header("location: dashboard.php");

                            } else{

                                // Display an error message if password is not valid

                                $password_err = 'invalid Password.';

                            }

                        }

                    } else{

                        // Display an error message if username doesn't exist

                        $username_err = 'invalid username.';

                    }

                } else{

                  // Display an error message if center doesn't exist

                  $center_err = 'select correct center.';

                    //echo "Oops! Something went wrong. Please try again later.";

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
  <link rel="stylesheet" href="css/mystyle.css" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>
<body>

<div class="container">
  <div class="row">
      <div class="col-sm-12">
        <h1 style="color:#56B681; text-align:center; margin-top:5%;">Production Reporting</h1>
      </div>

  </div><!-- row end-->


  <div class="row" style="margin-top:20%;"><!-- row start here -->



<!-- left part start here -->

      <div class="col-sm-6" style="text-align:center; border-right:solid thin #56B681; height:350px; padding-top:120px;">
        <p><img src="images/tppl-logo.png" alt="tppl-logo" width="500" height="100" class="img-responsive"/></p>
      </div>

<!--left part end  here -->



<!-- right part start here -->

<div class="col-sm-6" align="center">

        <form class="form" style="width:60%;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

          <div class="form-group form-group-lg" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>

            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" style="border:2px solid #4A4A4A; background-color:#252F37; color:#56B681;" >
            <span class="help-block"><?php echo $username_err; ?></span>

          </div>

            <br>

          <div class="form-group form-group-lg" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
            <input type="password" class="form-control" name="password" placeholder="Enter Password" style="border:2px solid #4A4A4A; background-color:#252F37; color:#56B681;">
              <span class="help-block"><?php echo $password_err; ?></span>
          </div>

            <br>
            <div class="form-group form-group-lg">
              <select class="form-control form-group-lg" value="<?php echo $center; ?>" name="center" style="border:2px solid #4A4A4A; background-color:#252F37; color:#56B681;">
                  <option value="disabled">Select Center</option>
                  <option value="Hyderabad">Hyderabad</option>
                  <option value="Karimnagar">Karimnagar</option>
                  <option value="Nalgonda">Nalgonda</option>
                  <option value="Khammam<">Khammam</option>
                  <option value="Mahabubnagar">Mahabubnagar</option>
                  <option value="Warangal">Warangal</option>
                </select>
                <span class="help-block"><?php echo $center_err; ?></span>
              </div> <br>


              <div class="form-group form-group-lg">
              <button type="submit" class="btn btn-block btn-lg" style="background-color: #56B681; color:#ffff;"><span class="glyphicon glyphicon-log-in"></span> Login</button></div>

              <span style="color:#999999; font-size:16px;"><span class="glyphicon glyphicon-exclamation-sign" style="color:#56B681;"></span> Forgot Password?</span>&emsp;&emsp;&emsp;&emsp;&emsp;
              <input type="reset" value="Reset Fields" class="btn btn-link" style="color:#56B681">




      </form>


</div><!-- right part ende  here -->





  </div> <!-- row end here -->



  <!-- <button type="reset" class="btn btn-lg" style="background-color: #56B681; color:#ffff;"><span class="glyphicon glyphicon-repeat"></span> Reset</button>-->




</div><!-- container end -->

</body>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>


</html>
