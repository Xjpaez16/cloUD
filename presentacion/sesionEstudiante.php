<?php
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] != "estudiante") {
    header("Location: ?pid=" . base64_encode("presentacion/noAutorizado.php"));
    exit();
}

if (!isset($_SESSION["estudiante"])) {
    echo "<div class='text-danger text-center mt-4'>Error: sesión inválida. Por favor vuelve a iniciar sesión.</div>";
    exit();
}

$estudiante = unserialize($_SESSION["estudiante"]);
$estudiante->consultar(); 
?>
<div class="container mt-4">
  <h5 class="text-primary text-center fw-bold mb-4">Datos del Estudiante</h5>

  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Nombre:</span>
    <span><?php echo $estudiante->getNombre(); ?></span>
  </div>
  <div class="mb-2 d-flex">
    <span class="fw-bold me-2">Correo:</span>
    <span><?php echo $estudiante->getCorreo(); ?></span>
  </div>
</div>

<div class="container my-5">
  <div class="text-center mb-4">
    <h2 class="fw-bold text-primary">Panel del Estudiante</h2>
    <p class="text-muted">Solicita y administra tus tutorías</p>
  </div>
  <div class="row g-4 justify-content-center">

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-search fa-2x text-primary mb-3"></i>
          <h5 class="card-title fw-semibold">Buscar Tutorías</h5>
          <p class="card-text">Encuentra materias y tutores disponibles.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Estudiante/buscarTutorias.php'); ?>" class="btn btn-primary text-white">Ir</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-calendar-check fa-2x text-success mb-3"></i>
          <h5 class="card-title fw-semibold">Mis Tutorías</h5>
          <p class="card-text">Consulta el estado y agenda de tus tutorías.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Estudiante/misTutorias.php'); ?>" class="btn btn-success text-white">Ir</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-comments fa-2x text-warning mb-3"></i>
          <h5 class="card-title fw-semibold">Mensajes</h5>
          <p class="card-text">Comunícate con tus tutores.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/Estudiante/mensajes.php'); ?>" class="btn btn-warning text-white">Ir</a>
        </div>
      </div>
    </div>
    
    <div class="col-md-4">
      <div class="card h-100 text-center shadow-sm">
        <div class="card-body">
          <i class="fas fa-sign-out-alt fa-2x text-danger mb-3"></i>
          <h5 class="card-title fw-semibold">Cerrar Sesión</h5>
          <p class="card-text">Salir de tu cuenta de estudiante.</p>
          <a href="?pid=<?php echo base64_encode("presentacion/autenticar.php")?>&sesion=false" class="btn btn-danger text-white">Cerrar Sesión</a>
        </div>
      </div>
    </div>

  </div>
</div>
