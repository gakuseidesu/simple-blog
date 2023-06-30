<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Simple Blog | Create An Account</title>
</head>
<body>
    <div class="container px-0">
        <div class="row">
            <div class="col-md-6 mx-auto px-0">
                <div class="row">
                    <div class="col border border-secondary my-5 p-5">
                        <?php
                            // Initialize the session
                            session_start();

                            // Check if a session variable exist and list them
                            foreach($_SESSION as $key => $value) {
                                if(isset($_SESSION[$key])) {
                                    echo htmlspecialchars($_SESSION[$key], ENT_QUOTES, 'UTF-8');
                                }
                            }
                            
                            // Regenerate the session ID to prevent session fixation attacks
                            session_regenerate_id(true);
                        ?>
                        <form action="includes/signup.inc.php" method="post" class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-3">
                                    <label for="userName" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="userName" id="userName" placeholder="Enter a username" required minlength="4">
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Username must be at least 4 alphanumeric characters.</div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter your password" required minlength="8" maxlength="20">
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please enter a valid password format. Passwords must be 8-20 alphanumeric characters and include at least an uppercase, lowercase, and a special character. </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <label for="pwdRepeat" class="form-label">Repeat Password</label>
                                    <input type="password" class="form-control" name="pwdRepeat" id="pwdRepeat" placeholder="Confirm your password" required minlength="8" maxlength="20">
                                    <div class="valid-feedback">Looks good!</div>
                                    <div class="invalid-feedback">Please confirm your password. This password must match the originally entered password.</div>
                                </div>
                            </div>
                            <div class="row border-top">
                                <div class="col text-center py-3">
                                    <button type="submit" class="btn btn-primary my-5" name="submit">Create an account</button>
                                    <p>
                                        Already have an account?
                                        <a href="login.php">Login here</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="js/validation.js"></script>
</body>
</html>
