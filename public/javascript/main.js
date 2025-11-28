// JavaScript para funcionalidades básicas - Versión segura
document.addEventListener('DOMContentLoaded', function() {
  // Solo ejecutar si estamos en la página principal (no en auth)
  if (!document.body.classList.contains('auth-body')) {
    
    // Smooth scroll para enlaces internos
    const internalLinks = document.querySelectorAll('a[href^="#"]');
    if (internalLinks.length > 0) {
      internalLinks.forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });
    }
    
    // Animación para elementos al hacer scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-in');
        }
      });
    }, observerOptions);
    
    // Observar elementos para animación (solo si existen)
    const elementsToObserve = document.querySelectorAll('.servicio-card, .caracteristica-item, .testimonio-card, .galeria-item');
    if (elementsToObserve.length > 0) {
      elementsToObserve.forEach(el => {
        observer.observe(el);
      });
    }
  }
});