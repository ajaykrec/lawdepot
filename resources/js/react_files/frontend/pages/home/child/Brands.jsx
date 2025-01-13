import React, { useState, useEffect } from 'react';
import { useForm, usePage,  Link } from '@inertiajs/react'
import Parser, { domToReact } from 'html-react-parser';
import anime from 'animejs/lib/anime.es.js';
const Brands = ({ pageData }) => {    

    useEffect(()=> {      
        anime({
            targets: document.getElementById('anime-01-Brands'),
            "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
        })
        setupSwiper()
        
    },[])  
    
    var menuBreakPoint = 991;
    var sliderBreakPoint = 991; 
    var animeBreakPoint = 1199;
    var headerTransition = 300;  

    var lastScroll = 0,
    simpleDropdown = 0,
    linkDropdown = 0,
    isotopeObjs = [],
    swiperObjs = [];
    var windowScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    // Get window height
    function getWindowHeight() {
        return $(window).height();
    }

    // Get window width
    function getWindowWidth() {
        return $(window).width();
    }
    function setupSwiper() {
        // Swiper slider using params
        var swipers = document.querySelectorAll('[data-slider-options]:not(.instafeed-wrapper)');
        swipers.forEach(function (swiperItem) {
            var _this = $(swiperItem),
                    sliderOptions = _this.attr('data-slider-options');
            if (typeof (sliderOptions) !== 'undefined' && sliderOptions !== null) {

                sliderOptions = $.parseJSON(sliderOptions);

                // If user have provided "data-slide-change-on-click" attribute then below code will execute
                var changeOnClick = _this.attr('data-slide-change-on-click');
                if (changeOnClick != '' && changeOnClick != undefined && changeOnClick == '1') {

                    sliderOptions['on'] = {
                        click: function () {
                            if (this.activeIndex > this.clickedIndex) {
                                this.slidePrev();
                            } else if (this.activeIndex < this.clickedIndex) {
                                this.slideNext();
                            }
                        }
                    };
                }

                /* If user have provided "data-thumb-slider-md-direction" attribute then below code will execute */
                if (sliderOptions['thumbs'] != '' && sliderOptions['thumbs'] != undefined) {

                    var mdThumbDirection = _this.attr('data-thumb-slider-md-direction');
                    if (mdThumbDirection != '' && mdThumbDirection != undefined) {

                        var thumbDirection = (sliderOptions['thumbs']['swiper']['direction'] != '' && sliderOptions['thumbs']['swiper']['direction'] != undefined) ? sliderOptions['thumbs']['swiper']['direction'] : mdThumbDirection;
                        sliderOptions['thumbs']['swiper']['on'] = {
                            init: function () {
                                if (getWindowWidth() <= sliderBreakPoint) {
                                    this.changeDirection(mdThumbDirection);
                                } else {
                                    this.changeDirection(thumbDirection);
                                }
                                this.update();
                            },
                            resize: function () {
                                if (getWindowWidth() <= sliderBreakPoint) {
                                    this.changeDirection(mdThumbDirection);
                                } else {
                                    this.changeDirection(thumbDirection);
                                }
                                this.update();
                            },
                            click: function () {
                                /* Product thumbs automatic next / previous on click slide */
                                if (this.activeIndex == this.clickedIndex) {
                                    this.slidePrev();
                                } else {
                                    this.slideNext();
                                }
                            }
                        };
                    }
                }

                // If user have provided "data-number-pagination" attribute then below code will execute
                var numberPagination = _this.attr('data-number-pagination');
                if (numberPagination != '' && numberPagination != undefined && numberPagination == '1' && sliderOptions['pagination'] != '' && sliderOptions['pagination'] != undefined) {
                    sliderOptions['pagination']['renderBullet'] = function (index, className) {
                        return '<span class="' + className + '">' + pad(index + 1) + '</span>';
                    }
                }

                // If user have provided "data-thumbs" attribute then below code will execute
                var dataThumbs = _this.attr('data-thumbs');
                if (dataThumbs != '' && dataThumbs != undefined && sliderOptions['pagination'] != '' && sliderOptions['pagination'] != undefined) {
                    dataThumbs = $.parseJSON(dataThumbs);
                    if (typeof (dataThumbs) !== 'undefined' && dataThumbs !== null) {
                        sliderOptions['pagination']['renderBullet'] = function (index, className) {
                            return '<span class="' + className + '" style="background-image: url( ' + dataThumbs[index] + ' )"></span>';
                        }
                    }
                }

                sliderOptions['on'] = {
                    init: function () {
                        let slides = this.slides;
                        let activeIndex = this.activeIndex,
                                current_slide = this.slides[activeIndex],
                                anime_el = current_slide.querySelectorAll('[data-anime]'),
                                fancy_el = current_slide.querySelectorAll('[data-fancy-text]');

                        if (getWindowWidth() > animeBreakPoint) {
                            if (anime_el) {
                                anime_el.forEach(element => {
                                    let options = element.getAttribute('data-anime');

                                    if (typeof (options) !== 'undefined' && options !== null) {
                                        options = $.parseJSON(options);

                                        element.classList.add('appear');
                                        element.style.transition = "none";

                                        if (options.el) {
                                            for (let i = 0; i < element.children.length; i++) {
                                                element.children[i].style.transition = "none";
                                                element.children[i].classList.add('appear');
                                            }
                                        }
                                        animeAnimation(element, options);
                                        element.classList.remove('appear');
                                    }
                                });
                            }
                        }
                    },
                    slideChange: function () {
                        // Get active slide
                        let slides = this.slides;
                        let activeIndex = this.activeIndex,
                                current_slide = this.slides[activeIndex],
                                anime_el = current_slide.querySelectorAll('[data-anime]'),
                                fancy_el = current_slide.querySelectorAll('[data-fancy-text]');

                        if (getWindowWidth() > animeBreakPoint) {
                            if (fancy_el) {
                                fancy_el.forEach(element => {
                                    element.classList.add('appear');
                                    let fancy_options = element.getAttribute('data-fancy-text');
                                    if (typeof (fancy_options) !== 'undefined' && fancy_options !== null) {
                                        fancy_options = $.parseJSON(fancy_options);
                                        let child = element;

                                        FancyTextDefault(child, fancy_options);
                                        element.classList.remove('appear');
                                    }
                                });
                            }

                            if (anime_el) {
                                anime_el.forEach(element => {
                                    let options = element.getAttribute('data-anime');

                                    if (typeof (options) !== 'undefined' && options !== null) {
                                        options = $.parseJSON(options);

                                        element.classList.add('appear');
                                        element.style.transition = "none";

                                        if (options.el) {
                                            for (let i = 0; i < element.children.length; i++) {
                                                element.children[i].style.transition = "none";
                                                element.children[i].classList.add('appear');
                                            }
                                        }
                                        animeAnimation(element, options);
                                        element.classList.remove('appear');
                                    }
                                });
                            }
                        }
                    }
                };

                // If swiper has number navigation
                var isNumberPagination = _this.attr('data-swiper-number-line-pagination') || false;
                var isNumberNavigation = _this.attr('data-swiper-number-navigation') || false;
                var isNumberPaginationProgress = _this.attr('data-swiper-number-pagination-progress') || false;
                var showProgress = _this.attr('data-swiper-show-progress') || false;
                var hasGalleryBox = _this.attr('data-gallery-box') || false;
                if (isNumberPagination || isNumberNavigation || isNumberPaginationProgress || hasGalleryBox) {
                    sliderOptions['on'] = {
                        init: function () {
                            if (isNumberPagination || isNumberNavigation || isNumberPaginationProgress) {
                                if (sliderOptions.hasOwnProperty('loop') && sliderOptions['loop']) {
                                    var slideLength = this.slides.length;
                                }
                                var length = slideLength;
                                if (isNumberPaginationProgress) {
                                    _this.parent().find('.number-next').text('0' + length);
                                    _this.parent().find('.number-prev').text('01');
                                    _this.parent().find('.swiper-pagination-progress')[0].style.setProperty('--swiper-progress', (100 / length).toFixed(2) + '%');
                                } else {
                                    _this.parent().find('.number-next').text('02');
                                    _this.parent().find('.number-prev').text('0' + length);
                                    if (showProgress)
                                        _this.parent().find('.swiper-pagination-progress')[0].style.setProperty('--swiper-progress', (100 / length).toFixed(2) + '%');
                                }
                            }
                            if (typeof $.fn.magnificPopup === 'function') {
                                if (hasGalleryBox) {
                                    _this.magnificPopup({
                                        delegate: 'a',
                                        type: 'image',
                                        closeOnContentClick: true,
                                        closeBtnInside: false,
                                        gallery: {enabled: true}
                                    });
                                }
                            }
                        },
                        slideChange: function () {
                            if (isNumberPagination || isNumberNavigation || isNumberPaginationProgress) {
                                if (sliderOptions.hasOwnProperty('loop') && sliderOptions['loop']) {
                                    var slideLength = this.slides.length;
                                }
                                var length = this.slides.length,
                                        active = (this.realIndex) + 1,
                                        next = active + 1,
                                        prev = active - 1;
                                if (active == 1) {
                                    prev = length;
                                }
                                if (active == length) {
                                    next = 1;
                                }
                                if (isNumberPaginationProgress) {
                                    _this.parent().find('.number-prev').each(function () {
                                        $(this).text(active < 10 ? '0' + active : active);
                                    });
                                    _this.parent().find('.swiper-pagination-progress')[0].style.setProperty('--swiper-progress', ((100 / length) * active).toFixed(2) + '%');
                                } else {
                                    _this.parent().find('.number-next').each(function () {
                                        $(this).text(next < 10 ? '0' + next : next);
                                    });
                                    _this.parent().find('.number-prev').each(function () {
                                        $(this).text(prev < 10 ? '0' + prev : prev);
                                    });
                                    if (showProgress)
                                        _this.parent().find('.swiper-pagination-progress')[0].style.setProperty('--swiper-progress', ((100 / length) * active).toFixed(2) + '%');
                                }
                            }
                        }
                    }
                }

                // Move thumb slide on click in product page.
                var thumbClick = _this.attr('data-swiper-thumb-click') || false;
                if (thumbClick && sliderOptions.hasOwnProperty('thumbs')) {
                    sliderOptions['thumbs']['swiper']['on'] = {
                        click: function (swiper) {
                            if (swiper.activeIndex >= swiper.clickedIndex) {
                                swiper.slidePrev();
                            } else if (swiper.activeIndex < swiper.clickedIndex) {
                                swiper.slideNext();
                            }
                        }
                    }
                }

                if (typeof Swiper === 'function') {
                    _this.imagesLoaded(function () {
                        var swiperObj = new Swiper(swiperItem, sliderOptions);
                        swiperObjs.push(swiperObj);
                    });
                }
            }
        });
    }

  return (
    <>
    <section className="pt-4">
        <div className="container"> 
            <div className="row position-relative clients-style-08" id="anime-01-Brands">
                <div className="col swiper text-center feather-shadow" data-slider-options='{ "slidesPerView": 2, "spaceBetween":0, "speed": 4000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 } }, "effect": "slide" }'>
                    <div className="swiper-wrapper marquee-slide">
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-envato.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                      
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-pingdom.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                      
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-paypal.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-walmart.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-amazon.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-logitech.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-envato.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                        
                        <div className="swiper-slide">
                            <a href="#"><img src="frontend-assets/images/logo-pingdom.svg" className="h-40px xs-h-30px" alt="" /></a>
                        </div>
                      
                    </div> 
                </div>
            </div>
        </div>
    </section>
    </>
  )
}
export default Brands