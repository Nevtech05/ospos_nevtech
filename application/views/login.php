<!DOCTYPE html>
<html lang="<?php echo current_language_code(); ?>" dir="ltr">

<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title><?php echo $this->config->item('company') . ' | ' . $this->lang->line('common_software_short') . ' | ' . $this->lang->line('login_login'); ?></title>
    <link rel="stylesheet" href="css/custom-login.css">
    <link rel="stylesheet" href="<?php echo 'dist/bootswatch-5/' . (empty($this->config->item('theme')) || 'paper' == $this->config->item('theme') || 'readable' == $this->config->item('theme') ? 'flatly' : $this->config->item('theme')) . '/bootstrap.min.css'; ?>">
    <meta content="#2c3e50" name="theme-color">
</head>

<body>
    <section>
        <div class="box">
            <div class="form">
                <img src="images/logo.png" class="user" alt="">
                <h2><?php echo $this->lang->line('login_welcome', $this->lang->line('common_software_short')); ?></h2>

                <?php echo form_open('login'); ?>

                <!-- Validation Errors -->
                <?php if (validation_errors()): ?>
                <div class="alert alert-danger mt-3">
                    <?php echo validation_errors(); ?>
                </div>
                <?php endif; ?>

                <!-- Migration Needed Notice -->
                <?php if (!$this->migration->is_latest()): ?>
                <div class="alert alert-info mt-3">
                    <?php echo $this->lang->line('login_migration_needed', $this->config->item('application_version')); ?>
                </div>
                <?php endif; ?>

                <!-- Username Input -->
                <div class="inputBx">
                    <input type="text" name="username" placeholder="<?php echo $this->lang->line('login_username'); ?>" id="username" oninput="validation()" required autofocus>
                    <img src="images/user.png" alt="">
                </div>

                <!-- Password Input -->
                <div class="inputBx">
                    <input type="password" name="password" placeholder="<?php echo $this->lang->line('login_password'); ?>" id="password" oninput="validation()" required>
                    <img src="images/lock.png" alt="">
                </div>

                <!-- Remember Me Checkbox -->
                <!-- <label class="remember">
                    <input type="checkbox"> <?php echo $this->lang->line('login_remember_me'); ?>
                </label> -->

                <!-- Google Captcha -->
                <?php if($this->config->item('gcaptcha_enable')): ?>
                <div class="g-recaptcha mb-3" align="center" data-sitekey="<?php echo $this->config->item('gcaptcha_site_key'); ?>"></div>
                <?php endif; ?>

                <!-- Login Button -->
                <div class="inputBx">
                    <input type="submit" name="login-button" value="<?php echo $this->lang->line('login_go'); ?>" id="submit">
                </div>

                <?php echo form_close(); ?>

                <!-- Forgot Password and Sign Up Links -->
                <!-- <p><?php echo $this->lang->line('login_forgot_password'); ?> <a href="#"><?php echo $this->lang->line('login_reset'); ?></a>?</p>
                <p><?php echo $this->lang->line('login_need_account'); ?> <a href="#"><?php echo $this->lang->line('login_register'); ?></a>?</p> -->
            </div>
        </div>
    </section>

     <!-- Footer -->
     <footer>
        <p>&copy; 2024 OSpos. Designed & Developed by <strong>Nevtechzone Solutions Ltd.</strong></p>
    </footer>
</body>

</html>
