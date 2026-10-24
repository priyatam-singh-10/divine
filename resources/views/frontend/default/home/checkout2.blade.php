<!DOCTYPE html>
<html lang="hi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AI & Wealth Creation Webinar | Future Growth Blueprint</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('assets/favicon.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <style>
    :root {
      --brown-primary: #5C3E2F;
      --brown-secondary: #8B6F47;
      --brown-dark: #2C2416;
      --brown-darker: #3D2A1F;
      --gold: #D4AF37;
      --gold-light: #E5C76B;
      --cream: #FFF8E7;
      --cream-dark: #F5E6D3;
      --cream-light: #FDF8F1;
      --coral: #F84C74;
      --white: #FFFFFF;
      --font-sans: 'Inter', system-ui, sans-serif;
      --font-serif: 'Playfair Display', Georgia, serif;
    }

    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-sans);
      background: var(--cream);
      color: var(--brown-dark);
      overflow-x: hidden;
      min-height: 100vh;
    }

    /* ── NAVBAR ── */
    #navbar {
      position: sticky;
      top: 0;
      z-index: 999;
      background: var(--white);
      border-bottom: 1px solid var(--cream-dark);
      padding: 0 2rem;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 1px 4px rgba(44, 36, 22, .08);
    }

    .nav-logo {
      display: flex;
      align-items: center;
      gap: 6px;
      font-weight: 700;
      font-size: 1rem;
      color: var(--brown-dark);
      text-decoration: none;
      font-family: var(--font-serif);
    }

    .nav-logo .star { color: var(--gold); font-size: 1.1rem; }
    .nav-logo-accent { color: var(--gold); margin-left: 2px; font-weight: 700; }

    .nav-secure-badge {
      display: flex;
      align-items: center;
      gap: 6px;
      background: #f0faf0;
      border: 1px solid #b7dfb7;
      border-radius: 20px;
      padding: 4px 14px;
      font-size: .75rem;
      font-weight: 600;
      color: #2d7a2d;
    }

    .nav-back {
      font-size: .78rem;
      color: var(--brown-secondary);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 4px;
      transition: color .2s;
    }

    .nav-back:hover { color: var(--gold); }

    /* ── COUNTDOWN BAR ── */
    #countdown-bar {
      background: var(--brown-dark);
      padding: 10px 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }

    .cd-label {
      font-size: .75rem;
      color: var(--cream-dark);
      letter-spacing: .06em;
      font-weight: 600;
    }

    .cd-blocks {
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .cd-unit {
      display: flex;
      flex-direction: column;
      align-items: center;
      background: var(--brown-darker);
      border: 1px solid var(--brown-secondary);
      padding: 5px 10px;
      border-radius: 6px;
      min-width: 50px;
    }

    .cd-num {
      font-size: 1.3rem;
      font-weight: 900;
      color: var(--white);
      font-variant-numeric: tabular-nums;
      line-height: 1;
    }

    .cd-unit small {
      font-size: .48rem;
      color: var(--gold-light);
      letter-spacing: .1em;
      margin-top: 2px;
    }

    .cd-colon {
      font-size: 1.3rem;
      font-weight: 900;
      color: var(--brown-secondary);
    }

    .seat-warn {
      font-size: .75rem;
      color: var(--coral);
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    .blink-dot {
      width: 7px;
      height: 7px;
      background: var(--coral);
      border-radius: 50%;
      animation: blink 1s infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: .2; }
    }

    /* ── MAIN LAYOUT ── */
    #main {
      max-width: 1100px;
      margin: 0 auto;
      padding: 2rem 1.5rem;
      display: grid;
      grid-template-columns: 1fr 420px;
      gap: 1.75rem;
      align-items: start;
    }

    /* ── ORDER SUMMARY CARD ── */
    .order-card {
      background: var(--white);
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--cream-dark);
      box-shadow: 0 4px 20px rgba(44, 36, 22, .07);
      position: sticky;
      top: 80px;
    }

    .order-card-header {
      background: linear-gradient(135deg, var(--brown-dark), var(--brown-darker));
      padding: 1.25rem 1.5rem;
    }

    .order-header-badge {
      display: inline-block;
      background: var(--gold);
      color: var(--brown-dark);
      font-size: .6rem;
      font-weight: 800;
      letter-spacing: .1em;
      padding: 2px 10px;
      border-radius: 20px;
      margin-bottom: .6rem;
      text-transform: uppercase;
    }

    .order-event-name {
      font-family: var(--font-serif);
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--white);
      line-height: 1.3;
      margin-bottom: .3rem;
    }

    .order-event-sub {
      font-size: .75rem;
      color: var(--gold-light);
      font-weight: 500;
    }

    .order-card-body { padding: 1.25rem 1.5rem; }

    .order-detail-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: .55rem 0;
      border-bottom: 1px solid var(--cream-dark);
      font-size: .83rem;
    }

    .order-detail-row:last-of-type { border-bottom: none; }
    .order-detail-label { color: var(--brown-secondary); }
    .order-detail-val { font-weight: 600; color: var(--brown-dark); }
    .order-detail-val.date-val { color: var(--gold); }

    .price-breakdown {
      background: var(--cream-light);
      border-radius: 10px;
      padding: 1rem 1.1rem;
      margin: .75rem 0;
      border: 1px solid var(--cream-dark);
    }

    .pb-row {
      display: flex;
      justify-content: space-between;
      font-size: .82rem;
      padding: .3rem 0;
    }

    .pb-row .pb-label { color: var(--brown-secondary); }
    .pb-row .pb-val { color: var(--brown-dark); font-weight: 500; }
    .pb-row.strike .pb-val { text-decoration: line-through; color: #aaa; }
    .pb-row.discount .pb-val { color: #2d7a2d; font-weight: 700; }

    .pb-divider {
      height: 1px;
      background: var(--cream-dark);
      margin: .5rem 0;
    }

    .pb-row.total { font-weight: 800; font-size: .95rem; }
    .pb-row.total .pb-label { color: var(--brown-dark); }
    .pb-row.total .pb-val { color: var(--gold); font-size: 1.1rem; }

    /* ── SEATS COUNTER ── */
    .seats-box {
      margin-top: 1rem;
      background: #fff5f5;
      border: 1px solid #ffd5d5;
      border-radius: 10px;
      padding: .75rem .9rem;
      display: flex;
      align-items: center;
      gap: .75rem;
    }

    .seats-icon { font-size: 1.2rem; }

    .seats-info { flex: 1; }

    .seats-text {
      font-size: .75rem;
      font-weight: 700;
      color: #c0392b;
    }

    .seats-bar-bg {
      background: #f5e5e5;
      border-radius: 20px;
      height: 6px;
      margin-top: 4px;
      overflow: hidden;
    }

    .seats-bar-fill {
      width: 70.6%;
      height: 100%;
      background: linear-gradient(90deg, #8b1a1a, #e74c3c);
      border-radius: 20px;
      transition: width 1s ease;
    }

    .seats-booked {
      font-size: .65rem;
      color: #aaa;
      white-space: nowrap;
      text-align: right;
    }

    /* ── INFO CARD (Left) ── */
    .info-card {
      background: var(--white);
      border-radius: 16px;
      border: 1px solid var(--cream-dark);
      box-shadow: 0 4px 20px rgba(44, 36, 22, .06);
    }
    .info-card .order-card-header, .info-card-body{
      padding: 1.5rem;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
    }
    .user-info-display {
      background: var(--cream-light);
      border: 1px solid var(--cream-dark);
      border-radius: 12px;
      padding: 1rem 1.25rem;
      margin-bottom: 1.25rem;
    }

    .user-info-row {
      display: flex;
      align-items: center;
      gap: .6rem;
      padding: .4rem 0;
      font-size: .88rem;
    }

    .user-info-row + .user-info-row {
      border-top: 1px solid var(--cream-dark);
    }

    .user-info-label {
      font-size: .72rem;
      font-weight: 600;
      color: var(--brown-secondary);
      min-width: 110px;
      text-transform: uppercase;
      letter-spacing: .04em;
    }

    .user-info-val {
      font-weight: 700;
      color: var(--brown-dark);
    }

    .section-title {
      font-family: var(--font-serif);
      font-size: 1.1rem;
      font-weight: 800;
      color: var(--brown-dark);
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .step-num {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--gold);
      color: var(--brown-dark);
      font-size: .8rem;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }


    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1rem;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .form-label {
      font-size: .78rem;
      font-weight: 600;
      color: var(--brown-primary);
    }
    .form-input {
      width: 100%;
      padding: .65rem .85rem;
      border: 1.5px solid var(--cream-dark);
      border-radius: 8px;
      font-size: .88rem;
      color: var(--brown-dark);
      background: var(--cream-light);
      transition: border-color .2 ease, box-shadow .2 ease;
      outline: none;
    }
    .form-input:focus {
      border-color: var(--gold);
      box-shadow: 0 0 0 3px rgba(212, 175, 55, .15);
      background: var(--white);
    }
    .form-input::placeholder {
      color: var(--brown-secondary);
      font-size: .82rem;
      opacity: .7;
    }
    .field-hint {
      font-size: .68rem;
      color: var(--brown-secondary);
      margin-top: 2px;
    }
    .field-error {
      font-size: .68rem;
      color: var(--coral);
      margin-top: 4px;
      display: none;
  }

    /* ── PAY BUTTON ── */
    .pay-now-btn {
      width: 100%;
      padding: 1rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      background: linear-gradient(135deg, var(--brown-primary), var(--gold), var(--brown-primary));
      background-size: 200% 100%;
      color: var(--white);
      font-family: var(--font-sans);
      font-weight: 900;
      font-size: 1.1rem;
      letter-spacing: .04em;
      position: relative;
      overflow: hidden;
      animation: cta-pulse 2.5s ease-in-out infinite;
      transition: transform .2s;
    }

    .pay-now-btn:hover { transform: translateY(-2px); }

    @keyframes cta-pulse {
      0%, 100% { box-shadow: 0 4px 18px rgba(212, 175, 55, .4); }
      50% { box-shadow: 0 8px 36px rgba(212, 175, 55, .7); }
    }

    .pay-shimmer {
      position: absolute;
      top: 0;
      left: -100%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,.3), transparent);
      transform: skewX(-20deg);
      animation: shimmer 2.5s ease-in-out infinite;
    }

    @keyframes shimmer {
      0% { left: -100%; }
      60%, 100% { left: 160%; }
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      #main { grid-template-columns: 1fr; }
    }
    @media (max-width:767px){
      .order-card {
        position: unset;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav id="navbar">
    <a href="" class="nav-logo">
      <img src="https://divinetouch.info/public/assets/logo.png" alt="logo" width="118px">
    </a>
    <div class="nav-secure-badge d-none d-md-block">
      <i class="bi bi-shield-lock-fill"></i> 100% Secure Checkout
    </div>
    <a href="#" class="nav-back">← Back to Homepage</a>
  </nav>

  <!-- COUNTDOWN -->
  <div id="countdown-bar">
    <div class="cd-label"><i class="bi bi-clock-fill"></i> OFFER EXPIRES IN</div>
    <div class="cd-blocks">
      <div class="cd-unit"><span class="cd-num" id="cd-d">02</span><small>DAYS</small></div>
      <span class="cd-colon">:</span>
      <div class="cd-unit"><span class="cd-num" id="cd-h">08</span><small>HRS</small></div>
      <span class="cd-colon">:</span>
      <div class="cd-unit"><span class="cd-num" id="cd-m">21</span><small>MIN</small></div>
      <span class="cd-colon">:</span>
      <div class="cd-unit"><span class="cd-num" id="cd-s">11</span><small>SEC</small></div>
    </div>
    <div class="seat-warn">
      <div class="blink-dot"></div> Only <strong id="seats-warn-num" class="mx-1">147</strong> seats left!
    </div>
  </div>

  <!-- MAIN -->
  <main id="main">
    <div class="info-card">
      <div class="order-card-header">
        <span class="order-header-badge">
          <i class="bi bi-receipt-cutoff me-1"></i> ORDER SUMMARY
        </span>
        <p class="order-event-name">Mentally Unstoppable Masterclass<br />2-Day Live Transformational Program</p>
        <p class="order-event-sub mb-0">By Dr. Mahaveer Gautam • AI Wealth Psychologist</p>
      </div>
      <div class="info-card-body">
        <h2 class="section-title">
          <span class="step-num">1</span> Your Details
        </h2>

        <!-- Fetched user info display -->
        @php
            $lead = session('lead_purchase');
        @endphp
        <div class="user-info-display d-none">
          <div class="user-info-row">
            <span class="user-info-label">
              <i class="bi bi-person-fill me-1"></i> Full Name
            </span>          
            <span class="user-info-val" id="display-name">—</span>
          </div>
          <div class="user-info-row">            
            <span class="user-info-label">
              <i class="bi bi-telephone-fill me-1"></i> Phone
            </span>
            <span class="user-info-val" id="display-phone">—</span>
          </div>
        </div>
        <div class="user-info-display">
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="fullname">Full Name </label>
              <input type="text" class="form-input" id="fullname" name="fullname" value="{{ session('lead_purchase.user_name', '') }}" placeholder="Rahul Sharma" maxlength="30" autocomplete="name" />
              <span class="field-error" id="fullname-err">Please enter your full name</span>
            </div>
            <div class="form-group">
              <label class="form-label" for="phone">Phone Number </label>
              <input type="tel" class="form-input" id="phone" value="{{ session('lead_purchase.mobile', '') }}" name="mobile" placeholder="98765 43210" autocomplete="tel" maxlength="10" />
              <span class="field-error" id="phone-err">Please enter a valid 10-digit number</span>
            </div>
          </div>
        </div>

        <h2 class="section-title">
          <span class="step-num">2</span> Payment
        </h2>

        <div class="text-center">
          <img src="{{asset('assets/upi.png')}}" class="p-1" alt="payment" width="60%">
        </div>

        <button type="button" class="pay-now-btn" id="payNowBtn" value="51">
          <span class="pay-shimmer"></span>
          <i class="bi bi-shield-lock-fill me-2"></i>
          PAY SECURELY ₹51 NOW
        </button>
      </div>
    </div>

    <!-- RIGHT: ORDER SUMMARY -->
    <div class="order-card">
      <div class="order-card-header d-none">
        <span class="order-header-badge">
          <i class="bi bi-receipt-cutoff me-1"></i> ORDER SUMMARY
        </span>
        <p class="order-event-name">Mentally Unstoppable Masterclass<br />2-Day Live Transformational Program</p>
        <p class="order-event-sub">By Dr. Mahaveer Gautam • AI Wealth Psychologist</p>
      </div>

      <div class="order-card-body">
        <div class="order-detail-row">
          <span class="order-detail-label">
            <i class="bi bi-broadcast-pin me-1"></i> Mode
          </span>
          <span class="order-detail-val">Live Online (Zoom)</span>
        </div>
        <div class="order-detail-row">
          <span class="order-detail-label">
            <i class="bi bi-clock-fill me-1"></i> Duration
          </span>
          <span class="order-detail-val">2 Days • 4–6 hrs/day</span>
        </div>

        <div class="price-breakdown">
            <div class="pb-row strike">
                <span class="pb-label">Original Price</span>
                <span class="pb-val">₹1,999</span>
            </div>      
            <div class="pb-row discount">
                <span class="pb-label">
                    <i class="bi bi-tags-fill me-1"></i> Special Discount
                </span>
                <span class="pb-val">– ₹1,948</span>
            </div>      
            <div class="pb-divider"></div>      
            <div class="pb-row total">
                <span class="pb-label">Total Payable</span>
                <span class="pb-val">₹51</span>
            </div>
        </div>

        <div class="seats-box">
            <span class="seats-icon">
                <i class="bi bi-fire text-danger"></i>
            </span>      
            <div class="seats-info">
                <p class="seats-text">
                    Only <span id="order-seats-left">147</span> seats remaining!
                </p>      
                <div class="seats-bar-bg">
                    <div class="seats-bar-fill" id="order-progress" style="width:70.6%;"></div>
                </div>
            </div>      
            <span class="seats-booked">
                <span id="order-booked">353</span>/500<br>
                booked
            </span>
        </div>
      </div>
    </div>
  </main>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script>
    $(function () {

      // ===== NAME FIELD =====
      const enrollName = document.getElementById('fullname');

      enrollName.addEventListener('input', function () {
          this.value = this.value.replace(/[^A-Za-z\s]/g, '');
      });

      // ===== PHONE FIELD =====
      const phoneInput = document.getElementById('phone');

      phoneInput.addEventListener('input', function () {
          this.value = this.value.replace(/\D/g, '').slice(0, 10);
      });

      // ===== VALIDATION =====
      function validate() {
          let ok = true;

          function err(id, msg) {
              $('#' + id + '-err').text(msg).show();
              $('#' + id).addClass('error');
              ok = false;
          }

          function clr(id) {
              $('#' + id + '-err').hide();
              $('#' + id).removeClass('error');
          }

          // Name Validation
          const name = $('#fullname').val().trim();

          if (name.length < 3) {
              err('fullname', 'Name must be at least 3 characters long');
          } else if (!/^[A-Za-z\s]+$/.test(name)) {
              err('fullname', 'Only letters and spaces are allowed');
          } else {
              clr('fullname');
          }

          // Phone Validation
          const phone = $('#phone').val().trim();

          if (!/^\d{10}$/.test(phone)) {
              err('phone', 'Please enter a valid 10-digit mobile number');
          } else {
              clr('phone');
          }

          // Checkbox Validation
        //   if (!$('#tnc-check').is(':checked')) {
        //       $('#tnc-err').show();
        //       ok = false;
        //   } else {
        //       $('#tnc-err').hide();
        //   }

          return ok;
      }

      // ===== PAY NOW =====
    //   $('#payNowBtn').on('click', function () {
    //       if (!validate()) {
    //           $('html,body').animate({
    //               scrollTop: $('.form-input.error:first').offset().top - 100
    //           }, 400);
    //           return;
    //       }
    //       // Payment code here
    //   });
     $('#payNowBtn').on('click', function () {
    
        // Validation
        if (!validate()) {
    
            let errorField = $('.error:first');
    
            if (errorField.length) {
                $('html,body').animate({
                    scrollTop: errorField.offset().top - 100
                }, 400);
            }
    
            return;
        }
    
    
        $.ajax({
            url: "{{ route('leads.order') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                fullName: $('#fullname').val(),
                mobile: $('#phone').val(),
                amount: $('#payNowBtn').val()
            },
            success: function(response) {
        
                console.log(response);
        
                var options = {
                    key: "{{ env('RAZORPAY_KEY') }}",
                    amount: response.amount,
                    currency: "INR",
                    order_id: response.order_id,
        
                    prefill: {
                        name: $('#fullname').val(),
                        contact: $('#phone').val()
                    },
        
                    handler: function(paymentResponse) {
        
                        $.ajax({
                            url: "{{ route('leads.payment.success') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                razorpay_order_id: paymentResponse.razorpay_order_id,
                                razorpay_signature: paymentResponse.razorpay_signature
                            },
                            success: function(res) {
                            
                                if (res.status) {
                                    window.location.href = res.redirect_url;
                                }
        
                            }
                        });
                    }
                };
        
                var rzp = new Razorpay(options);
                rzp.open();
            }
        });
    });

      /* ── COUNTDOWN ── */
      var deadline = new Date("September 05, 2026 20:00:00");
      function pad(n) {
          return String(n).padStart(2, '0');
      }
      function tick() {
          var diff = deadline - new Date();
          if (diff <= 0) {
              $('#cd-d').text('00');
              $('#cd-h').text('00');
              $('#cd-m').text('00');
              $('#cd-s').text('00');
              return;
          }
          $('#cd-d').text(pad(Math.floor(diff / 86400000)));
          $('#cd-h').text(pad(Math.floor((diff % 86400000) / 3600000)));
          $('#cd-m').text(pad(Math.floor((diff % 3600000) / 60000)));
          $('#cd-s').text(pad(Math.floor((diff % 60000) / 1000)));
      }
      tick();
      setInterval(tick, 1000);

      /* ── RIPPLE ── */
      $(document).on('click', '.pay-now-btn', function (e) {
        var off = $(this).offset(), x = e.pageX - off.left, y = e.pageY - off.top;
        var r = $('<span>').css({
          position: 'absolute', left: x, top: y, width: 0, height: 0,
          borderRadius: '50%', background: 'rgba(255,255,255,.3)',
          transform: 'translate(-50%,-50%)', pointerEvents: 'none'
        });
        $(this).append(r);
        r.animate({ width: '500px', height: '500px', opacity: 0 },
          { duration: 700, complete: function () { $(this).remove(); } });
      });

    });
  </script>

</body>
</html>
