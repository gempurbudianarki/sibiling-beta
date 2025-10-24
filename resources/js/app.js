import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Global loading handler for form submissions
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions with loading states
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<div class="inline-block loading-spinner-small"></div> Memproses...';
                
                // Add small loading spinner styles if not exists
                if (!document.querySelector('#loading-styles')) {
                    const styles = document.createElement('style');
                    styles.id = 'loading-styles';
                    styles.textContent = `
                        .loading-spinner-small {
                            width: 16px;
                            height: 16px;
                            border: 2px solid transparent;
                            border-top: 2px solid currentColor;
                            border-radius: 50%;
                            animation: spin 0.8s linear infinite;
                            display: inline-block;
                            margin-right: 8px;
                        }
                    `;
                    document.head.appendChild(styles);
                }
            }
        });
    });
});