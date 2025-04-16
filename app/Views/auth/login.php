<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $pageTitle; ?></title>
        <?= viewComponent('Head'); ?>
        <?= viewComponent('Stylesheet'); ?>
        <link href="./assets/css/style.bundle.css" rel="stylesheet" type="text/css"/>
        <script>
            if (window.top != window.self) {
                window.top.location.replace(window.self.location.href);
            }
        </script>
    </head>

    <body  id="kt_body" class="app-blank" data-kt-app-page-loading-enabled="true" data-kt-app-page-loading="on">
        <?= viewComponent('Preloader'); ?>
        <div class="d-flex flex-column flex-root" id="kt_app_root">
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                    <div class="w-lg-500px px-5">
                        <div class="me-5">
                            <img src="./assets/images/logos/logo-dark.svg" class="mb-5" alt="Logo-Dark" />        
                        </div>
                    </div>

                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <div class="w-lg-500px p-10">
                            <form class="form w-100" id="signin-form" method="post" action="#">
                                <h2 class="mb-2 mt-4 fs-1 fw-bolder text-center">Login to your account</h2>
                                <p class="mb-10 fs-6 text-center">Enter your email below to login to your account</p>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password">
                                        <button class="btn btn-addon btn-light bg-transparent password-addon" type="button">
                                            <i class="ki-outline ki-eye-slash fs-3 p-0"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div class="form-check form-check-sm form-check-dark form-check-solid">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me"/>
                                        <label class="form-check-label text-dark" for="remember_me">
                                            Remember Me
                                        </label>
                                    </div>
                                    <a href="<?= route('forgot-password'); ?>" class="link-dark">Forgot your password?</a>
                                </div>

                                <div class="d-grid">
                                    <button id="signin" type="submit" class="btn btn-dark">Login</button>
                                </div>
                            </form>
                        </div>
                        
                                
                        <div class="text-dark-500 text-center fs-6">
                            Don't have an account?

                            <a href="<?= route('register'); ?>" class="link-dark">
                                <u>Sign up</u>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(./assets/images/backgrounds/login-bg.jpg)"></div>
            </div>
        </div>

        <?= viewComponent('ErrorModal'); ?>
        <?= viewComponent('RequiredJS'); ?>

        <script type="module" src="./assets/js/auth/login.js?v=<?= e(rand()); ?>"></script>
    </body>
</html>