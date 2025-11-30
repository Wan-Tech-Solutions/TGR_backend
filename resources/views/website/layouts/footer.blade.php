<footer id="footer" class="footer-reveal border-0 mt-0" style="background-image: url('{{ asset('img/footer.jpg') }}'); background-size: cover; background-position: center; background-attachment: fixed; position: relative;">
	<!-- Overlay for better text contrast -->
	<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.75); z-index: 1;"></div>
	
	<div class="container container-xl-custom py-5" style="position: relative; z-index: 2;">
		<div class="row py-5">
			<div class="col-md-6 col-lg-4 mb-4 mb-lg-0">
				<a href="{{ route('home') }}" class="logo d-block mb-3">
					<img alt="TGR Logo" src="{{ asset('logo.png') }}" height="50">
				</a>
				<p class="text-3-5 pe-1" style="text-align: justify;">
					Our primary focus is to facilitate engagement between the African Diaspora and Africa on a business and investment level, fostering sustainable long-term development.
				</p>

				<h5 class="text-4 font-weight-bold mb-3 mt-4">Newsletter</h5>
				<p class="text-3-5">Stay informed with our latest news and updates.</p>
				@if(session('newsletter_success'))
					<div class="alert alert-success">{{ session('newsletter_success') }}</div>
				@endif
				@if($errors->has('email'))
					<div class="alert alert-danger">{{ $errors->first('email') }}</div>
				@endif
				<form id="newsletterForm" action="{{ route('newsletter.subscribe') }}" method="POST" class="me-4 mb-3 mb-md-0">
					@csrf
					<div class="input-group">
						<input class="form-control form-control-sm bg-color-dark-scale-2 border-0 rounded-0" placeholder="Email Address" name="email" id="newsletterEmail" type="email" required />
						<button class="btn btn-primary text-color-light px-3 rounded-0" type="submit">
							<i class="fas fa-paper-plane"></i>
						</button>
					</div>
				</form>
			</div>

			<div class="col-md-6 col-lg-2 mb-4 mb-lg-0">
				<h5 class="text-4 font-weight-bold mb-3">Quick Links</h5>
				<ul class="list list-icons list-icons-sm">
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('home') }}" class="link-hover-style-1 ms-1"> Home</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('about.founder') }}" class="link-hover-style-1 ms-1"> About Us</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('advisory.seminar') }}" class="link-hover-style-1 ms-1"> Advisory</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('news') }}" class="link-hover-style-1 ms-1"> News</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('contact') }}" class="link-hover-style-1 ms-1"> Contact</a></li>
				</ul>
			</div>

			<div class="col-md-6 col-lg-3 mb-4 mb-md-0">
				<h5 class="text-4 font-weight-bold mb-3">Our Services</h5>
				<ul class="list list-icons list-icons-sm">
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('features.consult') }}" class="link-hover-style-1 ms-1"> One-on-One Consultation</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('advisory.brainstorm') }}" class="link-hover-style-1 ms-1"> Business</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('advisory.seminar') }}" class="link-hover-style-1 ms-1"> TGR Seminars</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('advisory.analytic') }}" class="link-hover-style-1 ms-1"> Investment</a></li>
					<li><i class="fas fa-angle-right text-color-primary"></i><a href="{{ route('request-prospectus') }}" class="link-hover-style-1 ms-1"> Investor Prospectus</a></li>
				</ul>
			</div>

			<div class="col-md-6 col-lg-3">
				<h5 class="text-4 font-weight-bold mb-3">Connect With Us</h5>
				<ul class="list list-icons list-icons-lg">
					<li class="mb-1">
						<i class="far fa-envelope text-color-primary"></i>
						<p class="m-0"><a href="mailto:info@tgrafrica.com" class="text-3-5">info@tgrafrica.com</a></p>
					</li>
					<li class="mb-1">
						<i class="fab fa-whatsapp text-color-primary"></i>
						<p class="m-0"><a href="tel:+233500200335" class="text-3-5">+233 500 200 335</a></p>
					</li>
				</ul>
				<ul class="social-icons social-icons-clean-with-border social-icons-medium mt-3">
					<li class="social-icons-facebook">
						<a href="https://web.facebook.com/profile.php?id=61559081140764" target="_blank" title="Facebook" data-cursor-effect-hover="fit">
							<img src="{{ asset('fa.png') }}" alt="Facebook" style="width: 100%; height: 100%; object-fit: cover;">
						</a>
					</li>
					<li class="social-icons-twitter-x">
						<a href="http://www.twitter.com/" target="_blank" title="Twitter" data-cursor-effect-hover="fit">
							<img src="{{ asset('x.png') }}" alt="Twitter" style="width: 100%; height: 100%; object-fit: cover;">
						</a>
					</li>
					<li class="social-icons-linkedin">
						<a href="http://www.linkedin.com/" target="_blank" title="LinkedIn" data-cursor-effect-hover="fit">
							<img src="{{ asset('lin.png') }}" alt="LinkedIn" style="width: 100%; height: 100%; object-fit: cover;">
						</a>
					</li>
					<li class="social-icons-youtube">
						<a href="https://www.youtube.com/channel/UCnl1Z1PExMQGPiwUEhbQCWQ" target="_blank" title="YouTube" data-cursor-effect-hover="fit">
							<img src="{{ asset('u.png') }}" alt="YouTube" style="width: 100%; height: 100%; object-fit: cover;">
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer-copyright" style="position: relative; z-index: 2; background: rgba(0, 0, 0, 0.5); border-top: 1px solid rgba(255, 255, 255, 0.1);">
		<div class="container container-xl-custom py-2">
			<div class="row">
				<div class="col-lg-12 text-center my-3">
					<p class="text-3-5">
						© Copyright {{ \Carbon\Carbon::now()->year }}. All Rights Reserved. | By <a href="http://www.wantechsolutions.com" class="text-color-primary" target="_blank">Wan Tech Solutions</a>
					</p>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 d-flex align-items-center justify-content-center">
					<nav>
						<ul class="list-inline">
							<li class="list-inline-item px-2">
								<a href="javascript:void(0)" class="text-3-5">FAQ's</a>
							</li>
							<li class="list-inline-item px-2 border-start border-color-light-3">
								<a href="javascript:void(0)" class="text-3-5">Sitemap</a>
							</li>
							<li class="list-inline-item px-2 border-start border-color-light-3">
								<a href="{{ route('contact') }}" class="text-3-5">Contact Us</a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</footer>

<style>
	#footer .footer-ribbon {
		display: none;
	}

	#footer .logo img {
		transition: opacity 0.2s ease-in-out;
	}

	#footer .logo:hover img {
		opacity: 0.8;
	}

	#footer h5 {
		color: #FFF;
	}

	#footer .list-icons a {
		color: #c0c0c0;
		transition: color 0.2s ease-in-out;
	}

	#footer .list-icons a:hover {
		color: var(--primary);
	}

	#footer .social-icons a {
		background: transparent !important;
		border-color: rgba(255, 255, 255, 0.2) !important;
		color: rgba(255, 255, 255, 0.7) !important;
		width: 40px;
		height: 40px;
	}

	#footer .social-icons a:hover {
		background: var(--primary) !important;
		border-color: var(--primary) !important;
		color: #FFF !important;
	}

	.footer-copyright a {
		transition: color 0.2s ease-in-out;
	}

	.footer-copyright a:hover {
		color: #FFF !important;
	}
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
	const form = document.getElementById('newsletterForm');
	if (!form) return;

	form.addEventListener('submit', function(e){
		e.preventDefault();
		const submitBtn = form.querySelector('button[type="submit"]');
		if (submitBtn) submitBtn.disabled = true;

		const formData = new FormData(form);
		const tokenMeta = document.querySelector('meta[name="csrf-token"]');
		const csrfToken = tokenMeta ? tokenMeta.getAttribute('content') : formData.get('_token');

		fetch(form.action, {
			method: 'POST',
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'X-CSRF-TOKEN': csrfToken
			},
			body: formData,
			credentials: 'same-origin'
		}).then(async (res) => {
			if (submitBtn) submitBtn.disabled = false;

			if (res.status === 201 || res.ok) {
				let data = {};
				try { data = await res.json(); } catch(_) {}
				showNewsletterMessage(data.message || 'Thank you — you have been subscribed to our newsletter.', 'success');
				form.reset();
				return;
			}

			if (res.status === 422) {
				let data = {};
				try { data = await res.json(); } catch(_) {}
				const err = data.errors?.email?.[0] || 'Validation error';
				showNewsletterMessage(err, 'danger');
				return;
			}

			if (res.status === 419) {
				showNewsletterMessage('Session expired — please reload the page and try again.', 'danger');
				return;
			}

			const text = await res.text();
			showNewsletterMessage('Error: ' + (text || res.statusText || res.status), 'danger');
		}).catch((err) => {
			if (submitBtn) submitBtn.disabled = false;
			console.error('Newsletter submit error', err);
			showNewsletterMessage('Network error — please try again.', 'danger');
		});
	});

	function showNewsletterMessage(message, type) {
		const existing = document.getElementById('newsletterMessage');
		if (existing) existing.remove();
		const div = document.createElement('div');
		div.id = 'newsletterMessage';
		div.className = 'alert ' + (type === 'success' ? 'alert-success' : 'alert-danger');
		div.textContent = message;
		const formContainer = form.parentNode;
		formContainer.insertBefore(div, form);
		setTimeout(() => { const el = document.getElementById('newsletterMessage'); if (el) el.remove(); }, 8000);
	}
});
</script>