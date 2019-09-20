<?php
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
   $sql = "SELECT id FROM users WHERE FirstName = ?";
   
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
  
   // Close statement
   mysqli_stmt_close($stmt);
  }

   
  // Validate lastname
   if(empty(trim($_POST["LastName"]))){
       $LastName_err = "Please enter lastname.";
   } else{
       // Prepare a select statement
       $sql = "SELECT id FROM users WHERE LastName = ?";
   
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
        
       // Close statement
       mysqli_stmt_close($stmt);
          }
        }
      
     // Validate email
     if(empty(trim($_POST["email"]))){
       $email_err = "Please enter an email.";
   } else{
       // Prepare a select statement
       $sql = "SELECT id FROM users WHERE email = ?";
    
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
   // Close statement
         mysqli_stmt_close($stmt);
          }
        
   
   // Validate password
   if(empty(trim($_POST["password"]))){
       $password_err = "Please enter a password.";     
   }
    elseif(strlen(trim($_POST["password"])) < 6){
       $password_err = "Password must have atleast 6 characters.";
   } else{
       $password = trim($_POST["password"]);
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
       $sql = "INSERT INTO users (FirstName, LastName, email, password) VALUES (?, ?, ?, ?)";
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
               header("location: index.html");
           } else{
               echo "Something went wrong. Please try again later.";
           }
          

       // Close statement
       mysqli_stmt_close($stmt);
           // Close connection
   mysqli_close($link);
          }
?>
