<?php
session_start();
 // Include config file
require_once "config.php"; 

//define variables
 $FirstName = $LastName = $email = $password = $password2 = "";
$FirstName_err = $LastName_err = $email = $password_err = $password2_err="";
  
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Validate firstname

  if(empty(trim($_POST["FirstName"]))){
   $FirstName_err = "Please enter a FirstName.";
} else{
   // Prepare a select statement
   $sql = "SELECT id FROM users WHERE FirstName = $FirstName";
   
 if($stmt = mysqli_prepare($link, $sql)){
       // Bind variables to the prepared statement as parameters
       mysqli_stmt_bind_param($stmt, "s", $param_FirstName);
       
       // Set parameters
       $param_FirstName = trim($_POST["FirstName"]);
 
       // Attempt to execute the prepared statement
       if(mysqli_stmt_execute($stmt)){
           /* store result */
           mysqli_stmt_store_result($stmt);
       }
      }
    }
}

   
  

  if($_SERVER["REQUEST_METHOD"] == "POST"){
  // Validate lastname
   if(empty(trim($_POST["LastName"]))){
       $LastName_err = "Please enter LastName.";
   } else{
       // Prepare a select statement
       $sql = "SELECT id FROM users WHERE LastName = $LastName";
   
       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "s", $param_LastName);
           
           // Set parameters
           $param_LastName = trim($_POST["LastName"]);
       
           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               /* store result */
               mysqli_stmt_store_result($stmt);
           }   
       }
    }
}
    
          
          if($_SERVER["REQUEST_METHOD"] == "POST"){
     // Validate email
     if(empty(trim($_POST["email"]))){
       $email_err = "Please enter an email.";
   } else{
       // Prepare a select statement
       $sql = "SELECT id FROM users WHERE email = $email";
    
       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "s", $param_email);
           
           // Set parameters
           $param_email = trim($_POST["email"]);
       
           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               /* store result */
               mysqli_stmt_store_result($stmt);
           
               if(mysqli_stmt_num_rows($stmt) == 1){
                   $email_err = "This email has  already been used.";
               } else{
                   $username = trim($_POST["email"]);
               }
              }else{
                echo "oops! something went wrong. please try again later";
              }
            }
        }

         if($_SERVER["REQUEST_METHOD"] == "POST"){
   // Validate password
   if(empty(trim($_POST["password"]))){
       $password_err = "Please enter a password.";     
   }
    elseif(strlen(trim($_POST["password"])) < 6){
       $password_err = "Password must have atleast 6 characters.";
   } else{
       $password = trim($_POST["password"]);
   }
}
        
    
   
   // Validate confirm password
   if(empty(trim($_POST["password2"])))
   {
       $password2_err = "Please confirm password.";     
   } else{
       $password2 = trim($_POST["password2"]);
   }
       if(empty($password_err) && ($password != $password2)){
           $password2_err = "Password did not match.";
          }
      
   

   // Check input errors before inserting in database
   if(empty($FirstName_err) && empty($LastName_err) && empty($email_err) && empty($password_err) && empty($password2_err)){
       // Prepare an insert statement
       $sql = "INSERT INTO users (FirstName, LastName, email, password) VALUES ($FirstName, $LastName, $email, $password)";
   }
       if($stmt = mysqli_prepare($link, $sql)){
           // Bind variables to the prepared statement as parameters
           mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
           
           // Set parameters
           $param_email = $email;
           $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
       
           // Attempt to execute the prepared statement
           if(mysqli_stmt_execute($stmt)){
               // Redirect to login page
               header("location: index.php");
           } else{
               echo "Something went wrong. Please try again later.";
           }
          

       // Close statement
       mysqli_stmt_close($stmt);
           // Close connection
   mysqli_close($link);
          }
        }
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
    <title>Sign up</title>
  </head>
  <body>
   <div class="container">
       <div class="col-md-8 col-sm-10 col-lg-6 m-5" id="form-container">
           <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group">
             <span><h2>Sign Up</h2></span>
             <div class="row"> 
              
                 <div class="col-lg-6 <?php echo (!empty($FirstName_err)) ? 'has-error' : ''; ?>">
               <input  type="text" name="FirstName"  class="form-control my-2 p-2" placeholder="First Name" autofocus required> 
               </div>
               <div class="col-lg-6 <?php echo (!empty($LastName_err)) ? 'has-error' : ''; ?>">
               <input  type="text" name="LastName" class="form-control my-2 p-2" placeholder="Last Name" required>
               </div>
               </div>
               <input type="Email" name="email" class="form-control my-2 p-2.5" placeholder="Email Address" required>
               <div class="row <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                   <div class="col-lg-6 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                     <input  type="password" name="password" class="form-control my-2 " placeholder="Password" required>
                     </div>
                 <div class="col-lg-6 <?php echo (!empty($password2_err)) ? 'has-error' : ''; ?>">
               <input  type="password" name="password2" class="form-control my-2 " placeholder="Confirm Password" required>
               </div>
               </div>
               <input  type="submit" class="btn color-white text-align-center font-weight-bold form-control my-2" value="submit">
               <span class="text-align-center"> <p>Already a member? <a href="index.php" class="text-decoration-none">Login</a> </p> </span>
            
           </form>
       </div>
       
   </div>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>