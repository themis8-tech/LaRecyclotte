import '../../css/pages/homepage.scss';

// SLIDER
new Splide( '.splide', {
	perPage: 3,
    perMove: 1,
    breakpoints: {
        992: {
            perPage: 2,
        },
        768: {
            perPage: 1,
        },
    },
    rewind: true,
    pagination: false,
} ).mount();