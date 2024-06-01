<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Weather App</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
   </head>
   <body class="bg-body-secondary">
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-4 col-12">
                <form action="<?=base_url('login')?>" method="POST">
                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-2">
                        <input type="email" name="email" id="form2Example1" class="form-control" placeholder="Email address" required/>
                    </div>
                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-2">
                        <input type="password" name="password" id="form2Example2" class="form-control" placeholder="Password" required/>
                    </div>

                    <!-- Submit button -->
                    <button  type="submit" class="btn btn-primary btn-block mb-2">Sign in</button>
                    <?php if (session()->has('error')): ?>
                        <div><?= session('error') ?></div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
      
   </body>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>
</html>