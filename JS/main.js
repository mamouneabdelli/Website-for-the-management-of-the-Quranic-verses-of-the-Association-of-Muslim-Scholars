<!-- JavaScript for Popup -->

    // Get registration button
    var registerBtn = document.querySelector('.cta-button button');
    var popup = document.getElementById('registrationPopup');
    
   
    registerBtn.addEventListener('click', function() {
        popup.classList.add('active');
    });
    
    // Function to close popup
    function closePopup() {
        popup.classList.remove('active');
    }
    
    
    function updateTime() {
        var timeElement = document.getElementById('currentTime');
        var now = new Date();
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        timeElement.textContent = hours + ':' + minutes;
    }
    
    
    updateTime();
    setInterval(updateTime, 60000);

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
        }, 500); // 0.5 second delay between animations هنا كان تحب تبدل الوقت تاع انيميشن
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


document.addEventListener('DOMContentLoaded', function() {
   
    const popup = document.getElementById('registrationPopup');
    
    
    const registerButtons = document.querySelectorAll('.cta-button button');
    
    const moreInfoButtons = document.querySelectorAll('button:not(.close-btn):not([type="submit"])');
    
    
    registerButtons.forEach(button => {
     
        if (button.textContent.includes('سجّل') || button.textContent.includes('سجل')) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                // Open the popup
                popup.classList.add('active');
            });
        }
    });
    

    moreInfoButtons.forEach(button => {
        if (button.textContent.trim() === 'تعرف المزيد') {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = 'index2.html';
            });
        }
    });
    
   
    const closeBtn = document.querySelector('.close-btn');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            popup.classList.remove('active');
        });
    }
    
  
    popup.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.classList.remove('active');
        }
    });
    
   
    function updateTime() {
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            timeElement.textContent = hours + ':' + minutes;
        }
    }
    
   
    updateTime();
    setInterval(updateTime, 60000);
    
    
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && popup.classList.contains('active')) {
            popup.classList.remove('active');
        }
    });
    
  
});;
