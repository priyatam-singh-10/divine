<!DOCTYPE html>
<html lang="hi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Thank You | Divine Touch</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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

    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: var(--font-sans);
      background: var(--cream);
      color: var(--brown-dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── MAIN ── */
    .text-cream {
      color: var(--cream);
    }

    .ty-main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 1rem;
    }

    .ty-card {
      background: var(--white);
      border: 1px solid var(--cream-dark);
      border-radius: 20px;
      padding: 2.5rem 2rem;
      max-width: 520px;
      width: 100%;
      text-align: center;
      box-shadow: 0 8px 32px rgba(44, 36, 22, .10);
    }

    /* Check animation */
    .ty-check-wrap {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, #2d7a2d, #4caf50);
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.25rem;
      font-size: 2.2rem;
      box-shadow: 0 8px 24px rgba(45, 122, 45, .25);
      animation: pop-in .55s cubic-bezier(.68, -.55, .27, 1.55) both;
    }

    @keyframes pop-in {
      from {
        transform: scale(0);
        opacity: 0;
      }

      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .ty-title {
      font-family: var(--font-serif);
      font-size: 1.7rem;
      font-weight: 900;
      color: #4caf50;
      margin-bottom: .4rem;
    }

    .ty-subtitle {
      font-size: .9rem;
      color: var(--brown-secondary);
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    /* Order box */
    .ty-order-box {
      background: var(--cream-light);
      border: 1px solid var(--cream-dark);
      border-radius: 12px;
      padding: .9rem 1.1rem;
      margin-bottom: 1.5rem;
      text-align: left;
    }

    .ty-order-row {
      display: flex;
      justify-content: space-between;
      font-size: .82rem;
      padding: .28rem 0;
      border-bottom: 1px solid var(--cream-dark);
    }

    .ty-order-row:last-child {
      border-bottom: none;
    }

    .ty-order-row .ok {
      color: var(--brown-secondary);
    }

    .ty-order-row .ov {
      font-weight: 700;
      color: var(--brown-dark);
    }

    .ty-order-row .ov.gold {
      color: var(--gold);
    }

    /* What's next */
    .ty-steps {
      background: var(--cream);
      border: 1px solid var(--cream-dark);
      border-radius: 12px;
      padding: 1rem 1.1rem;
      margin-bottom: 1.5rem;
      text-align: left;
    }

    .ty-steps-title {
      font-size: .78rem;
      font-weight: 800;
      color: var(--brown-primary);
      text-transform: uppercase;
      letter-spacing: .07em;
      margin-bottom: .75rem;
    }

    .ty-step-item {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      margin-bottom: .6rem;
      font-size: .82rem;
      color: var(--brown-secondary);
    }

    .ty-step-item:last-child {
      margin-bottom: 0;
    }

    .ty-step-num {
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: var(--gold);
      color: var(--brown-dark);
      font-size: .68rem;
      font-weight: 800;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 1px;
    }

    /* CTA button */
    .ty-btn {
      display: block;
      width: 100%;
      padding: .85rem;
      border: none;
      border-radius: 10px;
      background: linear-gradient(135deg, var(--brown-primary), var(--gold));
      color: var(--white);
      font-family: var(--font-sans);
      font-weight: 800;
      font-size: .95rem;
      cursor: pointer;
      text-decoration: none;
      position: relative;
      overflow: hidden;
      transition: transform .2s;
      animation: cta-glow 2.5s ease-in-out infinite;
    }

    .ty-btn:hover {
      transform: translateY(-2px);
      color: var(--white);
    }

    @keyframes cta-glow {

      0%,
      100% {
        box-shadow: 0 4px 16px rgba(212, 175, 55, .4);
      }

      50% {
        box-shadow: 0 8px 32px rgba(212, 175, 55, .7);
      }
    }

    .ty-btn-shimmer {
      position: absolute;
      top: 0;
      left: -100%;
      width: 50%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .3), transparent);
      transform: skewX(-20deg);
      animation: shimmer 2.5s ease-in-out infinite;
    }

    @keyframes shimmer {
      0% {
        left: -100%;
      }

      60%,
      100% {
        left: 160%;
      }
    }

    .ty-note {
      font-size: .7rem;
      color: var(--brown-secondary);
      margin-top: .75rem;
    }
  </style>
</head>

<body>
  <!-- MAIN -->
  <div class="ty-main">
    <div class="ty-card">

      <div class="ty-check-wrap">
        <i class="bi bi-patch-check-fill text-cream"></i>
      </div>

      <h1 class="ty-title">
        <i class="bi bi-patch-check-fill me-2"></i>
        Payment Successful!
      </h1>
      <p class="ty-subtitle">
        आपकी seat confirm हो गई है।<br />
        Masterclass का joining link आपके WhatsApp पर भेज दिया जाएगा।
      </p>

      <!-- Order summary -->
      <div class="ty-order-box">
        <div class="ty-order-row">
          <span class="ok">Event</span>
          <span class="ov">2-Day Live Masterclass</span>
        </div>
        <div class="ty-order-row">
          <span class="ok">Amount Paid</span>
          <span class="ov gold">₹51 Only</span>
        </div>
      </div>

      <!-- What's next -->
      <div class="ty-steps">
        <p class="ty-steps-title">
          <i class="bi bi-card-checklist me-2"></i>
          What Happens Next?
        </p>
        <div class="ty-step-item">
          <span class="ty-step-num"><i class="bi bi-check fs-5 text-cream"></i></span>
          WhatsApp पर Joining Link, Session Schedule & Exclusive Bonus Resources मिलेंगे।
        </div>
      </div>

      <!-- CTA -->
      <a href="{{route('home')}}" class="ty-btn">
        <span class="ty-btn-shimmer"></span>
        <i class="bi bi-house-door-fill me-2"></i>
        Back to Homepage
      </a>

      <p class="ty-note fs-6">
        <i class="bi bi-whatsapp text-success me-2"></i>
        किसी भी सहायता के लिए, हमसे <span class="text-success">WhatsApp</span> पर कभी भी संपर्क करें।
      </p>

    </div>
  </div>

</body>

</html>