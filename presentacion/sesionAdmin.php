<?php
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "admin") {
    header("Location: ?pid=" . base64_encode("presentacion/noAutorizado.php"));
    exit();
}

if (!isset($_SESSION["administrador"])) {
    echo "<div class='text-danger text-center mt-4'>Error: sesión inválida. Por favor vuelve a iniciar sesión.</div>";
    exit();
}

$administrador = unserialize($_SESSION["administrador"]);
$administrador->consultar();
?>
<div class="container mt-4">
  <h5 class="text-primary text-center fw-bold mb-4">Datos del Administrador</h5>

  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Nombre:</span>
    <span><?php echo $administrador->getNombre(); ?></span>
  </div>
  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Correo:</span>
    <span><?php echo $administrador->getCorreo(); ?></span>
  </div>
</div>

<div class="container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-primary">Panel de Administración</h2>
    <p class="text-muted">Gestiona usuarios, materias y tutorías</p>
  </div>
  <div class="row g-4 justify-content-center">

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-users-cog fa-2x text-primary mb-3"></i>
          <h5 class="card-title fw-semibold">Gestión de Usuarios</h5>
          <p class="card-text">Crear, editar y asignar roles.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Administrador/gestionUsuarios.php'); ?>" class="btn btn-primary text-white">Ir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-book fa-2x text-info mb-3"></i>
          <h5 class="card-title fw-semibold">Gestión de Materias</h5>
          <p class="card-text">Agregar o modificar materias disponibles.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Administrador/gestionMaterias.php'); ?>" class="btn btn-info text-white">Ir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-calendar-check fa-2x text-success mb-3"></i>
          <h5 class="card-title fw-semibold">Supervisión de Tutorías</h5>
          <p class="card-text">Revisar solicitudes y reportes.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Administrador/supervisionTutorias.php'); ?>" class="btn btn-success text-white">Ir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-sign-out-alt fa-2x text-danger mb-3"></i>
          <h5 class="card-title fw-semibold">Cerrar Sesión</h5>
          <p class="card-text">Salir de tu cuenta de administrador.</p>
          <a href="?pid=<?php echo base64_encode("presentacion/Autenticar.php")?>&sesion=false" class="btn btn-danger text-white">Cerrar Sesión</a>
        </div>
      </div>
    </div>

  </div>
</div>
