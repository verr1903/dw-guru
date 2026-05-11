    const toggleBtn = document.getElementById('togglePassword');
    const passInput = document.getElementById('password');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClose = document.getElementById('eyeClose');

    toggleBtn?.addEventListener('click', () => {
        const isPass = passInput.type === 'password';
        passInput.type = isPass ? 'text' : 'password';
        eyeOpen.classList.toggle('hidden', isPass);
        eyeClose.classList.toggle('hidden', !isPass);
    });