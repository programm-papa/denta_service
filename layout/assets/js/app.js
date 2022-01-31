const swiper = new Swiper('.top-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: ".top-swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.top-swiper-button-next',
        prevEl: '.top-swiper-button-prev',
    },
});

const aboutSwiper = new Swiper('.about-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
        el: ".about-swiper-pagination",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.about-swiper-button-next',
        prevEl: '.about-swiper-button-prev',
    },
});

const teamSwiper = new Swiper('.team-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    slidesPerView: 4,
    spaceBetween: 20,
    // If we need pagination
    pagination: {
        el: ".team-swiper-pagination",
        clickable: true,
    },
});

$(document).ready(function() {
    if ($('.questions-wrapper').length > 0) {
        $('.questions-wrapper').each(function() {
            $(this).find('.question-block').each(function() {
                $(this).click(function() {
                    let height = $(this).find('.content').innerHeight();
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        let questionBody = $(this).find('.question-body');
                        questionBody.animate({
                            height: 0,
                        }, 700);
                    } else {
                        if ($('.question-block.active').length > 0) {
                            $('.question-block.active').find('.question-body').animate({
                                height: 0,
                            }, 700);
                            $('.question-block.active').removeClass('active');

                        }
                        $(this).addClass('active');
                        let questionBody = $(this).find('.question-body');
                        questionBody.animate({
                            height: height,
                        }, 700);
                    }
                })
            })
        })
    }
})