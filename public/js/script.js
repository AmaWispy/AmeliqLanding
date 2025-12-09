// Logo click - scroll to top
const logo = document.querySelector('.logo h2');
if (logo) {
    logo.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href.length > 1) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement;
        const isActive = faqItem.classList.contains('active');
        
        // Close all other FAQ items
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Toggle current item
        if (!isActive) {
            faqItem.classList.add('active');
        }
    });
});

// Form Handling - Audit Form (Existing)
const auditForm = document.getElementById('auditForm');
if (auditForm) {
    auditForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Валидация
        const emailInput = auditForm.querySelector('input[type="email"]');
        const phoneInput = auditForm.querySelector('input[type="tel"]');
        
        if (emailInput && emailInput.value && !validateEmail(emailInput.value)) return;
        if (phoneInput && phoneInput.value && !validatePhone(phoneInput.value)) return;

        const submitBtn = auditForm.querySelector('button[type="submit"]');
        if(submitBtn) submitBtn.disabled = true;

        try {
            const formData = new FormData(auditForm);
            
            const response = await fetch('/lead/submit', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: formData
            });
            
            const result = await response.json();

            if (result.success) {
                alert('Спасибо! Мы свяжемся с вами для уточнения данных в ближайшее время.');
                auditForm.reset();
            } else {
                alert('Ошибка при отправке формы. Попробуйте позже.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка. Пожалуйста, свяжитесь с нами по телефону.');
        } finally {
            if(submitBtn) submitBtn.disabled = false;
        }
    });
}

// Universal Modal Logic
const requestModal = document.getElementById('requestModal');
const requestClose = document.querySelector('.request-close');
const universalForm = document.getElementById('universalForm');
const formSourceInput = document.getElementById('formSource');

// Open Universal Modal
document.querySelectorAll('.js-open-modal').forEach(trigger => {
    trigger.addEventListener('click', (e) => {
        e.preventDefault();
        const source = trigger.dataset.source || 'Unknown';
        if (requestModal && formSourceInput) {
            formSourceInput.value = source;
            requestModal.classList.add('active');
        }
    });
});

// Close Universal Modal
if (requestClose) {
    requestClose.addEventListener('click', () => {
        if (requestModal) requestModal.classList.remove('active');
    });
}

// Close on outside click (Universal Modal)
if (requestModal) {
    requestModal.addEventListener('click', (e) => {
        if (e.target === requestModal) {
            requestModal.classList.remove('active');
        }
    });
}

// Handle Universal Form Submit
if (universalForm) {
    universalForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const phoneInput = universalForm.querySelector('input[type="tel"]');
        if (phoneInput && phoneInput.value && !validatePhone(phoneInput.value)) return;

        const submitBtn = universalForm.querySelector('button[type="submit"]');
        if(submitBtn) submitBtn.disabled = true;

        try {
            const formData = new FormData(universalForm);
            
            const response = await fetch('/lead/submit', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: formData
            });
            
            const result = await response.json();

            if (result.success) {
                alert('Спасибо за заявку! Мы свяжемся с вами в ближайшее время.');
                if (requestModal) requestModal.classList.remove('active');
                universalForm.reset();
                
                // Redirect if backend provided a URL (e.g. for lead magnet)
                if (result.redirect_url) {
                    window.open(result.redirect_url, '_blank');
                }
            } else {
                alert('Ошибка при отправке формы. Попробуйте позже.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Произошла ошибка. Пожалуйста, свяжитесь с нами по телефону.');
        } finally {
            if(submitBtn) submitBtn.disabled = false;
        }
    });
}


// Exit Intent Popup & Gift Logic
const exitPopup = document.getElementById('exitPopup');
const popupClose = exitPopup ? exitPopup.querySelector('.popup-close') : null;
const popupForm = exitPopup ? exitPopup.querySelector('.popup-form') : null; // Selects the form inside exitPopup
let exitIntentShown = false;

// Show popup logic
function showExitPopup() {
    if (exitPopup && !exitIntentShown) {
        exitPopup.classList.add('active');
        exitIntentShown = true;
        localStorage.setItem('exitPopupShown', 'true');
    }
}

// Mouseleave trigger
document.addEventListener('mouseleave', (e) => {
    if (e.clientY <= 0 && !exitIntentShown) {
        showExitPopup();
    }
});

// Mobile timer trigger
if (window.innerWidth <= 768) {
    setTimeout(() => {
        if (!exitIntentShown) showExitPopup();
    }, 30000);
}

// Check storage
if (localStorage.getItem('exitPopupShown')) {
    exitIntentShown = true;
}

// Close popup
if (popupClose) {
    popupClose.addEventListener('click', () => {
        exitPopup.classList.remove('active');
    });
}

// Close on outside click
if (exitPopup) {
    exitPopup.addEventListener('click', (e) => {
        if (e.target === exitPopup) {
            exitPopup.classList.remove('active');
        }
    });
}

// Gift Form Submission with Redirect
if (popupForm && !popupForm.id.includes('universalForm')) { // Ensure we don't select universalForm if classes mix
    popupForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const emailInput = popupForm.querySelector('input[type="email"]');
        
        if (emailInput) {
            if (emailInput.value && !validateEmail(emailInput.value)) return;
            
            const submitBtn = popupForm.querySelector('button[type="submit"]');
            if(submitBtn) submitBtn.disabled = true;

            try {
                // Create FormData manually or from form if inputs have names
                const formData = new FormData(popupForm);
                if(!formData.has('source')) formData.append('source', 'Exit Intent (Lead Magnet)');
                if(!formData.has('email')) formData.append('email', emailInput.value);
                
                // Send data but don't wait strictly for success to redirect (optional)
                fetch('/lead/submit', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Спасибо! Чек-лист сейчас откроется.');
                        exitPopup.classList.remove('active');
                        popupForm.reset();
                        
                        if (result.redirect_url) {
                            window.location.href = result.redirect_url;
                        }
                    } else {
                        alert('Ошибка при отправке формы. Попробуйте позже.');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Произошла ошибка. Пожалуйста, попробуйте еще раз.');
                })
                .finally(() => {
                    if(submitBtn) submitBtn.disabled = false;
                });

            } catch (error) {
                console.error(error);
                if(submitBtn) submitBtn.disabled = false;
            }
        }
    });
}


// Case Modal Logic (Existing)
const caseModal = document.getElementById('caseModal');
const caseFrame = document.getElementById('caseFrame');
const caseClose = document.querySelector('.case-modal-close');

// Open Case Modal
document.querySelectorAll('[data-case-url]').forEach(trigger => {
    trigger.addEventListener('click', (e) => {
        e.preventDefault();
        const url = trigger.dataset.caseUrl;
        if (url && caseModal && caseFrame) {
            caseFrame.src = url;
            caseModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    });
});

// Close Case Modal
function closeCaseModal() {
    if (caseModal) {
        caseModal.classList.remove('active');
        setTimeout(() => {
            if (caseFrame) caseFrame.src = '';
        }, 300);
        document.body.style.overflow = '';
    }
}

if (caseClose) caseClose.addEventListener('click', closeCaseModal);
if (caseModal) {
    caseModal.addEventListener('click', (e) => {
        if (e.target === caseModal) closeCaseModal();
    });
}
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && caseModal && caseModal.classList.contains('active')) {
        closeCaseModal();
    }
});


// Animations & Observers
const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.service-card, .advantage-card, .process-step, .pricing-card, .team-card, .portfolio-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Stats Animation
const animateValue = (element, start, end, duration) => {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const value = Math.floor(progress * (end - start) + start);
        element.textContent = value + (element.dataset.suffix || '');
        if (progress < 1) window.requestAnimationFrame(step);
    };
    window.requestAnimationFrame(step);
};

const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.animated) {
            const statNumbers = entry.target.querySelectorAll('.stat-number, .fact-number');
            statNumbers.forEach(stat => {
                const text = stat.textContent;
                const number = parseInt(text.replace(/\D/g, ''));
                if (!isNaN(number)) {
                    stat.dataset.suffix = text.replace(/\d/g, '');
                    stat.textContent = '0';
                    animateValue(stat, 0, number, 2000);
                }
            });
            entry.target.dataset.animated = 'true';
        }
    });
}, { threshold: 0.5 });

document.querySelectorAll('.hero-stats, .facts').forEach(el => { statsObserver.observe(el); });

// Parallax
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    document.querySelectorAll('.bg-element').forEach((el, index) => {
        const speed = 0.5 + (index * 0.2);
        el.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Phone Mask & Validation
document.querySelectorAll('input[type="tel"]').forEach(input => {
    input.addEventListener('input', function(e) {
        const value = this.value.replace(/\D/g, '');
        if (value.length === 0) { this.value = ''; return; }
        let formattedValue = '+7 (';
        let numberValue = value;
        if (['7', '8'].includes(value[0])) numberValue = value.substring(1);
        
        if (numberValue.length > 0) formattedValue += numberValue.substring(0, 3);
        if (numberValue.length >= 4) formattedValue += ') ' + numberValue.substring(3, 6);
        if (numberValue.length >= 7) formattedValue += '-' + numberValue.substring(6, 8);
        if (numberValue.length >= 9) formattedValue += '-' + numberValue.substring(8, 10);
        this.value = formattedValue;
    });
    input.addEventListener('focus', function() { if (this.value === '') this.value = '+7 ('; });
});

const validateEmail = (email) => String(email).toLowerCase().match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
const validatePhone = (phone) => {
    // Разрешаем только цифры, +, (, ), -, пробелы
    const cleaned = String(phone).replace(/[^\d+]/g, '');
    // Минимальная длина для номера (например, +79991112233 = 12 символов)
    return cleaned.length >= 10;
};

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
        // Skip validation for our handled forms if handled inside their specific listeners, 
        // but basic validation is good.
        const emailInput = form.querySelector('input[type="email"]');
        const phoneInput = form.querySelector('input[type="tel"]');
        
        if (emailInput && emailInput.value && !validateEmail(emailInput.value)) {
            alert('Пожалуйста, введите корректный email');
            emailInput.focus();
            e.preventDefault();
            e.stopImmediatePropagation(); // Stop other listeners
        }
        
        if (phoneInput && phoneInput.value && !validatePhone(phoneInput.value)) {
            alert('Пожалуйста, введите корректный номер телефона');
            phoneInput.focus();
            e.preventDefault();
            e.stopImmediatePropagation();
        }
    });
});

// Card Hovers
document.querySelectorAll('.service-card, .advantage-card, .audience-card').forEach(card => {
    card.addEventListener('mouseenter', function() { this.style.transform = 'translateY(-10px)'; });
    card.addEventListener('mouseleave', function() { this.style.transform = 'translateY(0)'; });
});

// Console Easter Egg
console.log('%c👋 Привет от команды Ameliq!', 'font-size: 20px; color: #00d4ff; font-weight: bold;');
console.log('%cИнтересуешься кодом? Нам нравятся любопытные люди!', 'font-size: 14px; color: #7c3aed;');
console.log('%cСвяжись с нами: info@ameliq.ru', 'font-size: 14px; color: #e0e0e0;');

// Safe Links Decoding
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-safe-text]').forEach(el => {
        try {
            // Safe decode for UTF-8
            const decoded = decodeURIComponent(escape(window.atob(el.dataset.safeText)));
            el.textContent = decoded;
        } catch (e) {
            console.error('Error decoding safe text', e);
        }
    });
});

// Cookie Consent Logic
document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookieBanner');
    const acceptCookieBtn = document.getElementById('acceptCookie');
    
    // Check if cookie accepted
    if (cookieBanner && !localStorage.getItem('cookieAccepted')) {
        // Force display block immediately to test visibility
        cookieBanner.style.display = 'block'; 
        
        // Add active class after small delay for animation
        setTimeout(() => {
            cookieBanner.classList.add('active');
        }, 100);
    }
    
    // Accept cookie
    if (acceptCookieBtn && cookieBanner) {
        acceptCookieBtn.addEventListener('click', () => {
            localStorage.setItem('cookieAccepted', 'true');
            cookieBanner.classList.remove('active');
            // Also hide after transition
            setTimeout(() => {
                cookieBanner.style.display = 'none';
            }, 500);
        });
    }
    
    // Privacy Policy Modal Logic
    const privacyModal = document.getElementById('privacyModal');
    const openPrivacyBtns = document.querySelectorAll('#openPrivacyPolicy, .privacy-link');
    const closePrivacyBtn = document.querySelector('.privacy-close');
    
    if (privacyModal) {
        openPrivacyBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                privacyModal.style.display = 'flex'; // Ensure display flex for centering
                // Small timeout to allow display:flex to apply before adding active class for transition
                setTimeout(() => {
                    privacyModal.classList.add('active');
                }, 10);
                document.body.style.overflow = 'hidden';
            });
        });

        const closePrivacy = () => {
            privacyModal.classList.remove('active');
            setTimeout(() => {
                privacyModal.style.display = 'none';
            }, 300); // Match transition duration
            document.body.style.overflow = '';
        };

        if (closePrivacyBtn) {
            closePrivacyBtn.addEventListener('click', closePrivacy);
        }

        // Close on outside click
        privacyModal.addEventListener('click', (e) => {
            if (e.target === privacyModal) {
                closePrivacy();
            }
        });
        
        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && privacyModal.classList.contains('active')) {
                closePrivacy();
            }
        });
    }
});

