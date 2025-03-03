<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            height: 100%;
        }

        body {
            margin: 0;
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            color: white;
            overflow-y: auto;
        }

        .content {
            margin-left: 280px; /* Matches the sidebar width */
            padding: 20px;
            flex: 1;
            overflow-y: auto;
        }

        .custom{
            height: 50px;
        }

        .custom input{
            width: 120px;
            box-shadow: 1px 1px 1px gray;
            border-radius: 5px;
        }


    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32">
                    <use xlink:href="#bootstrap"></use>
                </svg>
                <span class="fs-4"><img src="logo_theclock.png" height="60px" width="170px"></span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home"></use>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="http://localhost/codeigniter4/public/usuarios" class="nav-link text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                        </svg>
                        Users
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                            <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                        </svg>
                        Roles
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-newspaper" viewBox="0 0 16 16">
                            <path d="M0 2.5A1.5 1.5 0 0 1 1.5 1h11A1.5 1.5 0 0 1 14 2.5v10.528c0 .3-.05.654-.238.972h.738a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 1 1 0v9a1.5 1.5 0 0 1-1.5 1.5H1.497A1.497 1.497 0 0 1 0 13.5zM12 14c.37 0 .654-.211.853-.441.092-.106.147-.279.147-.531V2.5a.5.5 0 0 0-.5-.5h-11a.5.5 0 0 0-.5.5v11c0 .278.223.5.497.5z" />
                            <path d="M2 3h10v2H2zm0 3h4v3H2zm0 4h4v1H2zm0 2h4v1H2zm5-6h2v1H7zm3 0h2v1h-2zM7 8h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2zm-3 2h2v1H7zm3 0h2v1h-2z" />
                        </svg>
                        News
                    </a>
                </li>
            </ul>
            <hr>

        </div>

        <!-- Table -->
        <div class="content">

        <?php if(session()->getFlashdata('success')): ?>
            <script>
             toastr.success('<?= session()->getFlashdata('success'); ?>');
            </script>
        <?php endif; ?>

        <a href="<?= base_url('usuarios/guardar') ?>" class="btn btn-primary mb-3">Crear Usuario</a>


    <div class="container mt-5 custom" style="height: 210px;">
    <form class="">
            <div class="container-fluid custom">
            <input type="text" name="id" placeholder="id">
            <input type="text" name="nombre" placeholder="nombre">
            <select id="epoca" name="epoca">
                <option value="">Todas</option>
                <option value="before" <?= isset($_GET['epoca']) && $_GET['epoca'] == 'before' ? 'selected' : '' ?>>Antes de <?= date('Y') ?></option>
                <option value="after" <?= isset($_GET['epoca']) && $_GET['epoca'] == 'after' ? 'selected' : '' ?>>Después de <?= date('Y') ?></option>
            </select>
            <input type="text" name="rol" placeholder="rol">
            <select id="borrado_en" name="borrado_en">
            <option value="">Todos</option>
                <option value="Null">Activo</option>
                <option value="Not_Null">Borrado</option>
            </select>
            <input type="submit" class="enviar">
            </div>
        </form>
    </div>

            <?php if (!empty($users) && is_array($users)): ?>
            <table class="table table-success table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>

                        <th scope="col">Epoca</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Borrado_en</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <th scope="row"></th>
                        <td><?=($user['id']) ?></td>
                        <td><?=($user['nombre']) ?></td>

                        <td><?=($user['epoca']) ?></td>
                        <td><?=($user['rol']) ?></td>
                        <td><?=($user['borrado_en']) ?></td>
                        <td>
                        <a href="<?= base_url('usuarios/guardar/' . $user['id']) ?>" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
  <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001"/>
</svg></a>
                        <a href="<?=base_url('usuarios/borrar/') . esc($user['id']) ?>"><button type="button" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg></button></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
              <div class="mt-4">
                <?= $pager ->links('default' ,'custom_pagination') ?>
              </div>
        </div>
        <?php else: ?>
        <p class="text-center">No hay usuarios registrados.</p>
    <?php endif; ?>
    </div>
</body>

</html>
