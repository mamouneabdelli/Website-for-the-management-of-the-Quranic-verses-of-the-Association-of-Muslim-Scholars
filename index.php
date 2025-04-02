<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['logen_in']) && $_SESSION['logen_in'] == true)
    $showPopup = true;

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جمعية العلماء المسلمين</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .popup-container {
            position: relative;
            max-width: 546px;
            width: 90%;
            animation: popIn 0.4s ease-out forwards;
            height: 654px;
            border-radius: 20px;
        }

        @keyframes popIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .popup {
            background-color: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid #000000;
            direction: rtl;
            position: absolute;
            right: 3px;
            top: 2px;
        }

        .popup-header {
            position: relative;
            margin-bottom: 30px;
        }

        .popup-title {
            text-align: center;
            color: #0d6e32;
            font-size: 28px;
            font-weight: 700;
            padding-bottom: 15px;
            border-bottom: 2px solid #e7f5ec;
        }

        .document-list {
            list-style: none;
            padding: 0;
            margin-bottom: 35px;
        }

        .document-list li {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .document-list li:hover {
            transform: translateX(-5px);
        }

        .document-list li::before {
            content: "•";
            color: #19a94d;
            font-weight: bold;
            margin-left: 12px;
            font-size: 22px;
        }

        .info-section {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-top: 25px;
        }

        .school-address {
            text-align: center;
            margin-bottom: 15px;
            font-size: 17px;
            color: #333;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .phone-number {
            text-align: center;
            font-size: 17px;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .phone-label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .phone-value {
            font-weight: 700;
            color: #0d6e32;
            direction: ltr;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .print-button {
            background-color: #19a94d;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .print-button:hover {
            background-color: #0d8e3e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(25, 169, 77, 0.3);
        }

        .print-button:active {
            transform: translateY(0);
        }

        .print-button svg {
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .print-button:hover svg {
            transform: translateY(-2px);
        }

        .close-button {
            position: absolute;
            top: -15px;
            left: -15px;
            background: #f9f9f9;
            border: 2px solid #19a94d;
            color: #19a94d;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .close-button:hover {
            background: #19a94d;
            color: white;
            transform: rotate(90deg);
        }

        @media (max-width: 768px) {
            .popup {
                padding: 25px;
            }

            .popup-title {
                font-size: 24px;
            }

            .document-list li {
                font-size: 16px;
            }

            .info-section {
                padding: 15px;
            }

            .school-address,
            .phone-number {
                font-size: 15px;
            }

            .print-button {
                padding: 10px 20px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <!-- Nav Bar -->
    <nav class="nav-bar">
        <div class="logo">
            <img src="img/شعار.png" alt="Logo جمعية العلماء المسلمين">
        </div>
        <div class="menu">
            <a href="index.html" class="menu-item">الرئيسية</a> <!-- هنا ربط تاع صفحات مع بعض    -->
            <a href="برنامجنا.html" class="menu-item">عن البرنامج</a>
            <a href="contact.html" class="menu-item">اتصل بنا</a>
            <a href="قضيتنا.html" class="menu-item">قضيتنا</a>
        </div>
        <div class="cta-button">
            <?php if (isset($_SESSION['logen_in'])) { ?>
                <div>
                    <button class="print-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z" />
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                        طباعة
                    </button>
                </div>
            <?php } else { ?>
                <a href="signup.html">سجّل وابدأ رحلتك العلمية</a>
            <?php } ?>
        </div>
    </nav>

    <!-- first section   -->
    <section class="hero-section">
        <div class="hero-content">
            <div class="quote">
                <h2>● قال رسول الله صلى الله عليه و سلم ●</h2>
                <p>"من سلك طريقًا يلتمس فيه علما سهل الله له طريقا إلى الجنة"</p>
                <p>رواه مسلم</p>
            </div>
            <div class="sub-heading">
                <p>
                    انضم إلى جمعية علماء المسلمين وكن جزءًا من المجتمع العلمي يسعى لنشر المعرفة. نحن نؤمن بأن العلم هو السبيل للنهوض وتعزيز قيمة العلم في المجتمع. نحن نؤمن بأن العلم هو السبيل للنهوض بالأمة وأن بناء العقول هو الخطوة الأولى نحو بناء المستقبل من خلال منصتنا
                </p>
            </div>
            <div class="cta-button">
                <a href="signup.php">سجل كطالب</a>
            </div>
        </div>
        <div class="decorative-image-1">
            <img src="img/زخرفة.png" alt="زخرفة إسلامية">
        </div>
        <div class="decorative-image-2">
            <img src="img/زخرفة.png" alt="زخرفة إسلامية">

        </div>
        <div class="highlight-section">
            <h2><span class="greencolortitles">أبرز ما نقدمه</span> في جمعية العلماء المسلمين</h2>
        </div>
    </section>

    <!-- second section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <img src="/api/placeholder/80/80" alt="القرآن الكريم">
                    <div class="feature-title">دراسة وحفظ القرآن الكريم</div>
                    <div class="feature-desc">برامج متخصصة لحفظ القرآن الكريم وتدبره</div>
                </div>
                <div class="feature-card">
                    <img src="/api/placeholder/80/80" alt="التفسير">
                    <div class="feature-title">دروس في علوم القرآن</div>
                    <div class="feature-desc">تعلم أصول التفسير وعلوم القرآن</div>
                </div>
                <div class="feature-card">
                    <img src="/api/placeholder/80/80" alt="الحديث">
                    <div class="feature-title">دراسة السنة النبوية</div>
                    <div class="feature-desc">تعلم أصول الحديث ودراسة السنة</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section 1 -->
    <section class="content-section">
        <div class="content-text">
            <h3 class="h3">دراسة و حفظ و تدبر فيه</h3><br>
            <div class="secondone">
                نوفر في جمعية العلماء المسلمين برامج تمهيدية
                متكاملة تهدف إلى تأسيس الطلاب في مختلف
                العلوم الشرعية واللغوية، مع التركيز على بناء
                قاعدة معرفية قوية تمهّد لهم طريق التعلم العميق.
                سواء كنت في بداية رحلتك العلمية أو تسعى لتعزيز فهمك
                🌱✨ ، ستجد بيئة تعليمية تدعمك وتوجّهك نحو التميز.
            </div>
            <br>
            <br>
            <div class="cta-button">
                <a href="برنامجنا(تفاصيل).html">تعرف المزيد</a>
            </div>
        </div>
        <div class="content-images">
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="حفظ القرآن">
            </div>
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="تجويد القرآن">
            </div>
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="تفسير القرآن">
            </div>
        </div>
    </section>

    <!-- Content Section 2 -->
    <section class="content-section reversed">
        <div class="content-text">
            <h3 class="h3">ندرس و نهتم بالأقسام التمهيدية</h3>
            <div class="secondone2">
                نوفر في جمعية العلماء المسلمين برامج تمهيدية متكاملة تهدف
                إلى تأسيس الطلاب في مختلف العلوم الشرعية
                واللغوية، مع التركيز على بناء قاعدة معرفية قوية تمهّد لهم
                طريق التعلم العميق. سواء كنت في بداية رحلتك العلمية
                أو تسعى لتعزيز فهمك، ستجد بيئة تعليمية
                تدعمك وتوجّهك نحو التميز.
            </div>
            <br>
            <br>
            <div class="cta-button">
                <a href="برنامجنا(تفاصيل).html">تعرف المزيد</a>
            </div>
        </div>
        <div class="content-images single">
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="الأقسام التمهيدية">
            </div>
        </div>
    </section>

    <!-- Additional Content Section -->
    <section class="content-section">
        <div class="content-images">
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="العلوم الشرعية">
            </div>
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="العلوم اللغوية">
            </div>
            <div class="content-image">
                <img src="/api/placeholder/50/50" alt="الفقه الإسلامي">
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <h2 class="stats-heading">رسالتنا وقيمنا</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <img src="/api/placeholder/60/60" alt="إحصائية">
                    <div class="stat-value">+17</div>
                    <div class="stat-label">عدد سنوات خبرتنا في تعليم العلوم الشرعية</div>
                </div>
                <div class="stat-card">
                    <img src="/api/placeholder/60/60" alt="إحصائية">
                    <div class="stat-value">+70</div>
                    <div class="stat-label">برامج تعليمية متنوعة</div>
                </div>
                <div class="stat-card">
                    <img src="/api/placeholder/60/60" alt="إحصائية">
                    <div class="stat-value">+20</div>
                    <div class="stat-label">عدد العلماء المتخصصين</div>
                </div>
                <div class="stat-card">
                    <img src="/api/placeholder/60/60" alt="إحصائية">
                    <div class="stat-value">+150</div>
                    <div class="stat-label">عدد الطلاب المتخرجين سنويًا</div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="faq-heading">الأسئلة الشائعة</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-icon"></div>
                    <div class="faq-question">ما هي جمعية العلماء المسلمين؟</div> <!--<button class="buttonlast">+</button> -->

                </div>
                <div class="faq-item">
                    <div class="faq-icon"></div>
                    <div class="faq-question">كيف يمكنني التسجيل في الجمعية؟</div> <!--<button class="buttonlast">+</button> -->
                </div>
                <div class="faq-item">
                    <div class="faq-icon"></div>
                    <div class="faq-question">هل يوجد فصل بين الطالبات ؟</div> <!--<button class="buttonlast">+</button> -->
                </div>
                <div class="faq-item">
                    <div class="faq-icon"></div>
                    <div class="faq-question">ما هي آلية التسجيل في البرنامج؟</div> <!--<button class="buttonlast">+</button> -->
                </div>
                <div class="faq-item">
                    <div class="faq-icon"></div>
                    <div class="faq-question">هل الجمعية معتمدة رسميًا؟</div> <!--<button class="buttonlast">+</button> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2 class="map-heading">أين نحن؟</h2>
            <div class="map-container">
                <img src="img/Screenshot 2025-03-11 223212 1.png" alt="خريطة موقع الجمعية">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-title">الجمعية</div>
                    <div class="footer-links">
                        <a href="#" class="footer-link">عن الجمعية</a>
                        <a href="#" class="footer-link">رؤيتنا</a>
                        <a href="#" class="footer-link">رسالتنا</a>
                        <a href="#" class="footer-link">فريق العمل</a>
                        <a href="#" class="footer-link">تواصل معنا</a>
                    </div>
                </div>
                <div class="footer-column">
                    <div class="footer-title">البرامج</div>
                    <div class="footer-links">
                        <a href="#" class="footer-link">حفظ القرآن</a>
                        <a href="#" class="footer-link">تفسير القرآن</a>
                        <a href="#" class="footer-link">علوم الحديث</a>
                        <a href="#" class="footer-link">أصول الفقه</a>
                        <a href="#" class="footer-link">العقيدة</a>
                    </div>
                </div>
                <div class="footer-column">
                    <div class="footer-title">المصادر</div>
                    <div class="footer-links">
                        <a href="#" class="footer-link">المكتبة الإلكترونية</a>
                        <a href="#" class="footer-link">الكتب والمراجع</a>
                        <a href="#" class="footer-link">التسجيلات الصوتية</a>
                        <a href="#" class="footer-link">المحاضرات المرئية</a>
                        <a href="#" class="footer-link">المقالات العلمية</a>
                    </div>
                </div>
                <div class="footer-column">
                    <div class="footer-title">جمعية العلماء المسلمين</div>
                    <div class="footer-links">
                        <a href="#" class="footer-link">سياسة الخصوصية</a>
                        <a href="#" class="footer-link">الشروط والأحكام</a>
                        <a href="#" class="footer-link">سياسة الاستخدام</a>
                        <a href="#" class="footer-link">الدعم الفني</a>
                        <a href="#" class="footer-link">الأسئلة الشائعة</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="footer-logo">
                    <img src="d21ff0b5c94ca27dab2ad0f90de39de1.png" alt="Logo جمعية العلماء المسلمين">
                    <span>جمعية العلماء المسلمين © 2025</span>
                </div>
                <div class="footer-social">
                    <div class="social-icon">FB</div>
                    <div class="social-icon">TW</div>
                    <div class="social-icon">YT</div>
                    <div class="social-icon">IG</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Popup Window -->

    <!-- Registration Popup -->
    <div id="registrationPopup" class="popup-overlay <?= $showPopup ? 'active' : '' ?>">
        <div class="popup-container">
            <div class="popup">
                <div class="popup-header">
                    <h2 class="popup-title">ملف التسجيل</h2>
                    <div class="close-button">×</div>
                </div>

                <ul class="document-list">
                    <li>شهادة ميلاد</li>
                    <li>02 صور شمسية</li>
                    <li>شهادة إثبات مستوى</li>
                    <li>رسوم الاشتراك ( 4200 DA)</li>
                    <li>صور طبق الأصل بطاقة التعريف</li>
                </ul>

                <div class="info-section">
                    <div class="school-address">
                        عنوان مدرسة الفتح التعليم القرآني عين الدفلة 01 رقم 04
                    </div>

                    <div class="phone-number">
                        <span class="phone-label">رقم الهاتف</span>
                        <span class="phone-value">0669557044</span>
                    </div>
                </div>

                <div class="button-container">
                    <button class="print-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z" />
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                        </svg>
                        طباعة
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add functionality to close button
        document.querySelector('.close-button').addEventListener('click', function() {
            document.getElementById('registrationPopup').classList.remove('active');
        });

        // Add print functionality
        document.querySelector('.print-button').addEventListener('click', function() {
            // Create a new window for printing just the popup content
            const printWindow = window.open('', '_blank');

            // Get the content to print
            const popupContent = `
        <!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
          <meta charset="UTF-8">
          <title>ملف التسجيل</title>
          <style>
            body {
              font-family: Arial, sans-serif;
              margin: 20px;
              direction: rtl;
            }
            .print-header {
              text-align: center;
              color: #0d6e32;
              font-size: 24px;
              font-weight: bold;
              margin-bottom: 20px;
              padding-bottom: 10px;
              border-bottom: 2px solid #e7f5ec;
            }
            .document-list {
              list-style: none;
              padding: 0;
              margin-bottom: 30px;
            }
            .document-list li {
              margin-bottom: 12px;
              font-size: 16px;
              padding-right: 20px;
              position: relative;
            }
            .document-list li::before {
              content: "•";
              color: #19a94d;
              font-weight: bold;
              position: absolute;
              right: 0;
            }
            .info-box {
              background-color: #f8f9fa;
              border: 1px solid #e0e0e0;
              border-radius: 5px;
              padding: 15px;
              margin-top: 20px;
            }
            .school-address {
              text-align: center;
              margin-bottom: 15px;
              padding-bottom: 10px;
              border-bottom: 1px solid #e0e0e0;
            }
            .phone-number {
              text-align: center;
            }
            .phone-value {
              font-weight: bold;
              color: #0d6e32;
            }
          </style>
        </head>
        <body>
          <div class="print-header">ملف التسجيل</div>
          
          <ul class="document-list">
            <li>شهادة ميلاد</li>
            <li>02 صور شمسية</li>
            <li>شهادة إثبات مستوى</li>
            <li>رسوم الاشتراك ( 4200 DA)</li>
            <li>صور طبق الأصل بطاقة التعريف</li>
          </ul>
          
          <div class="info-box">
            <div class="school-address">
              عنوان مدرسة الفتح التعليم القرآني عين الدفلة 01 رقم 04
            </div>
            
            <div class="phone-number">
              رقم الهاتف:<br>
              <span class="phone-value">0669557044</span>
            </div>
          </div>
        </body>
        </html>
      `;

            // Write content to the new window
            printWindow.document.open();
            printWindow.document.write(popupContent);
            printWindow.document.close();

            // Print after the content loads
            printWindow.onload = function() {
                printWindow.print();
                // Close the window after printing (optional)
                // printWindow.close();
            };
        });
    </script>


    <script>
        // Animation for decorative images
        document.addEventListener('DOMContentLoaded', function() {
            // Get the decorative images
            const decorativeImage1 = document.querySelector('.decorative-image-1');
            const decorativeImage2 = document.querySelector('.decorative-image-2');


            const positions = {
                image1: {
                    right: -300,
                    top: 200,
                    opacity: 0.5
                },
                image2: {
                    left: -300,
                    top: 100,
                    opacity: 0.5
                }
            };

            // Function to animate the swap
            function animateSwap() {
                // Animate first image out
                gsap.to(decorativeImage1, {
                    right: -600,
                    opacity: 0,
                    duration: 2,
                    ease: "power2.inOut",
                    onComplete: function() {
                        // Reset position but hidden
                        gsap.set(decorativeImage1, {
                            right: 400,
                            opacity: 0
                        });

                        // Animate back in
                        gsap.to(decorativeImage1, {
                            right: positions.image1.right,
                            opacity: positions.image1.opacity,
                            duration: 2,
                            ease: "power2.inOut"
                        });
                    }
                });

                // Animate second image with delay
                setTimeout(function() {
                    gsap.to(decorativeImage2, {
                        left: -600,
                        opacity: 0,
                        duration: 2,
                        ease: "power2.inOut",
                        onComplete: function() {
                            // Reset position but hidden
                            gsap.set(decorativeImage2, {
                                left: 400,
                                opacity: 0
                            });


                            gsap.to(decorativeImage2, {
                                left: positions.image2.left,
                                opacity: positions.image2.opacity,
                                duration: 2,
                                ease: "power2.inOut"
                            });
                        }
                    });
                }, 500); // 1 second delay between animations
            }


            function vanillaAnimateImages() {
                let image1MovingOut = true;
                let image2MovingOut = true;


                let image1Right = positions.image1.right;
                let image2Left = positions.image2.left;
                let image1Opacity = positions.image1.opacity;
                let image2Opacity = positions.image2.opacity;

                // Animation speed
                const step = 2;
                const opacityStep = 0.01;

                setInterval(function() {
                    // Animate image 1
                    if (image1MovingOut) {
                        image1Right -= step;
                        image1Opacity -= opacityStep;

                        if (image1Right <= -600) {
                            image1MovingOut = false;
                            image1Right = 400;
                            image1Opacity = 0;
                        }
                    } else {
                        image1Right -= step;
                        image1Opacity += opacityStep;

                        if (image1Right <= positions.image1.right) {
                            image1MovingOut = true;
                            image1Right = positions.image1.right;
                            image1Opacity = positions.image1.opacity;
                        }
                    }

                    // Animate image 2
                    if (image2MovingOut) {
                        image2Left -= step;
                        image2Opacity -= opacityStep;

                        if (image2Left <= -600) {
                            image2MovingOut = false;
                            image2Left = 400;
                            image2Opacity = 0;
                        }
                    } else {
                        image2Left -= step;
                        image2Opacity += opacityStep;

                        if (image2Left <= positions.image2.left) {
                            image2MovingOut = true;
                            image2Left = positions.image2.left;
                            image2Opacity = positions.image2.opacity;
                        }
                    }


                    decorativeImage1.style.right = image1Right + 'px';
                    decorativeImage1.style.opacity = Math.max(0, Math.min(image1Opacity, positions.image1.opacity));

                    decorativeImage2.style.left = image2Left + 'px';
                    decorativeImage2.style.opacity = Math.max(0, Math.min(image2Opacity, positions.image2.opacity));
                }, 30);
            }


            vanillaAnimateImages();
        });
    </script>
    <script>
        // Enhanced button functionality - selective popup and links
        document.addEventListener('DOMContentLoaded', function() {
            // Get the popup element
            const popup = document.getElementById('registrationPopup');

            // Get all CTA register buttons (سجّل وابدأ رحلتك العلمية and سجل كطالب)
            const registerButtons = document.querySelectorAll('.cta-button button');

            // Get all "تعرف المزيد" buttons
            const moreInfoButtons = document.querySelectorAll('button:not(.close-btn):not([type="submit"])');

            // Add click event listeners to register buttons to open popup
            registerButtons.forEach(button => {
                // Check if the button text contains registration text
                if (button.textContent.includes('سجّل') || button.textContent.includes('سجل')) {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        // Open the popup
                        popup.classList.add('active');
                    });
                }
            });

            // Add click event listeners to "تعرف المزيد" buttons to navigate to index2.html
            moreInfoButtons.forEach(button => {
                if (button.textContent.trim() === 'تعرف المزيد') {
                    button.addEventListener('click', function(event) {
                        event.preventDefault();
                        window.location.href = 'index2.html';
                    });
                }
            });

            // Close button functionality
            const closeBtn = document.querySelector('.close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    popup.classList.remove('active');
                });
            }

            // Close popup when clicking outside the popup content
            popup.addEventListener('click', function(event) {
                if (event.target === popup) {
                    popup.classList.remove('active');
                }
            });

            // Update current time
            function updateTime() {
                const timeElement = document.getElementById('currentTime');
                if (timeElement) {
                    const now = new Date();
                    const hours = now.getHours().toString().padStart(2, '0');
                    const minutes = now.getMinutes().toString().padStart(2, '0');
                    timeElement.textContent = hours + ':' + minutes;
                }
            }

            // Update time initially and then every minute
            updateTime();
            setInterval(updateTime, 60000);

            // Handle ESC key to close popup
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && popup.classList.contains('active')) {
                    popup.classList.remove('active');
                }
            });


        });;
    </script>
    <?php
    
    ?>