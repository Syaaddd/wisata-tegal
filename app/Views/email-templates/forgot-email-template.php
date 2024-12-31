<p>Dear <?= $mail_data['user']->name ?></p>
<p>
    we are recieved a request to reset your password. <i><?= $email_data['user']->email ?></i> 
    Please click the link below to reset your password
    <br><br>
    <a href="<?= $email_data['actionLink'] ?>" target="_blank">Reset Password</a>
    <br><br>
    <b>NB:</b> This link will expire in 15 minutes.
    <br><br>
    If you did not request a password reset, please ignore this email.
</p>