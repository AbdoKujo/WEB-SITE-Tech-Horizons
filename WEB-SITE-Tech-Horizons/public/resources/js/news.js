    document.getElementById('themeSelector').addEventListener('change', function() {
    window.location.href = this.value;
    });

    window.addEventListener('scroll',()=>{
        if(window.scrollY>50){
            header.classList.add('sticky')
        }
        else{
            header.classList.remove('sticky')
        }
    })    

    // Slider functionality
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

