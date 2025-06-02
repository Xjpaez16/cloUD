<?php
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "tutor") {
    header("Location: ?pid=" . base64_encode("presentacion/noAutorizado.php"));
    exit();
}

if (!isset($_SESSION["tutor"])) {
    echo "<div class='text-danger text-center mt-4'>Error: sesión inválida. Por favor vuelve a iniciar sesión.</div>";
    exit();
}

$tutor = unserialize($_SESSION["tutor"]);
$tutor->consultar();
?>
<div class="container mt-4">
  <h5 class="text-info text-center fw-bold mb-4">Datos del Tutor</h5>

  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Nombre:</span>
    <span><?php echo $tutor->getNombre(); ?></span>
  </div>
  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Correo:</span>
    <span><?php echo $tutor->getCorreo(); ?></span>
  </div>
</div>

<div class="container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-info">Panel del Tutor</h2>
    <p class="text-muted">Administra tus tutorías y disponibilidad</p>
  </div>
  <div class="row g-4 justify-content-center">

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-calendar-alt fa-2x text-info mb-3"></i>
          <h5 class="card-title fw-semibold">Mis Tutorías</h5>
          <p class="card-text">Ver y gestionar solicitudes de tutorías.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Tutor/tutorias.php'); ?>" class="btn btn-info text-white">Ir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-clock fa-2x text-warning mb-3"></i>
          <h5 class="card-title fw-semibold">Disponibilidad</h5>
          <p class="card-text">Configura tu horario disponible para tutorías.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Tutor/disponibilidad.php'); ?>" class="btn btn-warning text-white">Ir</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-comments fa-2x text-success mb-3"></i>
          <h5 class="card-title fw-semibold">Mensajes</h5>
          <p class="card-text">Comunícate con estudiantes.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Tutor/mensajes.php'); ?>" class="btn btn-success text-white">Ir</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-sign-out-alt fa-2x text-danger mb-3"></i>
          <h5 class="card-title fw-semibold">Cerrar Sesión</h5>
          <p class="card-text">Salir de tu cuenta de tutor.</p>
          <a href="?pid=<?php echo base64_encode("presentacion/Autenticar.php")?>&sesion=false" class="btn btn-danger text-white">Cerrar Sesión</a>
        </div>
      </div>
    </div>

  </div>
</div>
