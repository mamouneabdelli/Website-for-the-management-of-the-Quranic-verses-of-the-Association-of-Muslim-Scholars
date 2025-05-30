
<?php

require_once __DIR__ . "/config/app.php";
require_once __DIR__ . "/template/header.php";
?>



    <style>
        
/* Global Styles */
:root {
    --primary-color: #28a745;
    --light-green: #e8f5e9;
    --dark-green: #1b7e34;
    --gray: #f8f9fa;
    --white: #ffffff;
    --black: #333333;
}
 /* Nav Bar */
 .nav-bar {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    padding: 24px 80px 24px 42px;
   
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


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

html, body {
    background-color:#D9F2E3;
    scroll-behavior: smooth;
}

body {
    font-family: 'Alexandria', sans-serif;
            background: #E6F6EC;
            margin: 0;
            padding: 0;
            direction: rtl;
            color: #1E1E1E;
}

a {
    text-decoration: none;
    color: inherit;
}

ul {
    list-style: none;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    padding: 10px 20px;
    border-radius: 30px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    background-color: var(--dark-green);
    transform: translateY(-2px);
}

section {
    padding: 60px 0;
}

.img-placeholder {
    background-color: var(--light-green);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    min-height: 150px;
    border-radius: 8px;
}

.img-placeholder i {
    color: var(--primary-color);
    font-size: 2rem;
}

/* Header Styles */


.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
}

.logo {
    font-size: 1.5rem;
    font-weight: 700;
  
}

.logo img {
    height: 40px;
}



/* Decorative Islamic Pattern */
.islamic-pattern {
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
    width: 400px;
    max-width: 30%;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path fill="none" stroke="%23e8f5e9" stroke-width="2" d="M50,1 a49,49 0 1,1 0,98 a49,49 0 1,1 0,-98" /></svg>');
    background-repeat: no-repeat;
    background-size: contain;
    opacity: 0.5;
    pointer-events: none;
}

/* Main Content */
.main-content {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    min-height: calc(100vh - 80px);
    padding: 80px 0;
}

.content-container {
    display: grid;
    grid-template-columns: 3fr 2fr;
    gap: 50px;
    align-items: center;
    position: relative;
    z-index: 2;
}

.content-text h1 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: var(--black);
}

.content-text p {
    font-size: 1.1rem;
    margin-bottom: 30px;
    color: #555;
    line-height: 1.8;
}

.content-image {
    position: relative;
}

/* Programs Section */
.programs {
    background-color: var(--white);
    padding: 80px 0;
}

.programs-title {
    text-align: center;
    margin-bottom: 50px;
}

.programs-title h2 {
    font-size: 2rem;
    margin-bottom: 15px;
    color: var(--black);
}

.programs-title p {
    color: #666;
    max-width: 700px;
    margin: 0 auto;
}

.programs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.program-card {
    background-color: var(--light-green);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.program-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.program-content {
    padding: 25px;
}

.program-content h3 {
    font-size: 1.4rem;
    margin-bottom: 15px;
    color: var(--primary-color);
}

.program-content ul {
    margin-bottom: 20px;
}

.program-content ul li {
    margin-bottom: 10px;
    display: flex;
    align-items: center;
}

.program-content ul li i {
    color: var(--primary-color);
    margin-left: 10px;
}

/* Features Section */
.features {
    background-color: var(--gray);
    padding: 80px 0;
}

.features-title {
    text-align: center;
    margin-bottom: 60px;
}

.features-title h2 {
    font-size: 2rem;
    margin-bottom: 15px;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
}

.feature-item {
    text-align: center;
    padding: 20px;
}

.feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: var(--light-green);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.feature-icon i {
    font-size: 2rem;
    color: var(--primary-color);
}

.feature-item h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--black);
}

.feature-item p {
    color: #666;
}

/* CTA Section */
.cta {
    background-color: var(--primary-color);
    color: white;
    padding: 80px 0;
    text-align: center;
}

.cta h2 {
    font-size: 2.2rem;
    margin-bottom: 20px;
}

.cta p {
    font-size: 1.2rem;
    margin-bottom: 30px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
}

.cta .btn {
    background-color: white;
    color: var(--primary-color);
    padding: 12px 30px;
    font-size: 1.1rem;
}

.cta .btn:hover {
    background-color: var(--light-green);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 30px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 5px 25px rgba(0,0,0,0.2);
    animation: modalopen 0.3s;
}

@keyframes modalopen {
    from {opacity: 0; transform: translateY(-50px);}
    to {opacity: 1; transform: translateY(0);}
}

.close {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 1.5rem;
    cursor: pointer;
    color: #aaa;
    transition: color 0.3s;
}

.close:hover {
    color: var(--black);
}

.modal-title {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: var(--primary-color);
}

.modal-form input,
.modal-form textarea,
.modal-form select {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
}

.modal-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

.modal-form .btn {
    width: 100%;
    padding: 12px;
    font-size: 1.1rem;
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
@media (max-width: 768px) {
    .mobile-menu-btn {
        display: block;
    }
    
    .nav-menu {
        position: fixed;
        top: 70px;
        right: -100%;
        flex-direction: column;
        background-color: var(--white);
        width: 80%;
        height: calc(100vh - 70px);
        padding: 20px;
        transition: right 0.3s ease;
        box-shadow: -5px 0 15px rgba(0,0,0,0.1);
    }
    
    .nav-menu.active {
        right: 0;
    }
    
    .content-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .content-text h1 {
        font-size: 1.8rem;
    }
    
    .islamic-pattern {
        max-width: 50%;
    }
    
    .programs-grid {
        grid-template-columns: 1fr;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .modal-content {
        margin: 20% auto;
        padding: 20px;
    }
}

    </style>



    <!-- Main Content -->
    <section class="main-content">
        <div class="islamic-pattern"></div>
        <div class="container content-container">
            <div class="content-text">
                <h1>ندرس و نهتم بالأقسام التمهيدية</h1>
                <p>توفر في جمعية العلماء المسلمين برامج تمهيدية متكاملة تهدف إلى تأسيس الطالب في مختلف العلوم الشرعية واللغوية، مع التركيز على بناء قاعدة معرفية قوية تمهد لهم طريق التعلم العميق. سواء كنت في بداية رحلتك العلمية أو تسعى لتعزيز فهمك، سنجد بيئة تعليمية تدعمك وتوجهك نحو التميز.</p>
                <button class="btn" id="learnMoreBtn">تعرف المزيد</button>
            </div>
            <div class="content-image">
                <div class="img-placeholder" style="height: 350px;">
                    <i class="fas fa-mosque fa-4x"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="programs">
        <div class="container">
            <div class="programs-title">
                <h2>برامجنا التمهيدية</h2>
                <p>تقدم جمعية العلماء المسلمين مجموعة متنوعة من البرامج التمهيدية المصممة لتلبية احتياجات جميع الطلاب</p>
            </div>
            <div class="programs-grid">
                <div class="program-card">
                    <div class="program-content">
                        <h3>برنامج تأسيس العلوم الشرعية</h3>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> دراسة أساسيات الفقه الإسلامي</li>
                            <li><i class="fas fa-check-circle"></i> أصول التفسير والحديث</li>
                            <li><i class="fas fa-check-circle"></i> العقيدة الإسلامية الصحيحة</li>
                            <li><i class="fas fa-check-circle"></i> السيرة النبوية وتاريخ الإسلام</li>
                        </ul>
                        <button class="btn program-btn" data-program="شرعية">سجل الآن</button>
                    </div>
                </div>
                <div class="program-card">
                    <div class="program-content">
                        <h3>برنامج اللغة العربية</h3>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> النحو والصرف</li>
                            <li><i class="fas fa-check-circle"></i> البلاغة والأدب</li>
                            <li><i class="fas fa-check-circle"></i> مهارات الكتابة والخطابة</li>
                            <li><i class="fas fa-check-circle"></i> تاريخ اللغة العربية وآدابها</li>
                        </ul>
                        <button class="btn program-btn" data-program="لغوية">سجل الآن</button>
                    </div>
                </div>
                <div class="program-card">
                    <div class="program-content">
                        <h3>برنامج حفظ وتجويد القرآن</h3>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> أحكام التجويد الأساسية</li>
                            <li><i class="fas fa-check-circle"></i> منهجية الحفظ السليم</li>
                            <li><i class="fas fa-check-circle"></i> مخارج الحروف وصفاتها</li>
                            <li><i class="fas fa-check-circle"></i> أساليب القراءة الصحيحة</li>
                        </ul>
                        <button class="btn program-btn" data-program="قرآن">سجل الآن</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="features-title">
                <h2>مميزات الدراسة في الأقسام التمهيدية</h2>
            </div>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>أساتذة متخصصون</h3>
                    <p>نخبة من المشايخ والأساتذة ذوي الخبرة والتخصص في مجالاتهم</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3>مناهج حديثة</h3>
                    <p>مناهج معتمدة تجمع بين الأصالة والمعاصرة وفق منهجية متدرجة</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>شهادات معتمدة</h3>
                    <p>شهادات معترف بها تؤهلك لمواصلة الدراسة في المراحل المتقدمة</p>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>مرونة في الأوقات</h3>
                    <p>جداول دراسية مرنة تناسب مختلف الفئات والأعمار والظروف</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>سارع بالتسجيل في برامجنا التمهيدية</h2>
            <p>انضم الآن إلى جمعية العلماء المسلمين واستفد من البرامج التعليمية المتميزة والمنهج العلمي الرصين</p>
            <button class="btn" id="joinNowBtn">سجل الآن</button>
        </div>
    </section>

    <!-- Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="modal-title">تسجيل في البرنامج التمهيدي</h2>
            <form class="modal-form">
                <label for="fullname">الاسم الكامل</label>
                <input type="text" id="fullname" placeholder="أدخل اسمك الكامل" required>
                
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" placeholder="أدخل بريدك الإلكتروني" required>
                
                <label for="phone">رقم الهاتف</label>
                <input type="tel" id="phone" placeholder="أدخل رقم هاتفك" required>
                
                <label for="program">البرنامج</label>
                <select id="program" required>
                    <option value="">اختر البرنامج</option>
                    <option value="شرعية">برنامج تأسيس العلوم الشرعية</option>
                    <option value="لغوية">برنامج اللغة العربية</option>
                    <option value="قرآن">برنامج حفظ وتجويد القرآن</option>
                </select>
                
                <label for="message">ملاحظات إضافية</label>
                <textarea id="message" rows="4" placeholder="أي ملاحظات أو استفسارات"></textarea>
                
                <button type="submit" class="btn">إرسال الطلب</button>
            </form>
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

   
</body>
</html>
