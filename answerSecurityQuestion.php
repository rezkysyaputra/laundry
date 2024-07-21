<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>MrDry - Answer Security Question</title>
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
                Jawaban Security Question
              </h2>
              <form action="./service/verifySecurityAnswer.php" method="POST">
                <?php if (isset($_GET['error']) && $_GET['error'] == 'incorrect'): ?>
                  <div class="error-message text-center mb-3">Jawaban salah</div>
                <?php endif; ?>
                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="hidden" name="username" value="<?php echo $_GET['username']; ?>" />
                      <input type="text" class="form-control" name="security_question" id="security_question" placeholder="Security Question" value="<?php echo urldecode($_GET['question']); ?>" disabled />
                      <label for="security_question" class="form-label">Security Question</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="security_answer" id="security_answer" placeholder="Answer" required />
                      <label for="security_answer" class="form-label">Jawaban</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-info btn-lg text-light" name="submit" type="submit">
                        Submit
                      </button>
                    </div>
                  </div>
                  <div class="col-12 text-center">
                    <a href="index.php" class="text-info">Kembali untuk Login</a>
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
