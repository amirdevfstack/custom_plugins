jQuery(document).ready(function($) {
    $(".container").slick({
        dots: false,
        infinite: true,
        arrows: false,
        speed: 200,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false,
                },
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: false,
                },
            },
            {
                breakpoint: 800,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
             {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    $('.previous').click(function(){
        $('.container').slick('slickPrev');
    });

    $('.next').click(function(){
        $('.container').slick('slickNext');
    });
	
	
//  swiper slider js
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1, // Show 3 slides at a time on larger screens
  slidesPerGroup: 1, // Scroll 1 slide per click
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    // When the screen width is less than or equal to 768px
    768: {
      slidesPerView: 3, // Show 1 slide at a time on mobile
      slidesPerGroup: 1, // Scroll 1 slide per click
    }
  }
});

function initializeCountdowns() {
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(countdown => {
        const drawDateStr = countdown.getAttribute('data-draw-date');
        const drawDate = parseDate(drawDateStr).getTime();

        const daysSpan = countdown.querySelector('.days');
        const hoursSpan = countdown.querySelector('.hours');
        const minutesSpan = countdown.querySelector('.minutes');
        const secondsSpan = countdown.querySelector('.seconds');

        function parseDate(dateStr) {
            const parts = dateStr.split('-');
            if (parts.length !== 3) {
                console.error('Date format is incorrect');
                return new Date();
            }
            const month = parseInt(parts[0], 10) - 1;
            const day = parseInt(parts[1], 10);
            const year = parseInt(parts[2], 10);
            return new Date(year, month, day);
        }

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = drawDate - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                countdown.innerHTML = 'The draw has ended';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            daysSpan.textContent = days;
            hoursSpan.textContent = hours;
            minutesSpan.textContent = minutes;
            secondsSpan.textContent = seconds;
        }

        const timerInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    });
}

initializeCountdowns(); // Initialize on page load

// Reinitialize after Elementor's AJAX content is loaded
document.addEventListener('elementor/popup/show', initializeCountdowns);

	
        // const countdowns = document.querySelectorAll('.countdown');
    
        // countdowns.forEach(countdown => {
        //     const drawDateStr = countdown.getAttribute('data-draw-date');
        //     const drawDate = parseDate(drawDateStr).getTime();
    
        //     const daysSpan = countdown.querySelector('.days');
        //     const hoursSpan = countdown.querySelector('.hours');
        //     const minutesSpan = countdown.querySelector('.minutes');
        //     const secondsSpan = countdown.querySelector('.seconds');
    
        //     function parseDate(dateStr) {
        //         const parts = dateStr.split('-');
        //         if (parts.length !== 3) {
        //             console.error('Date format is incorrect');
        //             return new Date();
        //         }
        //         const month = parseInt(parts[0], 10) - 1;
        //         const day = parseInt(parts[1], 10);
        //         const year = parseInt(parts[2], 10);
        //         return new Date(year, month, day);
        //     }
    
        //     function updateCountdown() {
        //         const now = new Date().getTime();
        //         const distance = drawDate - now;
    
        //         if (distance < 0) {
        //             clearInterval(timerInterval);
        //             countdown.innerHTML = 'The draw has ended';
        //             return;
        //         }
    
        //         const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //         const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //         const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //         const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
        //         daysSpan.textContent = days;
        //         hoursSpan.textContent = hours;
        //         minutesSpan.textContent = minutes;
        //         secondsSpan.textContent = seconds;
        //     }
    
        //     const timerInterval = setInterval(updateCountdown, 1000);
        //     updateCountdown();
        
        // });
	
	
	
	     var targetSoldPercentage = 80; 
    var currentPercentage = 0; 
    var animationSpeed = 20; 

    function animateSoldOut() {
        if (currentPercentage < targetSoldPercentage) {
            currentPercentage++;
            $('.progress-bar-fill').css('width', currentPercentage + '%');
            $('#sold-percentage').text(currentPercentage + '%');
            setTimeout(animateSoldOut, animationSpeed);
        }
    }

   
    animateSoldOut();

});


const startCountdown = () => {
    const endDate = new Date().getTime() + (5 * 24 * 60 * 60 + 10 * 60 * 60 + 45 * 60 + 50) * 1000;
    
    const updateTimer = () => {
        const currentTime = new Date().getTime();
        const timeRemaining = endDate - currentTime;

        const second = 1000;
        const minute = second * 60;
        const hour = minute * 60;
        const day = hour * 24;

        const daysLeft = Math.floor(timeRemaining / day);
        const hoursLeft = Math.floor((timeRemaining % day) / hour);
        const minutesLeft = Math.floor((timeRemaining % hour) / minute);
        const secondsLeft = Math.floor((timeRemaining % minute) / second);

        document.getElementById('days').innerText = daysLeft;
        document.getElementById('hours').innerText = hoursLeft;
        document.getElementById('minutes').innerText = minutesLeft;
        document.getElementById('seconds').innerText = secondsLeft;
    };

    setInterval(updateTimer, 1000);
};

startCountdown();
