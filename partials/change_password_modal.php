<div class="modal fade" id="change-password-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar Contraseña</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label text-secondary fw-semibold ms-2" for="password-user">Nueva Contraseña</label>
                <input type="password" class="form-control" id="new-password-user" placeholder="Nueva contraseña" value="" name="new_password" min="4" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label text-secondary fw-semibold ms-2" for="password-user">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control" id="confirm-password-user" placeholder="Nueva contraseña" value="" name="confirm_password" min="4" required>
            </div>
            <div class="col-md-12">
                <div class="alert alert-warning" role="alert">
                    <p class="m-0">
                        ¿Esta seguro(a) que desea cambiar la contraseña?<br>
                        <strong> Ingrese su contraseña actual para confirmar. </strong>.
                    </p>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label text-secondary fw-semibold ms-2" for="password-user">Contraseña Actual</label>
                <input type="password" class="form-control" id="password-user" placeholder="Nueva contraseña" value="" name="password" min="4" required>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancelar</button>
        <button type="button" class="btn btn-primary" id="btn-change-password"><i class="fas fa-sync-alt me-2"></i>Cambiar</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('#btn-change-password').on('click', async (e) => {
        const password = document.getElementById('password-user');
        const newPassword = document.getElementById('new-password-user');
        const confirmPassword = document.getElementById('confirm-password-user');
        const ACTION = 'CAMBIAR CONTRASEÑA';
        if(password.value.length >= 4 && newPassword.value.length >= 4 && confirmPassword.value.length >= 4){
            if(newPassword.value != confirmPassword.value){
                toast(ACTION, 'La nueva contraseña no coincide con la confirmación de la nueva contraseña.', 'error', 3000);
                return;
            }
            const response = await $.ajax({
                url: '../app/user/changePassword',
                data: {
                    password: password.value,
                    new_password: newPassword.value,
                },
                dataType: 'json',
                type: 'POST'
            });
            if(response.success){
                const res = await $.ajax({
                    url: '../app/auth/logout',
                    data: {},
                    type: 'POST',
                    dataType: 'json',
                })
                if (res.success) {
                    setTimeout(() => {
                        window.location.href = '../auth/login.php';
                    }, 1000);
                }
            }
            toast(ACTION, response.message, response.success ? 'success' : 'error');
        }else{
            toast(ACTION, 'Las contraseña deben contener al menos 4 caracteres.', 'error');
        }
    });
</script>