<?php
    // Check for session formAlert
    if (isset($_SESSION["formAlert"])) {
        $formAlert = $_SESSION['formAlert'];

        // clear formAlert session after reload
        unset($_SESSION['formAlert']);
    }

    $pageTitle = "Contact Me";

    include "header.php";
?>
    <section id="main" class="min-vh-100 py-5">
        <div class="container px-0">
            <div class="row g-5 py-3 mb-3 border-bottom">
                <h1 class="display-1 fs-1 text-center">Say Hello</h1>
            </div>
            <div class="row py-5 mb-3">
                <div class="col-md-8 mx-auto shadow-lg p-4 rounded-0 bg-body-light text-center">
                    <?php
                        if (isset($formAlert)) {
                    ?>
                            <div class="alert alert-danger" role="alert">
                                <?php
                                    echo htmlspecialchars($formAlert, ENT_QUOTES, 'UTF-8');
                                ?>
                            </div>
                    <?php
                        }
                    ?>
                    <form action="sendmail.php" method="post" id="sb-contact">
                        <div class="row">
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" name="yourName" id="floatingName" class="form-control" placeholder="Your Name">
                                    <label for="floatingName">Your Name</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="email" name="yourEmail" id="floatingEmail" class="form-control" placeholder="Your Email Address">
                                    <label for="floatingEmail">Your Email Address</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="messageSubject" id="floatingSubject" class="form-control" placeholder="Your Message Subject">
                            <label for="floatingSubject">Message Subject</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="yourMessage" id="sb-contactForm" class="form-control" placeholder="Enter your message here" style="height: 200px;"></textarea>
                            <label for="sb-contactForm">Your Message</label>
                        </div>
                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                        <button type="submit" class="btn btn-primary g-recaptcha" data-sitekey="6LcentwmAAAAAA5ZH1aJ6cMcNTIhyZfqqDSwbERe" data-callback='onSubmit' data-action='submit'>Send Your Message</button>
                    </form>
                    <script>
                        function onSubmit(token) {
                            // Manually set the value of the reCAPTCHA response field
                            document.getElementById("recaptchaResponse").value = token;

                            // Submit the form
                            document.getElementById("sb-contact").submit();
                        }
                    </script>
                </div>
            </div>
        </div>
    </section>
<?php
    include "footer.php";
?>