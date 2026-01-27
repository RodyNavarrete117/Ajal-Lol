    const actionBtn = document.getElementById('actionBtn');
    const backBtn = document.getElementById('backBtn');
    const emailGroup = document.getElementById('email-group');
    const passwordGroup = document.getElementById('password-group');
    const emailInput = document.getElementById('email');
    const form = document.getElementById('loginForm');

    let emailGuardado = '';

    // Siguiente → Password
    actionBtn.addEventListener('click', () => {
        if (passwordGroup.classList.contains('active')) return;

        if (emailInput.value.trim() === '') {
            alert('Ingrese su correo');
            return;
        }

        emailGuardado = emailInput.value;

        emailGroup.classList.add('hidden');
        passwordGroup.classList.remove('hidden');
        passwordGroup.classList.add('active');
        backBtn.classList.remove('hidden');
        document.getElementById('forgot-password').classList.remove('hidden');

        

        actionBtn.textContent = 'Iniciar sesión';
        actionBtn.type = 'submit';
    });

    // Volver → Email
    backBtn.addEventListener('click', () => {
        passwordGroup.classList.add('hidden');
        passwordGroup.classList.remove('active');

        emailGroup.classList.remove('hidden');
        backBtn.classList.add('hidden');
        document.getElementById('forgot-password').classList.add('hidden');


        emailInput.value = emailGuardado;

        actionBtn.textContent = 'Siguiente';
        actionBtn.type = 'button';
    });

    // Envío final
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const password = document.getElementById('password').value;

        console.log('Correo:', emailGuardado);
        console.log('Password:', password);

    });

