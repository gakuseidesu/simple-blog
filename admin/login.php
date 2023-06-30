<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Simple Blog | Login</title>
</head>
<body>
    <div class="container px-0">
        <div class="row">
            <div class="col-sm-12 col-md-8 col-lg-6 mx-auto px-0">
                <div class="row">
                    <div class="col border border-secondary my-5 p-5">
                        <form action="includes/login.inc.php" method="post" class="needs-validation" novalidate>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email" class="form-control" placeholder="Enter your email" required>
                                <label for="email">Email</label>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter your password" required minlength="8" maxlength="20">
                                <label for="password">Password</label>
                                <div class="valid-feedback">Looks good!</div>
                                <div class="invalid-feedback">Please enter a valid password format. Passwords must be 8-20 alphanumeric characters and include at least an uppercase, lowercase, and a special character. </div>
                            </div>
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary my-5" id="submit" name="submit">Login</button>
                                <p>
                                    <a href="registration.php">Create an account</a>
                                </p>
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
    
