<!-- inicio.php -->
<div class="header-section text-center py-5" style="background: linear-gradient(135deg, #1e90ff, #87cefa);">
  <i class="fas fa-cloud fa-4x text-white mb-3" style="filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));"></i>
  <h1 class="fw-bold display-4" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #f0f8ff;">CloUD</h1>
  <p class="lead fst-italic mx-auto" style="max-width: 650px; color: #dbeeff;">
    Sistema de tutorías personalizadas para la carrera de Sistematización de datos e Ingeniería en Telemática
  </p>
  <a href="?pid=<?php echo base64_encode('presentacion/autenticar.php'); ?>" 
     class="btn btn-lg text-white mt-4 px-5"
     style="background-color: #0066cc; border-radius: 50px; box-shadow: 0 6px 15px rgba(0, 102, 204, 0.5); transition: background-color 0.3s ease;">
    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
  </a>
</div>

<div class="container my-5">
  <div class="row g-5 justify-content-center">
    <!-- Tutorías -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center border-0" style="background-color: #e9f2ff; border-radius: 15px; transition: transform 0.3s ease;">
        <div class="card-body d-flex flex-column align-items-center px-4 py-5">
          <div class="rounded-circle d-flex align-items-center justify-content-center mb-4"
               style="width: 75px; height: 75px; background-color: #3399ff;">
            <i class="fas fa-chalkboard-teacher text-white fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold mb-3" style="color: #004a99;">Tutorías</h5>
          <p class="card-text text-muted mb-4 px-2" style="color: #334d66;">Accede a tus tutorías como estudiante o tutor.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/autenticar.php'); ?>" 
             class="btn btn-sm text-white px-4" 
             style="background-color: #3399ff; border-radius: 30px; box-shadow: 0 4px 10px rgba(51, 153, 255, 0.4); transition: background-color 0.3s ease;">
            Ver Tutorías
          </a>
        </div>
      </div>
    </div>

    <!-- Materias -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center border-0" style="background-color: #e9f2ff; border-radius: 15px; transition: transform 0.3s ease;">
        <div class="card-body d-flex flex-column align-items-center px-4 py-5">
          <div class="rounded-circle d-flex align-items-center justify-content-center mb-4"
               style="width: 75px; height: 75px; background-color: #007acc;">
            <i class="fas fa-book-open text-white fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold mb-3" style="color: #004a99;">Materias ofertadas</h5>
          <p class="card-text text-muted mb-4 px-2" style="color: #334d66;">Revisa en qué materias puedes obtener o brindar tutorías.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/autenticar.php'); ?>" 
             class="btn btn-sm text-white px-4" 
             style="background-color: #007acc; border-radius: 30px; box-shadow: 0 4px 10px rgba(0, 122, 204, 0.4); transition: background-color 0.3s ease;">
            Ver Materias
          </a>
        </div>
      </div>
    </div>

    <!-- Administración -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100 text-center border-0" style="background-color: #e9f2ff; border-radius: 15px; transition: transform 0.3s ease;">
        <div class="card-body d-flex flex-column align-items-center px-4 py-5">
          <div class="rounded-circle d-flex align-items-center justify-content-center mb-4"
               style="width: 75px; height: 75px; background-color: #004a99;">
            <i class="fas fa-user-shield text-white fs-3"></i>
          </div>
          <h5 class="card-title fw-semibold mb-3" style="color: #004a99;">Administración</h5>
          <p class="card-text text-muted mb-4 px-2" style="color: #334d66;">Accede como administrador para gestionar el sistema.</p>
          <a href="?pid=<?php echo base64_encode('presentacion/autenticar.php'); ?>" 
             class="btn btn-sm text-white px-4" 
             style="background-color: #004a99; border-radius: 30px; box-shadow: 0 4px 10px rgba(0, 74, 153, 0.4); transition: background-color 0.3s ease;">
            Autenticarse
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="text-center py-4 mt-5" style="background: linear-gradient(135deg, #1e90ff, #4ca3ff); color: white;">
  <p class="mb-1 fw-semibold">Facultad Tecnológica - Universidad Distrital Fransisco José de Caldas</p>
  <p class="mb-0">Contacto: <a href="mailto:dectecnologica@udistrital.edu.co" style="color: #cce6ff; text-decoration: underline;">dectecnologica@udistrital.edu.co</a> | PBX: 3239300</p>
  <p class="mb-0">Dirección: Cl. 68d Bis ASur #49F - 70, Bogotá</p>
</footer>

<style>
  /* Card hover effect */
  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0, 102, 204, 0.25);
  }
  /* Button hover effect */
  a.btn:hover {
    filter: brightness(120%);
    text-decoration: none;
  }
</style>
