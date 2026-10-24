document.addEventListener('DOMContentLoaded', () => {
  // 1. Header Scroll Shadow
  const header = document.getElementById('header');
  window.addEventListener('scroll', () => {
    if (!header) return;
    if (window.scrollY > 10) {
      header.classList.add('shadow-md');
    } else {
      header.classList.remove('shadow-md');
    }
  }, { passive: true });

  // 2. Mobile Menu
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      const open = !mobileMenu.classList.contains('hidden');
      menuBtn.setAttribute('aria-expanded', String(open));
      menuBtn.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      const icon = menuBtn.querySelector('i');
      if(mobileMenu.classList.contains('hidden')) {
        icon.classList.remove('fa-xmark');
        icon.classList.add('fa-bars');
      } else {
        icon.classList.remove('fa-bars');
        icon.classList.add('fa-xmark');
      }
    });
    mobileMenu.querySelectorAll('a').forEach((a) => {
      a.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        menuBtn.querySelector('i').classList.replace('fa-xmark', 'fa-bars');
      });
    });
  }

  // 3. Scroll Reveal via IntersectionObserver
  const reveals = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-blur, .stagger, .draw-line');
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
    reveals.forEach((el) => io.observe(el));
  } else {
    reveals.forEach((el) => el.classList.add('visible'));
  }

  // 4. Counter Animation for CRM
  const counters = document.querySelectorAll('.counter');
  const animateCounter = (el) => {
    const target = Number(el.dataset.target || 0);
    const duration = 2000;
    const start = performance.now();
    const step = (now) => {
      const p = Math.min((now - start) / duration, 1);
      const easeP = 1 - Math.pow(1 - p, 3); // Cubic ease out
      const val = Math.floor(target * easeP);
      el.textContent = val.toLocaleString('en-IN');
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  };

  if ('IntersectionObserver' in window && counters.length) {
    const cio = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          cio.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    counters.forEach((c) => cio.observe(c));
  }

  // 5. CRM Interactive Tabs (Auto & Manual)
  const crmTabs = document.querySelectorAll('.crm-tab');
  const crmPanels = document.querySelectorAll('.crm-panel');
  let currentCrmTab = 0;
  let crmInterval;

  function switchCrmTab(index) {
    crmTabs.forEach((tab, i) => {
      if (i === index) {
        // Activate Tab
        tab.classList.add('border-brand', 'bg-brandSoft', 'shadow-md');
        tab.classList.remove('border-slate-200', 'bg-white', 'shadow-sm');
        tab.querySelector('div.rounded-full').classList.replace('bg-slate-50', 'bg-white');
        tab.querySelector('div.rounded-full').classList.replace('border-slate-100', 'border-brand/20');
        
        // Show Panel
        crmPanels[i].classList.remove('hidden');
        
        // Retrigger CSS animations inside panel
        const animatedElements = crmPanels[i].querySelectorAll('.anim-pipeline-card, .anim-chat-up, .anim-float-icon');
        animatedElements.forEach(el => {
          el.style.animation = 'none';
          el.offsetHeight; // trigger reflow
          el.style.animation = null;
        });

      } else {
        // Deactivate Tab
        tab.classList.remove('border-brand', 'bg-brandSoft', 'shadow-md');
        tab.classList.add('border-slate-200', 'bg-white', 'shadow-sm');
        tab.querySelector('div.rounded-full').classList.replace('bg-white', 'bg-slate-50');
        tab.querySelector('div.rounded-full').classList.replace('border-brand/20', 'border-slate-100');
        
        // Hide Panel
        crmPanels[i].classList.add('hidden');
      }
    });
  }

  function nextCrmTab() {
    if(!crmTabs.length) return;
    currentCrmTab = (currentCrmTab + 1) % crmTabs.length;
    switchCrmTab(currentCrmTab);
  }

  if (crmTabs.length > 0) {
    // Start auto-rotate every 5 seconds
    crmInterval = setInterval(nextCrmTab, 5000);
    
    crmTabs.forEach((tab, index) => {
      tab.addEventListener('mouseenter', () => {
        clearInterval(crmInterval); // Pause on hover
        currentCrmTab = index;
        switchCrmTab(index);
      });
      tab.addEventListener('mouseleave', () => {
        clearInterval(crmInterval);
        crmInterval = setInterval(nextCrmTab, 5000); // Resume
      });
    });
  }

  // 6. FAQ Accordion Logic
  document.querySelectorAll('.faq-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.faq-item');
      const panel = item.querySelector('.faq-panel');
      const isOpen = !panel.classList.contains('hidden');

      // Close all others
      document.querySelectorAll('.faq-item').forEach((fi) => {
        fi.querySelector('.faq-panel').classList.add('hidden');
        fi.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
      });

      // Toggle current
      if (!isOpen) {
        panel.classList.remove('hidden');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  // 7. Success modal controls
  //    Submission itself lives in register.js, which calls the real API and
  //    opens this modal only after the server confirms the registration.
  const successModal = document.getElementById('successModal');
  const closeSuccess = document.getElementById('closeSuccess');
  const successDone = document.getElementById('successDone');

  const hideSuccess = () => {
    if (!successModal) return;
    successModal.classList.remove('is-open');
    document.body.style.overflow = '';
    setTimeout(() => {
      successModal.classList.add('hidden');
      successModal.classList.remove('flex');
    }, 300);
  };

  if (closeSuccess) closeSuccess.addEventListener('click', hideSuccess);
  if (successDone) successDone.addEventListener('click', hideSuccess);
  if (successModal) {
    successModal.addEventListener('click', (e) => {
      if (e.target === successModal) hideSuccess();
    });
  }
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && successModal && !successModal.classList.contains('hidden')) {
      hideSuccess();
    }
  });

  /* Community links are not live yet */
  document.querySelectorAll('[data-community]').forEach((el) => {
    el.addEventListener('click', (e) => {
      if (el.getAttribute('href') === '#') {
        e.preventDefault();
        const original = el.innerHTML;
        el.innerHTML = '<i class="fa-solid fa-clock"></i><span>Community link coming soon</span>';
        setTimeout(() => { el.innerHTML = original; }, 1800);
      }
    });
  });

  // 8. FOMO Popup Logic
  const fomoPopup = document.getElementById('fomoPopup');
  const closePopup = document.getElementById('closePopup');
  const fomoContent = document.getElementById('fomoContent');
  
  if (fomoPopup && closePopup) {
    // Show popup after 4 seconds
    setTimeout(() => {
      fomoPopup.classList.remove('hidden');
      fomoPopup.classList.add('flex');
      // Trigger fade in
      requestAnimationFrame(() => {
        fomoPopup.classList.remove('opacity-0');
        fomoContent.classList.remove('scale-95');
      });
    }, 4000);

    // Close logic
    closePopup.addEventListener('click', () => {
      fomoPopup.classList.add('opacity-0');
      fomoContent.classList.add('scale-95');
      setTimeout(() => {
        fomoPopup.classList.add('hidden');
        fomoPopup.classList.remove('flex');
      }, 300);
    });
  }

  // 9. Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            e.preventDefault();
            targetElement.scrollIntoView({ behavior: 'smooth' });
        }
    });
  });


  /* ============================================================
     10. Scroll progress bar
     ============================================================ */
  const progress = document.getElementById('scrollProgress');
  if (progress) {
    const updateProgress = () => {
      const h = document.documentElement;
      const max = h.scrollHeight - h.clientHeight;
      const pct = max > 0 ? (h.scrollTop / max) * 100 : 0;
      progress.style.width = pct + '%';
    };
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);
    updateProgress();
  }

  /* ============================================================
     11. Respect reduced motion for all JS-driven motion
     ============================================================ */
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isMobile = window.matchMedia('(max-width: 767px)').matches;

  /* ============================================================
     12. Parallax drift on hero + section illustrations
     ============================================================ */
  if (!reduceMotion && !isMobile) {
    const parallaxEls = document.querySelectorAll('.anim-float-main, .anim-gift');
    let ticking = false;
    const runParallax = () => {
      parallaxEls.forEach((el, i) => {
        const rect = el.getBoundingClientRect();
        const centre = rect.top + rect.height / 2 - window.innerHeight / 2;
        const shift = Math.max(-28, Math.min(28, centre * -0.045));
        el.style.setProperty('--px', shift.toFixed(2) + 'px');
        el.style.translate = '0 ' + shift.toFixed(2) + 'px';
      });
      ticking = false;
    };
    window.addEventListener('scroll', () => {
      if (!ticking) { requestAnimationFrame(runParallax); ticking = true; }
    }, { passive: true });
    runParallax();
  }

  /* ============================================================
     13. Magnetic / tilt effect on primary CTA buttons
     ============================================================ */
  if (!reduceMotion && !isMobile) {
    document.querySelectorAll('.btn-glow').forEach((btn) => {
      btn.addEventListener('mousemove', (e) => {
        const r = btn.getBoundingClientRect();
        const x = (e.clientX - r.left - r.width / 2) / r.width;
        const y = (e.clientY - r.top - r.height / 2) / r.height;
        btn.style.transform = 'translate(' + (x * 8).toFixed(1) + 'px,' + (y * 6 - 2).toFixed(1) + 'px)';
      });
      btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
    });
  }

  /* ============================================================
     14. Floating particles inside dark sections
     ============================================================ */
  if (!reduceMotion) {
    const darkSections = document.querySelectorAll('#bonuses');
    darkSections.forEach((sec) => {
      const count = isMobile ? 8 : 18;
      for (let i = 0; i < count; i++) {
        const dot = document.createElement('span');
        dot.className = 'particle';
        const size = 2 + Math.random() * 4;
        dot.style.width = size + 'px';
        dot.style.height = size + 'px';
        dot.style.left = Math.random() * 100 + '%';
        dot.style.bottom = (-10 + Math.random() * 40) + '%';
        dot.style.animationDuration = (9 + Math.random() * 10) + 's';
        dot.style.animationDelay = (Math.random() * 10) + 's';
        dot.style.opacity = 0.25 + Math.random() * 0.5;
        sec.appendChild(dot);
      }
    });
  }

  /* ============================================================
     15. Counter flash class while counting
     ============================================================ */
  document.querySelectorAll('.counter').forEach((c) => {
    const obs = new MutationObserver(() => {
      c.classList.add('counting');
      clearTimeout(c._flashT);
      c._flashT = setTimeout(() => c.classList.remove('counting'), 400);
    });
    obs.observe(c, { childList: true, characterData: true, subtree: true });
  });

  /* ============================================================
     16. Sticky header shrink + hide-on-scroll-down
     ============================================================ */
  (() => {
    const hdr = document.getElementById('header');
    if (!hdr) return;
    let lastY = window.scrollY;
    hdr.style.transition = 'transform 0.35s cubic-bezier(0.22,1,0.36,1), box-shadow 0.3s ease';
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      if (y > 400 && y > lastY + 6) {
        hdr.style.transform = 'translateY(-105%)';
      } else if (y < lastY - 6 || y < 200) {
        hdr.style.transform = 'translateY(0)';
      }
      lastY = y;
    }, { passive: true });
  })();

  /* ============================================================
     17. Ripple feedback on all CTA clicks
     ============================================================ */
  if (!reduceMotion) {
    document.querySelectorAll('a[href="#register"], .btn-glow, button[type="submit"]').forEach((el) => {
      el.addEventListener('click', function (e) {
        const r = this.getBoundingClientRect();
        const ink = document.createElement('span');
        const d = Math.max(r.width, r.height);
        ink.style.cssText =
          'position:absolute;border-radius:50%;pointer-events:none;transform:scale(0);' +
          'background:rgba(255,255,255,.45);width:' + d + 'px;height:' + d + 'px;left:' +
          (e.clientX - r.left - d / 2) + 'px;top:' + (e.clientY - r.top - d / 2) + 'px;' +
          'animation:inkRipple .6s ease-out forwards;';
        if (getComputedStyle(this).position === 'static') this.style.position = 'relative';
        this.style.overflow = 'hidden';
        this.appendChild(ink);
        setTimeout(() => ink.remove(), 620);
      });
    });
    const st = document.createElement('style');
    st.textContent = '@keyframes inkRipple{to{transform:scale(2.4);opacity:0}}';
    document.head.appendChild(st);
  }

  /* ============================================================
     18. Auto-update copyright year
     ============================================================ */
  (() => {
    const yr = document.getElementById('yr');
    if (yr) yr.textContent = new Date().getFullYear();
  })();


  /* ============================================================
     19. Webinar countdown (29 October 2026, 8:00 PM IST)
     ============================================================ */
  (() => {
    // IST is UTC+5:30 -> 20:00 IST == 14:30 UTC
    const TARGET = new Date(Date.UTC(2026, 9, 29, 14, 30, 0));
    const widgets = Array.from(document.querySelectorAll('[data-countdown]'));
    if (!widgets.length) return;

    const pad = (n) => String(n).padStart(2, '0');
    const prev = new WeakMap();

    const setPart = (el, val) => {
      if (!el) return;
      const txt = pad(val);
      if (prev.get(el) === txt) return;
      prev.set(el, txt);
      el.textContent = txt;
      el.classList.remove('cd-tick');
      void el.offsetWidth;
      el.classList.add('cd-tick');
    };

    const tick = () => {
      const diff = TARGET.getTime() - Date.now();

      if (diff <= 0) {
        widgets.forEach((w) => {
          w.querySelectorAll('[data-cd]').forEach((el) => { el.textContent = '00'; });
          const lbl = w.querySelector('p');
          if (lbl) lbl.textContent = 'The webinar has started';
        });
        clearInterval(timer);
        return;
      }

      const totalSec = Math.floor(diff / 1000);
      const d = Math.floor(totalSec / 86400);
      const h = Math.floor((totalSec % 86400) / 3600);
      const m = Math.floor((totalSec % 3600) / 60);
      const sec = totalSec % 60;
      const urgent = diff < 86400000; // under 24h

      widgets.forEach((w) => {
        setPart(w.querySelector('[data-cd="d"]'), d);
        setPart(w.querySelector('[data-cd="h"]'), h);
        setPart(w.querySelector('[data-cd="m"]'), m);
        setPart(w.querySelector('[data-cd="s"]'), sec);
        w.classList.toggle('cd-urgent', urgent);
      });
    };

    let timer = null;
    tick();
    timer = setInterval(tick, 1000);

    // Pause ticking when the tab is hidden, resync on return
    document.addEventListener('visibilitychange', () => {
      if (!document.hidden) tick();
    });
  })();
});


/* ============================================================================
   REGISTRATION FORM HANDLER
   AI Business Automation Masterclass

   Submits #regForm to the K-GOD enquiry API and drives the success modal.

   API contract
     POST {API_BASE_URL}/api/v1/enquiry
     body { full_name, country_code, phone, email, category, subject, message }
     resp { status: boolean, message: string }
       200 + status:true   -> success
       422                 -> validation error (message names the field)
       500                 -> server / mail error
   ========================================================================== */

   (function () {
    'use strict';
  
    /* ---------------------------------------------------------------
       Config
       --------------------------------------------------------------- */
    var API_BASE_URL = 'https://kriscent.in/K-GOD';
    var ENQUIRY_URL = API_BASE_URL + '/api/v1/enquiry';
  
    var CATEGORY = 'AI Business Growth Webinar';
    var SUBJECT = 'Register Enquiry for AI business growth webinar';
    var COUNTRY_CODE = '91';
    var REQUEST_TIMEOUT = 20000;
  
    /* ---------------------------------------------------------------
       Field map: input name -> label used in the message body
       --------------------------------------------------------------- */
    /* ageGroup / income removed (keeps registration friction low).
       challenge is optional, so only businessType is required. */
    var EXTRA_FIELDS = [
      { name: 'businessType', label: 'Business Type', required: true },
      { name: 'challenge', label: 'Biggest Business Challenge', required: false }
    ];
  
    /* ---------------------------------------------------------------
       Boot
       --------------------------------------------------------------- */
    document.addEventListener('DOMContentLoaded', function () {
      // This page saves through ai.wealth.inquiry.save in the blade.
      if (window.AI_WEALTH_INQUIRY) return;

      var form = document.getElementById('regForm');
      if (!form) return;
  
      var submitBtn = form.querySelector('button[type="submit"]');
      var isSubmitting = false;
  
      /* -----------------------------------------------------------
         Inline alert element, injected above the submit button
         ----------------------------------------------------------- */
      var alertBox = document.createElement('div');
      alertBox.id = 'regFormAlert';
      alertBox.setAttribute('role', 'status');
      alertBox.setAttribute('aria-live', 'polite');
      alertBox.className = 'hidden';
      if (submitBtn && submitBtn.parentNode) {
        submitBtn.parentNode.insertBefore(alertBox, submitBtn);
      } else {
        form.appendChild(alertBox);
      }
  
      var alertTimer = null;
  
      function showAlert(type, message) {
        clearTimeout(alertTimer);
        var isError = type === 'error';
        alertBox.className =
          'flex items-start gap-2 rounded-xl px-3.5 py-3 mb-3 text-[12px] md:text-[13px] font-bold border ' +
          (isError
            ? 'bg-red-50 text-red-700 border-red-200'
            : 'bg-green-50 text-green-700 border-green-200');
        alertBox.innerHTML =
          '<i class="fa-solid ' +
          (isError ? 'fa-circle-exclamation' : 'fa-circle-check') +
          ' mt-0.5 shrink-0" aria-hidden="true"></i><span></span>';
        alertBox.querySelector('span').textContent = message;
  
        alertTimer = setTimeout(hideAlert, 8000);
      }
  
      function hideAlert() {
        clearTimeout(alertTimer);
        alertBox.className = 'hidden';
        alertBox.innerHTML = '';
      }
  
      /* -----------------------------------------------------------
         Success modal helpers.
         script.js owns the modal markup; we drive it here so the
         form only opens it on a genuine API success.
         ----------------------------------------------------------- */
      var modal = document.getElementById('successModal');
      var confetti = document.getElementById('confetti');
      var closeBtn = document.getElementById('closeSuccess');
      var prefersLessMotion =
        window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  
      function burstConfetti() {
        if (!confetti || prefersLessMotion) return;
        confetti.innerHTML = '';
        var colors = ['#0891b2', '#22d3ee', '#fbbf24', '#16a34a', '#a855f7'];
        for (var i = 0; i < 34; i++) {
          var bit = document.createElement('span');
          bit.className = 'confetti-bit';
          bit.style.left = Math.random() * 100 + '%';
          bit.style.background = colors[i % colors.length];
          bit.style.animationDuration = 1.6 + Math.random() * 1.4 + 's';
          bit.style.animationDelay = Math.random() * 0.5 + 's';
          bit.style.width = 5 + Math.random() * 6 + 'px';
          bit.style.height = 9 + Math.random() * 9 + 'px';
          confetti.appendChild(bit);
        }
        setTimeout(function () {
          confetti.innerHTML = '';
        }, 3600);
      }
  
      function openSuccessModal() {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(function () {
          modal.classList.add('is-open');
          burstConfetti();
        });
        if (closeBtn) {
          setTimeout(function () {
            closeBtn.focus();
          }, 400);
        }
      }
  
      /* -----------------------------------------------------------
         Helpers
         ----------------------------------------------------------- */
      function val(name) {
        var el = form.elements[name];
        return el && el.value ? el.value.trim() : '';
      }
  
      function setLoading(state) {
        isSubmitting = state;
        if (!submitBtn) return;
        if (state) {
          submitBtn.classList.add('btn-loading');
          submitBtn.setAttribute('disabled', 'disabled');
          submitBtn.setAttribute('aria-busy', 'true');
        } else {
          submitBtn.classList.remove('btn-loading');
          submitBtn.removeAttribute('disabled');
          submitBtn.removeAttribute('aria-busy');
        }
      }
  
      /* Builds the message body from the fields the API has no column for. */
      function buildMessage() {
        var lines = ['Registration for the AI Business Growth Accelerator(TM) live masterclass.', ''];
        EXTRA_FIELDS.forEach(function (f) {
          var v = val(f.name);
          lines.push(f.label + ': ' + (v || 'Not provided'));
        });
        lines.push('');
        lines.push('Webinar: Thursday, 29 October 2026, 8 PM to 10 PM IST');
        lines.push('Source: ' + window.location.href);
  
        var msg = lines.join('\n');
        // API requires 10..600 characters
        if (msg.length > 600) msg = msg.slice(0, 597) + '...';
        return msg;
      }
  
      /* Digits only, drop a leading 0 or 91 so we always send 10 digits. */
      function normalisePhone(raw) {
        var digits = (raw || '').replace(/\D/g, '');
        if (digits.length > 10 && digits.indexOf('91') === 0) digits = digits.slice(2);
        if (digits.length === 11 && digits.charAt(0) === '0') digits = digits.slice(1);
        return digits;
      }
  
      /* Extra client-side checks beyond the browser's required/pattern. */
      function clientValidate() {
        var name = val('fullName');
        if (name.length < 2) return 'Please enter your full name.';
        if (!/^[a-zA-Z\s.'-]+$/.test(name)) return 'Name can only contain letters.';
  
        var phone = normalisePhone(val('whatsapp'));
        if (phone.length !== 10) return 'Please enter a valid 10-digit WhatsApp number.';
  
        var email = val('email');
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(email)) {
          return 'Please enter a valid email address.';
        }
  
        var missing = EXTRA_FIELDS.filter(function (f) {
          return f.required && !val(f.name);
        });
        if (missing.length) return 'Please select your ' + missing[0].label.toLowerCase() + '.';
  
        return null;
      }
  
      /* Fetch with an abort-based timeout. */
      function postWithTimeout(url, options, ms) {
        if (typeof AbortController === 'undefined') {
          return fetch(url, options);
        }
        var controller = new AbortController();
        options.signal = controller.signal;
        var timer = setTimeout(function () {
          controller.abort();
        }, ms);
        return fetch(url, options).then(
          function (res) {
            clearTimeout(timer);
            return res;
          },
          function (err) {
            clearTimeout(timer);
            throw err;
          }
        );
      }
  
      /* -----------------------------------------------------------
         Submit
         ----------------------------------------------------------- */
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (isSubmitting) return;
  
        hideAlert();
  
        // Native constraints first (required, pattern, type=email)
        if (!form.checkValidity()) {
          form.reportValidity();
          return;
        }
  
        var clientError = clientValidate();
        if (clientError) {
          showAlert('error', clientError);
          alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
          return;
        }
  
        var payload = {
          full_name: val('fullName'),
          country_code: COUNTRY_CODE,
          phone: normalisePhone(val('whatsapp')),
          email: val('email'),
          category: CATEGORY,
          subject: SUBJECT,
          message: buildMessage()
        };
  
        setLoading(true);
  
        postWithTimeout(
          ENQUIRY_URL,
          {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              Accept: 'application/json'
            },
            body: JSON.stringify(payload)
          },
          REQUEST_TIMEOUT
        )
          .then(function (res) {
            return res
              .json()
              .catch(function () {
                return {};
              })
              .then(function (data) {
                return { res: res, data: data };
              });
          })
          .then(function (out) {
            var res = out.res;
            var data = out.data || {};
  
            if (res.ok && data.status) {
              form.reset();
              hideAlert();
              openSuccessModal();
              return;
            }
  
            // 422 -> the API tells us which field failed
            if (res.status === 422) {
              showAlert('error', data.message || 'Please check your details and try again.');
              return;
            }
  
            // 500 and friends: the submission may have been recorded but the
            // notification mail failed, so do not claim success.
            if (res.status >= 500) {
              showAlert(
                'error',
                'We could not complete your registration right now. Please try again in a moment, or message us on WhatsApp.'
              );
              return;
            }
  
            showAlert('error', data.message || 'Something went wrong. Please try again.');
          })
          .catch(function (err) {
            if (err && err.name === 'AbortError') {
              showAlert('error', 'The request timed out. Please check your connection and try again.');
            } else {
              showAlert('error', 'Network error. Please check your connection and try again.');
            }
          })
          .then(function () {
            setLoading(false);
          });
      });
  
      /* -----------------------------------------------------------
         Live input hygiene
         ----------------------------------------------------------- */
      var phoneInput = form.elements['whatsapp'];
      if (phoneInput) {
        phoneInput.addEventListener('input', function () {
          this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
      }
  
      var nameInput = form.elements['fullName'];
      if (nameInput) {
        nameInput.addEventListener('input', function () {
          this.value = this.value.replace(/[^a-zA-Z\s.'-]/g, '').slice(0, 50);
        });
      }
  
      // Clear a visible error as soon as the user starts fixing things
      form.addEventListener('input', function () {
        if (alertBox.className.indexOf('hidden') === -1) hideAlert();
      });
    });
  })();
  