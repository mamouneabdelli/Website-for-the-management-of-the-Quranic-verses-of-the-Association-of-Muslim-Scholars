<?php

require_once __DIR__ . "/config/app.php";
require_once __DIR__ . "/template/header.php";
?>





    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:'Alexendra', sans-serif;
        }
        
        body {
            background-color: #ebf5f0;
            color: #333;
            line-height: 1.6;
            text-align: right;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
    
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
       
        .decorative-image-1 {
            position: absolute;
            width: 600px;
            height: 643px;
            right: -300px;
            top: 200px;
            opacity: 0.5;
            z-index: 1;
        }

        .decorative-image-2 {
            position: absolute;
            width: 600px;
            
            height: 643px;
            left: -300px;
            top: 100px;
            opacity: 0.5;
            z-index: 1;
        }

        .decorative-image-1 img, .decorative-image-2 img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
       
        
        .nav-bar {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding: 24px 80px 24px 42px;
            background: #E6F6EC;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            z-index: 10;
        }

        .logo img {
            width: 76px;
            height: 56px;
            border-radius: 62.8163px;
        }

        .menu {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            align-items: center;
            gap: 48px;
        }

        .menu-item {
            font-size: 18px;
            font-weight: 500;
            color:#00A841;
            text-decoration: none;
        }

        .menu-item:hover {
            color: #00A841;
        }

        .cta-button button {
            background: #00A841;
            color: #FFFFFF;
            padding: 16px 28px;
            border: none;
            border-radius: 24px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Alexandria', sans-serif;
            transition: background-color 0.3s ease;
        }

        .cta-button button:hover {
            background: #008634;
        }
        
        /* Hero Section */
        .hero {
            text-align: center;
            padding: 60px 0;
            position: relative;
        }
        
        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            z-index: -1;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #1a1a1a;
        }
        
        .hero h2 {
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: #333;
        }
        
        .hero-image {
            max-width: 400px;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .hero-image img {
            width: 100%;
            height: auto;
        }
        
        /* About Section */
        .about {
            padding: 30px 0;
            text-align: right;
        }
        
        .about p {
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        /* Steps Section */
        .steps {
            padding: 30px 0;
        }
        
        .steps h2 {
            text-align: right;
            margin-bottom: 40px;
            color: #16a34a;
        }
        
        .step {
            display: flex;
            margin-bottom: 30px;
            align-items: flex-start;
        }
        
        .step-icon {
            min-width: 50px;
            margin-left: 20px;
            color: #16a34a;
            font-size: 24px;
        }
        
        .step-content h3 {
            margin-bottom: 10px;
            color: #16a34a;
        }
        
        /* Support Section */
        .support {
            padding: 30px 0;
        }
        
        .support h2 {
            text-align: right;
            margin-bottom: 20px;
            color: #16a34a;
        }
        
        .support-list {
            list-style: none;
        }
        
        .support-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .support-list li:before {
            content: "•";
            color: #16a34a;
            font-weight: bold;
            margin-left: 10px;
            font-size: 20px;
        }
        
        /* Tools Section */
        .tools {
            padding: 30px 0;
        }
        
        .tools h2 {
            text-align: right;
            margin-bottom: 20px;
            color: #16a34a;
        }
        
        .tools-list {
            list-style: none;
        }
        
        .tools-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .tools-list li:before {
            content: "•";
            color: #16a34a;
            font-weight: bold;
            margin-left: 10px;
            font-size: 20px;
        }
        
        /* Goals Section */
        .goals {
            padding: 30px 0;
        }
        
        .goals h2 {
            text-align: right;
            margin-bottom: 20px;
            color: #16a34a;
        }
        
        .goals p {
            margin-bottom: 20px;
            line-height: 1.8;
        }
        
        /* Gallery Section */
        .gallery {
            padding: 30px 0;
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        
        .gallery-item {
            background-color: #c0f0d0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            aspect-ratio: 1/1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .gallery-item img {
            width: 50px;
            height: 50px;
            opacity: 0.7;
        }
        
        /* CTA Section */
        .cta {
            padding: 40px 0;
            text-align: center;
        }
        
        .cta h2 {
            margin-bottom: 20px;
            color: #16a34a;
        }
        
        .cta-btn {
            background-color: #16a34a;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: inline-block;
        }
        
        .cta-btn:hover {
            background-color: #138a3f;
        }
        
          /* Footer */
        footer {
            background-color: var(--white);
            padding: 50px 0 20px;
            border-top: 1px solid #eee;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: var(--black);
        }
        
        .footer-column ul li {
            margin-bottom: 10px;
        }
        
        .footer-column ul li a {
            color: #666;
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: var(--primary-color);
        }
        
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 20px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
        }
        
        .social-icons a {
            color: #666;
            transition: color 0.3s;
        }
        
        .social-icons a:hover {
            color: var(--primary-color);
        }
        
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
            }
            
            .nav-menu {
                margin-top: 20px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .nav-menu li {
                margin: 5px 10px;
            }
            
            .register-btn {
                margin-top: 20px;
            }
            
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero h2 {
                font-size: 1.5rem;
            }
            
            .step {
                flex-direction: column;
                text-align: center;
            }
            
            .step-icon {
                margin-bottom: 10px;
                margin-left: 0;
            }
            
            .footer-col {
                flex: 0 0 100%;
                text-align: center;
            }
            
            .footer-logo {
                justify-content: center;
            }
            
            .social-icons {
                justify-content: center;
            }
        }
        
        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: 1fr;
            }
        }
        .colortext{
            color: #16a34a;
            font-size:22px;
        }
        .contenttext{
            font-size:26px;
            font-family:'Alexendra';

        }
    </style>


    <h1 style="color:#00A841; font-family:'Alexendra'; font-size:28px; margin-right:5%;"> الكبار و الصغار </h1>
    <h2 style="color:#000000 ; font-family:'Alexendra'; font-size:28px; margin-right:5%;">دراسة و حفظ القران و تتدبر فيه</h2>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="decorative-image-2">
                <img src="d6540cd37f0613635a757705639e53101.png" alt="زخرفة إسلامية">
            </div>
            
            <div class="hero-image">
                <img src="d21ff0b5c94ca27dab2ad0f90de39de1.png" alt="صورة القرآن الكريم">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <p class="colortext">في جمعية العلماء المسلمين، نؤمن أن حفظ القرآن الكريم هو رحلة روحانية وعلمية تبدأ بالقلب وتنتهي بالعقل والعمل. نسعى إلى توفير بيئة إيمانية محفزة تجعل الطالب يشعر بالقرب من كتاب الله، عبر منهج متكامل يجمع بين الحفظ والتدبر.</p>
        </div>
    </section>

    <!-- Steps Section -->
    <section class="steps">
        <div class="container">
            <h2>خطوات التحفيظ</h2>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="step-content">
                    <h3>التدرج في الحفظ</h3>
                    <p class="contenttext">نبدأ أولاً مع الطالب بآية صغيرة مع زيادة الجرعة تدريجياً قدرته</p>
                </div>
            </div>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <div class="step-content">
                    <h3>التكرار اليومي</h3>
                    <p class="contenttext">يؤكد على أن التكرار هو مفتاح التثبيت، حيث يقوم الطالب بقراءة الآيات بصوت مسموع عدة مرات</p>
                </div>
            </div>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="step-content">
                    <h3>المراجعة المستمرة</h3>
                    <p class="contenttext">يتم تخصيص وقت يومي لمراجعة المحفوظات السابقة لتجنب النسيان وضمان التثبيت</p>
                </div>

            </div>
            
            <div class="step">
                <div class="step-icon">
                    <i class="fas fa-headphones"></i>
                </div>
            
            <div class="step-content">
                <h3>لاستماع والتلاوة </h3>
                <p class="contenttext">.تعتمد على الاستماع لقرّاء مجودين لتقوية مخارج الحروف والتجويد، ويقوم الطالب بتطبيق ماسمعه عمليا</p>
            </div>
            
        </div>
        
        <div class="step">
        <div class="step-content">
        <h4 style="color:#00A841; font-family:'Alexendra'; font-size:28px;">الدعم والإشراف:</h4>
         <p class="contenttext" style="font-family: Alexendra;">
           <br> شرف على النظام أساتذة متخصصون في علوم القرآن، يقدمون التوجيه الفردي والجماعي لكل طالب.-
                   نعتمد أسلوب التقييم الدوري، حيث يخضع الطالب لاختبارات تحفيزية لقياس مدى التقدم.-
                     توجد لقاءات أسبوعية تجمع الطلبة لتبادل الخبرات، مما يعزز روح الجماعة والتعاون.<br> 

         </p>
        </div>
    </div>
    <br>
    <div class="step">
        <div class="step-content">
        <h4 style="color: #00A841; font-family:'Alexendra'; font-size:28px;">الأدوات المساندة:</h4>
         <p class="contenttext" style="font-family: Alexendra;">
            نوفر تطبيقًا إلكترونيًا يحتوي على خطط يومية، وأوقات مراجعة، ومقاطع صوتية معتمدة.
            نعتمد على كراسات خاصة بالتحفيظ، تساعد الطالب على متابعة ما أتم حفظه بدقة
         </p>
        </div>
    </div>
    <div class="step">
        <div class="step-content">
        <h4 style="color: #00A841; font-family:'Alexendra'; font-size:28px;">لغاية والهدف:</h4>
        <img src="" alt="">
        <img src="" alt="">
         <p class="contenttext" style="font-family: Alexendra;">
            نسعى من خلال هذا النظام إلى غرس محبة القرآن في النفوس، بحيث لا يكون الحفظ غايةً فقط،
             بل وسيلةً لتهذيب السلوك وبناء الشخصية المسلمة الواعية
            . فالقرآن نور للقلوب، ومنهج حياة، ودستور رباني يدعو للتفكر والتطبيق
         </p><br><br>
         <p class="contenttext" style="font-family: Alexendra; text-align: center;">انضم إلينا، وابدأ رحلتك مع كتاب الله، حيث العلم والإيمان يلتقيان، وحيث الحرف القرآني<br> يضيء طريقك. ✨</p>
         <button class="cta-btn" style="margin-right:40%;">سجل كطالب القران </button>
        </div>
    </div>
    </div>
      <!-- Footer -->
      <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>روابط سريعة</h3>
                    <ul>
                        <li><a href="index.html">الرئيسية</a></li>
                        <li><a href="index.html">خدماتنا</a></li>
                        <li><a href="index.html">الأقسام التعليمية</a></li>
                        <li><a href="index.html">عن الجمعية</a></li>
                        <li><a href="index.html">الأسئلة الشائعة</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>البرامج التمهيدية</h3>
                    <ul>
                        <li><a href="#">برنامج تأسيس العلوم الشرعية</a></li>
                        <li><a href="#">برنامج اللغة العربية</a></li>
                        <li><a href="#">برنامج حفظ وتجويد القرآن</a></li>
                        <li><a href="#">الدورات الصيفية المكثفة</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>تواصل معنا</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> العنوان: المدينة، الشارع، رقم</li>
                        <li><i class="fas fa-phone"></i> الهاتف: +123456789</li>
                        <li><i class="fas fa-envelope"></i> البريد: info@example.com</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>تابعنا</h3>
                    <ul class="social-icons">
                        <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i> YouTube</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 جمعية العلماء المسلمين. جميع الحقوق محفوظة.</p>
                <div class="social-icons">
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>
                
                
                
                