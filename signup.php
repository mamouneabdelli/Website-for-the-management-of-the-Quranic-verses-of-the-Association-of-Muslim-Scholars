<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__."/includes/handelSignup.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <!-- Main Tempelate css -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="CSS/signup.css" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Alexandria:wght@100..900&family=Cairo:wght@200..1000&display=swap"
    rel="stylesheet">
  <!-- Normalize -->
  <link rel="stylesheet" href="CSS/normalize.css" />
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
          <div class="part1">
            <div class="name">
              <input class="main" type="text" name="first_name" placeholder="الاسم" required />
              <input class="main" type="text" name="last_name" placeholder="اللقب" required />
            </div>
            <br />
            <input class="main" type="email" name="email" placeholder="البريد الالكتروني او رقم الهاتف" required />
            <input class="main" type="password" name="password" placeholder="كلمة السر" minlength="8" required />
            <input class="main" type="password" name="confirm_password" placeholder="تاكيد كلمة السر" minlength="8" required />
          </div>
          <a href="#">هل نسيت كلمة السر ؟</a>
          <div class="part2">
            <select class="main" id="gender" name="gender" required>
              <option value="" disabled selected hidden>الجنس</option>
              <option value="male">ذكر</option>
              <option value="female">أنثى</option>
            </select>
            <select class="main" id="gender" name="gender" required>
              <option value="" disabled selected hidden>
                اختر الطور الذي تدرسه
              </option>
              <option value="male">ذكر</option>
              <option value="female">أنثى</option>
            </select>
            <input class="second" type="submit" value="أرسل تسجيلك إلى الجمعية" />
          </div>
        </form>
      </div>
    </div>
    <div class="col2"></div>
  </div>
</body>

</html>