<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MrDry - Login</title>
  <link rel="stylesheet" href="/laundry/bootstrap-5.3.3-dist/css/bootstrap.min.css" />
  <style>
    .loginBody {
      background: url('./assets/img/bg-laundry.jpg') no-repeat center center fixed;
      background-size: cover;
    }

    .error-message {
      color: red;
    }
  </style>
</head>

<body class="loginBody">
  <section class="py-3 py-md-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 mt-5 shadow">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="text-center mb-3 h1 fw-bold">MrDry</div>
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">
                masuk ke akun Anda
              </h2>
              <form action="./service/loginUser.php" method="POST">
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">

                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" required />
                      <label for="username" class="form-label">Username</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control" name="password" id="password" placeholder="Password" required />
                      <label for="password" class="form-label">Password</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <select class="form-select" id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="kasir">Kasir</option>
                      </select>
                      <label for="role" class="form-label">Posisi:</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid') : ?>
                        <div class="error-message text-center mb-3">Kesalahan username, password, or role</div>
                      <?php endif; ?>
                      <button class="btn btn-info btn-lg text-light" type="submit" name="submit">
                        Log in
                      </button>
                    </div>
                  </div>
                  <div class="col-12 text-center">
                    <a href="forgotPassword.php" class="text-info">Lupa Password?</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="/laundry/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
  <script src="/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>