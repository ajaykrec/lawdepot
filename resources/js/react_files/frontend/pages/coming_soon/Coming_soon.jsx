import React, { useState, useEffect } from 'react';
import { Head, useForm, usePage, Link } from '@inertiajs/react'
import anime from 'animejs/lib/anime.es.js';

const Coming_soon = (props)=>{  
	
	useEffect(()=> {
		anime({
			targets: document.getElementById('anime-01-Coming_soon'),
			"el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad"
		})
	},[props])	

  return (
		<>
		<Head>
			<title>Coming Soon!!</title>
			<meta name="description" content="" />			
		</Head>
		<section 
			className="cover-background overflow-auto full-screen position-relative"
			style={{backgroundImage:"url(frontend-assets/images/coming-soon-bg.jpg)"}}
			>
			<div
			id="particles-style-01"
			className="position-absolute h-100 top-0 left-0 w-100"
			data-particle="true"
			data-particle-options='{"particles":{"number":{"value":10,"density":{"enable":true,"value_area":800}},"color":{"value":"#b0b4e2"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":5},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":1,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":4,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":false,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true}'></div>

			<div className="container h-100">
			<div
			className="row align-items-center justify-content-center h-100 z-index-2 position-relative">
			<div style={{opacity:1}}
				className="col-md-12 col-lg-10 col-xl-8 col-xxl-7 text-center"
				id="anime-01-Coming_soon"
				>
				<a className="mb-10 md-mb-50px d-inline-block" href="index.html">
					<img
						src="frontend-assets/images/logo-black-big.png"
						data-at2x="frontend-assets/images/logo-black-big@2x.png"
						alt="" /></a>
					<h1 className="fw-700 fs-70 mb-10px text-dark-gray ls-minus-2px">Coming soon!</h1>
					<h6 className="text-dark-gray mb-0">We're getting ready to launch!</h6>
					<div className="countdown-style-03 mb-9 mt-9">
						<div data-enddate="2024/08/08 12:00:00" className="countdown"></div>
					</div>
					<div
						className="d-inline-block w-100 newsletter-style-03 position-relative mb-8 lg-mb-15 md-mb-6">
						<form
							action="email-templates/subscribe-newsletter.php"
							method="post"
							className="position-relative lg-w-100 w-80 mx-auto">
							<div className="position-relative">
								<input
									className="input-large bg-white border-color-transparent w-100 border-radius-5px box-shadow-extra-large form-control required"
									type="email"
									name="email"
									placeholder="Enter your email address"/>
								    <input type="hidden" name="redirect"/>
									<button
										className="btn btn-extra-large text-dark-gray ls-0px left-icon submit text-transform-none fw-600"
										aria-label="submit">
										<i className="icon feather icon-feather-mail icon-small align-middle"></i>
										<span>Notify me</span>
									</button>
								</div>
								<div
									className="form-results border-radius-100px mt-15px p-15px fs-15 w-100 text-center d-none"></div>
							</form>
							<p className="fs-14 mt-15px mb-0">Subscribe our newsletter to get update when it'll be live.</p>
						</div>
						<div className="elements-social social-icon-style-08">
							<ul className="medium-icon dark">
								<li className="mb-0">
									<a className="facebook" href="https://www.facebook.com/" target="_blank">
										<i className="fa-brands fa-facebook-f"></i>
									</a>
								</li>
								<li className="mb-0">
									<a className="dribbble" href="http://www.dribbble.com" target="_blank">
										<i className="fa-brands fa-dribbble"></i>
									</a>
								</li>
								<li className="mb-0">
									<a className="twitter" href="http://www.twitter.com" target="_blank">
										<i className="fa-brands fa-twitter"></i>
									</a>
								</li>
								<li className="mb-0">
									<a className="instagram" href="http://www.instagram.com" target="_blank">
										<i className="fa-brands fa-instagram"></i>
									</a>
								</li>
								<li className="mb-0">
									<a className="linkedin" href="http://www.linkedin.com" target="_blank">
										<i className="fa-brands fa-linkedin-in"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
		</>     
    );
  
}
export default Coming_soon;