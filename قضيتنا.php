<?php

require_once __DIR__ . "/config/app.php";
require_once __DIR__ . "/template/header.php";
?>
    <style>
    
        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .popup-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            text-align: center;
            position: relative;
            direction: rtl;
        }
        
        .close-popup {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #555;
        }
        
        .palestine-flag {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 20px;
            display: block;
        }
        
        .donation-form {
            margin-top: 20px;
        }
        
        .donation-form input, .donation-form select {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .donation-form button {
            background-color: #00A841;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(90deg); }
    }
    .rotating-image {
        animation:spin 8s linear infinite;
        transform-origin: center center;
    }

    </style>

    
    <section class="hero-section">
        <div class="hero-content">
            <div class="quote">
                <h2>● قال رسول الله صلى الله عليه و سلم ●</h2>
                <p>"من لم يغز أو يجهِز غازيا أو يخلف غازيا في أهله بخير، أصابه اللَّه بقارعة قبل يوم القيامة</p>
                <p>رواه مسلم</p>
            </div>
            <div class="sub-heading">
                <p style="font-family: Inter; font-weight: 400; font-size: 20px; line-height: 150%; letter-spacing: 0px; text-align: center;">
                    نؤمن بأن القضية الفلسطينية ليست مجرد قضية شعب، بل هي قضية أمة
                    بأكملها، قضية حق وعدل. نحن نساند فلسطين بكل ما نملك بالكلمة، بالدعاء
                    ، وبنشر الوعي لأن الحرية حق، والظلم إلى زوال
                    . ستظل القدس عاصمة القلوب، وفلسطين رمز العزة والصمود.
                </p>
            </div>
            <div class="cta-button">
                <button id="donateButton">دعم قضيتك</button>
            </div>
        </div>
        <div class="decorative-image-1"class="rotating-image">
            <img src="d6540cd37f0613635a757705639e5310 (1).png" alt="زخرفة إسلامية"class="rotating-image">
        </div>
        <div class="decorative-image-2">
            <img src="d6540cd37f0613635a757705639e5310 (1).png" class="rotating-image"alt="زخرفة إسلامية">
        </div>
    </section>

    <!-- Donation Popup -->
    <div class="popup-overlay" id="donationPopup">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            
    
            <svg class="palestine-flag" viewBox="0 0 900 600" xmlns="http://www.w3.org/2000/svg">
                
                <rect width="900" height="200" fill="#000000" />
            
                <rect y="200" width="900" height="200" fill="#FFFFFF" />
        
                <rect y="400" width="900" height="200" fill="#009900" />
                
                <polygon points="0,0 0,600 450,300" fill="#FF0000" />
            </svg>
            
            <h2>تبرع لدعم أهلنا المستضعفين  في غزةو فلسطين</h2>
            <p>ساهم معنا في دعم الشعب الفلسطيني في محنته. كل تبرع مهما كان صغيراً يصنع فرقاً كبيراً.</p>
            
            <div class="donation-form">
                <input type="text" placeholder="الاسم الكامل" required>
                <input type="email" placeholder="البريد الإلكتروني" required>
                <input type="tel" placeholder="رقم الهاتف">
                <select>
                    <option value="" disabled selected>اختر قيمة التبرع</option>
                    <option value="10">10 دولار</option>
                    <option value="25">25 دولار</option>
                    <option value="50">50 دولار</option>
                    <option value="100">100 دولار</option>
                    <option value="custom">قيمة أخرى</option>
                </select>
                <input type="number" placeholder="قيمة أخرى (دولار)">
                <button>تبرع الآن</button>
            </div>
        </div>
    </div>

    <script>
       
        const donateButton = document.getElementById('donateButton');
        const donationPopup = document.getElementById('donationPopup');
        const closePopup = document.querySelector('.close-popup');
        
       
        donateButton.addEventListener('click', function() {
            donationPopup.style.display = 'flex';
        });
        
        
        closePopup.addEventListener('click', function() {
            donationPopup.style.display = 'none';
        });
        
        
        window.addEventListener('click', function(event) {
            if (event.target === donationPopup) {
                donationPopup.style.display = 'none';
            }
        });
    </script>
</body>
</html>
