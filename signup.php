<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/handelSignup.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <!-- Main Tempelate css -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/signup.css?v=<?= time() ?>" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Cairo:wght@200..1000&display=swap"
    rel="stylesheet">
  <!-- Normalize -->
  <link rel="stylesheet" href="CSS/normalize.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <title>css</title>

</head>

<body>
  <div class="column">
    <div class="col1">
      <div class="image">
        <img src="img/زخرفة.png" alt="" />
      </div>
      <div class="parent">
        <h1>عودًا حميدًا سجل دخولك</h1>
        <p>
          نسعد بعودتك لمواصلة رحلتك العلمية، حيث يلتقي العلم بالإيمان، وتُبنى
          العقول لبناء مستقبلٍ مشرق. سجّل دخولك وكن جزءًا من رسالتنا
        </p>
        <form method="post" action="<?= $_SERVER['PHP_SELF'] ?>">

        <span class="text-danger"><?= $errors['user'] ?? '' ?></span>
          <div class="part1">
            <div class="name">
              <div>
                <input class="main" type="text" name="first_name" placeholder="الاسم" value="<?= $first_name ?>" />
                <span class="text-danger"><?= $errors['first_name'] ?? '' ?></span>
              </div>
              <div>
                <input class="main" type="text" name="last_name" placeholder="اللقب" value="<?= $last_name ?>" />
                <span class="text-danger"><?= $errors['last_name'] ?? '' ?></span>
              </div>
            </div>

            <div>
              <input class="main" type="text" name="email" placeholder="البريد الالكتروني او رقم الهاتف" value="<?= $email ?>" />
              <span class="text-danger"><?= $errors['email'] ?? '' ?></span>
            </div>

            <div>
              <input class="main" type="password" name="password" placeholder="كلمة السر" value="<?= $password ?>" />
              <span class="text-danger"><?= $errors['password'] ?? '' ?></span>
            </div>

            <div>
              <input class="main" type="password" name="confirm_password" placeholder="تاكيد كلمة السر" value="<?= $confirm_password ?>" />
              <span class="text-danger"><?= $errors['confirm_password'] ?? '' ?></span>
            </div>
          </div>

          <a href="#">هل نسيت كلمة السر ؟</a>

          <div class="part2">
            <div>
              <select class="main" id="gender" name="gender">
                <option value="" selected>الجنس</option>
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
              </select>
            </div>

            <div>
              <select class="main" id="education_level" name="academic_phase">
                <option value="" selected>
                  اختر الطور الذي تدرسه
                </option>
                <option value="primary">ابتدائي</option>
                <option value="middle">متوسط</option>
                <option value="secondary">ثانوي</option>
                <option value="university">جامعي</option>
              </select>
            </div>

            <input class="second" type="submit" value="أرسل تسجيلك إلى الجمعية" />
          </div>
        </form>
      </div>
    </div>
    <div class="col2"></div>
  </div>

</body>

</html>

<?php

 ?>