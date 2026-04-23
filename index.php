<?php
session_start();

require_once __DIR__ . '/helpers/message.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sign In | <?php require_once __DIR__ . '/helpers/title.php'; ?> </title>
    <link rel="stylesheet" href="public/assets/vendor/css/pages/page-auth.css" />
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link rel="icon" type="image/x-icon" href="storage/images/isu-logo.png" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />
    <link rel="stylesheet" href="public/assets/vendor/fonts/iconify-icons.css" />
    <link rel="stylesheet" href="public/assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="public/assets/vendor/css/core.css" />
    <link rel="stylesheet" href="public/assets/css/demo.css" />
    <link rel="stylesheet" href="public/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
</head>
<body>

    <?php showFlash(); ?>

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Login -->
          <div class="card p-sm-7 p-2">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="index.php" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">
                  <img src="storage/images/isu-logo.png" alt="ISU Leave System Logo" width="80" height="80" />
                </span>
                <span class="app-brand-text demo text-heading fw-semibold">ISU Leave System</span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">
              <p class="mb-5">Please sign-in to your account and start you session</p>

              <form id="formAuthentication" class="mb-5" action="app/controllers/Auth.php" method="POST">
                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    autofocus />
                  <label for="email">Email</label>
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input
                          type="password"
                          id="password"
                          class="form-control"
                          name="password"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password" />
                        <label for="password">Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"
                        ><i class="icon-base ri ri-eye-off-line icon-20px"></i
                      ></span>
                    </div>
                  </div>
                </div>
                <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    

    <!-- script for show password -->
    <script src="public/js/showpass.js"></script>

</body>
</html>