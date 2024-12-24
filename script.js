document.addEventListener('DOMContentLoaded', () => {
    const donationForm = document.getElementById('donation-form');
    const contactForm = document.getElementById('contact-form');

    donationForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const data = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            cause: document.getElementById('cause').value,
            amount: document.getElementById('amount').value,
        };
        try {
            const response = await fetch('backend/donate.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });
            const result = await response.json();
            alert(result.message);
            donationForm.reset();
        } catch (error) {
            alert('Error submitting donation form. Please try again.');
        }
    });

    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const data = {
            name: document.getElementById('contact-name').value,
            email: document.getElementById('contact-email').value,
            message: document.getElementById('message').value,
        };
        try {
            const response = await fetch('backend/contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data),
            });
            const result = await response.json();
            alert(result.message);
            contactForm.reset();
        } catch (error) {
            alert('Error submitting contact form. Please try again.');
        }
    });
});
