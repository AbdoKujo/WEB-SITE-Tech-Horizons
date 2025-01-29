document.querySelectorAll('.slider-container').forEach(container => {
            const slider = container.querySelector('.slider');
            const prevBtn = container.querySelector('.prev');
            const nextBtn = container.querySelector('.next');
            let slideIndex = 0;

            function showSlide(index) {
                slider.style.transform = `translateX(-${index * 100}%)`;
            }

            prevBtn.addEventListener('click', (e) => {
                e.preventDefault();
                slideIndex = Math.max(slideIndex - 1, 0);
                showSlide(slideIndex);
            });

            nextBtn.addEventListener('click', (e) => {
                e.preventDefault();
                slideIndex = Math.min(slideIndex + 1, slider.children.length - 1);
                showSlide(slideIndex);
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Slider functionality
            const sliders = document.querySelectorAll('.slider-container');
            
            sliders.forEach(container => {
                const slider = container.querySelector('.slider');
                const prevBtn = container.querySelector('.prev');
                const nextBtn = container.querySelector('.next');
                const items = slider.querySelectorAll('.slider-item');
                
                let currentIndex = 0;
                
                function updateSliderPosition() {
                    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
                }
                
                function showNextSlide() {
                    if (currentIndex < items.length - 1) {
                        currentIndex++;
                        updateSliderPosition();
                    }
                }
                
                function showPrevSlide() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateSliderPosition();
                    }
                }
                
                // Event listeners for navigation
                prevBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showPrevSlide();
                });
                
                nextBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    showNextSlide();
                });
                
                // Optional: Keyboard navigation
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowLeft') {
                        showPrevSlide();
                    } else if (e.key === 'ArrowRight') {
                        showNextSlide();
                    }
                });
                
                // Optional: Touch support
                let touchStartX = 0;
                let touchEndX = 0;
                
                slider.addEventListener('touchstart', (e) => {
                    touchStartX = e.touches[0].clientX;
                });
                
                slider.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].clientX;
                    
                    if (touchStartX - touchEndX > 50) {
                        showNextSlide();
                    } else if (touchEndX - touchStartX > 50) {
                        showPrevSlide();
                    }
                });
            });
        });