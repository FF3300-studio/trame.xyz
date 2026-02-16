import Lenis from '@studio-freight/lenis'
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import './text-effects.js'
import './logotype.js'

const lenis = new Lenis({
  duration: 1.2,
  easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
  direction: 'vertical', // SOLO verticale per non interferire con carousel orizzontale
  gestureDirection: 'vertical', // SOLO verticale
  smooth: true,
  mouseMultiplier: 1,
  smoothTouch: false,
  touchMultiplier: 2,
})

lenis.on('scroll', (e) => {
  // console.log(e)
})

function raf(time) {
  lenis.raf(time)
  requestAnimationFrame(raf)
}

requestAnimationFrame(raf)

// /* FILTERS */

// jQuery(document).ready(function(){
//     var filtercontainer = document.querySelector('.filters-container-collection');
//     var filteritems;
//     if (filtercontainer) {
//         filteritems = mixitup(filtercontainer, {
//             controls: {
//                 toggleDefault: 'all',
//                 toggleLogic: 'or'
//             },
//             selectors: {
//                 control: '[data-mixitup-control]'
//             },
//             animation: {
//                 enable: false
//             },
//             multifilter: {
//                 enable: true, 
//                 logicWithinGroup: 'and',
//                 logicBetweenGroups: 'and'
//             },
//         });
//     }
// });

/* LAZY LOADER 

var lazyLoadInstance = new LazyLoad({
    elements_selector: ".lazy",
}); */

/* CONTENT HEIGHT CALCULATION */


/* ANCHORS NAVIGATION */

jQuery( ".collapse-link" ).click(function() {
    console.log("collapse");
});

/* PASS SLIDER */

jQuery(document).ready(function() {
    const sliders = document.querySelectorAll('.block-cards-list');

    sliders.forEach(function(sliderEl) {
        const nextEl = sliderEl.querySelector('.swiper-button-next');
        const prevEl = sliderEl.querySelector('.swiper-button-prev');

        const options = {
            spaceBetween: 30,  // Space between slides in px
            grabCursor: true,  // Allows dragging
            loop: true,        // Optional: Enables continuous loop
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
              },
        };

        if (nextEl && prevEl) {
            options.navigation = {
                nextEl: nextEl,
                prevEl: prevEl,
            };
        }

        new Swiper(sliderEl, options);
    });
});

/* MOBILE NAVIGATION */

document.addEventListener("DOMContentLoaded", function () {
    const toggler = document.querySelector(".navbar-toggler");
    const menu = document.querySelector(".navigation-mobile");
    const menuLinks = document.querySelectorAll('.navigation-mobile a, .close-menu');
  
    if (toggler && menu) {
      toggler.addEventListener("click", function () {
        toggler.classList.toggle("closed");
        menu.classList.toggle("visible");
        
        const isVisible = menu.classList.contains("visible");
        
        if (isVisible) {
          document.body.classList.add("no-scroll");
          if (typeof lenis !== 'undefined') lenis.stop();
        } else {
          document.body.classList.remove("no-scroll");
          if (typeof lenis !== 'undefined') lenis.start();
        }
      });

      // Close menu when a link is clicked
      menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            toggler.classList.remove("closed");
            menu.classList.remove("visible");
            document.body.classList.remove("no-scroll");
            if (typeof lenis !== 'undefined') lenis.start();
        });
      });
    }
});
  
  /* HEADER HEIGHT CALCULATION */
  function updateHeaderHeight() {
    const header = document.querySelector('.site-header');
    if (header) {
      const height = header.offsetHeight;
      document.documentElement.style.setProperty('--header-height', height + 'px');
    }
  }
  
  window.addEventListener('load', updateHeaderHeight);
  window.addEventListener('resize', updateHeaderHeight);
  document.addEventListener('DOMContentLoaded', updateHeaderHeight);
