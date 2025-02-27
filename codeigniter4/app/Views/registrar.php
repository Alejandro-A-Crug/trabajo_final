<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($user) ? 'Editar Usuario' : 'Crear Usuario' ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


    
    <!-- Register Form -->
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px; border-radius: 1rem;">
      <h2 class="text-center mb-4"><?= isset($user) ? 'Editar Usuario' : 'Crear Usuario' ?></h2>
      <?php if(isset($validation)): ?>
    <div style="color: red;">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>
      <form action="<?= isset($user) ? base_url('usuarios/guardar/') . $user['id'] : base_url('usuarios/guardar') ?>" method="post" id="formulario">
      <?= csrf_field(); ?>
        <div class="mb-3">
          <label for="username" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="username" name="nombre" placeholder="Enter your username" >
        </div>
        <div class="mb-3">
          <label for="contraseña" class="form-label">contraseña</label>
          <input type="password" class="form-control" id="epoca" name="contraseña" placeholder="Enter your password" >
        </div>
        <div class="mb-3">
          <label for="epoca" class="form-label">Epoca</label>
          <input type="text" class="form-control" id="epoca" name="epoca" placeholder="Enter your year" >
        </div>

        <button type="submit" class="btn btn-primary w-100" id="botonregistrar">Register</button>
      </form>
      <p class="text-center mt-3">
        Already have an account? <a href="<?= base_url('login') ?>" class="text-decoration-none">Login</a>
      </p>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
   <script src="<?= base_url('js/disable_button.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
