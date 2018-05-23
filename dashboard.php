

    <?php

    // Initialize the session

    session_start();



    // If session variable is not set it will redirect to login page

    if(!isset($_SESSION['username']) || empty($_SESSION['username'])){

      header("location: index.php");

      exit;

    }

    ?>



    <!DOCTYPE html>

    <html lang="en">

    <head>

        <meta charset="UTF-8">

        <title>Welcome</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

        <style type="text/css">

            body{ font: 14px sans-serif; text-align: center; }

        </style>

    </head>

    <body>

        <div class="page-header">

            <h1>Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b> <br>Welome to Php Server - login system.</h1>


            <!-- <h2> Center : <b><?php echo htmlspecialchars($_SESSION['center']); ?></b></h2> -->
            <!--should display center name-->


        </div>




        <p><a href="logout.php" class="btn btn-danger">Sign Out</a></p>




    </body>

    </html>
