<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/handelLogin.php";

?>


<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8" />
  <!-- Main Tempelate CSS File -->
  <link rel="stylesheet" href="CSS/login.css?v=<?= time() ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <!-- Normalise  -->
  <link rel="stylesheet" href="CSS/normalize.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <title>Login</title>
</head>

<body>
  <div class="column">
    <div class="col1">
      <div class="image">
        <img src="img/زخرفة.png" alt="" />
      </div>
      <div class="parent">
        <div class="text">
          <h1>عودًا حميدًا سجل دخولك</h1>
          <p>
            نسعد بعودتك لمواصلة رحلتك العلمية، حيث يلتقي العلم بالإيمان،
            وتُبنى العقول لبناء مستقبلٍ مشرق. سجّل دخولك وكن جزءًا من رسالتنا
          </p>
        </div>
        <form class="in" method="post" action="<?= $_SERVER['PHP_SELF'] ?>">
          <span class="text-danger"><?= $errors['user'] ?? '' ?></span>
          <input
            type="text"
            name="email"
            placeholder="البريد الالكتروني او رقم الهاتف"
            value="<?= $email ?? '' ?>" />
          <span class="text-danger"><?= $errors['email'] ?? '' ?></span>
          <input
            type="password"
            name="password"
            placeholder="كلمة السر"
            value="<?= $password ?? '' ?>" />
          <span class="text-danger"><?= $errors['password'] ?? '' ?></span>
          <a href="#">هل نسيت كلمة مرورك؟</a>
          <input type="submit" value="سجل دخولك" />
        </form>
      </div>
    </div>
    <div class="col2"></div>
  </div>
</body>

</html>