    
    
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