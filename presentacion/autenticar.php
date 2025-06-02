<?php
if(isset($_GET["sesion"]) && $_GET["sesion"] == "false"){
    session_destroy();
    header("Location: ?pid=" . base64_encode("presentacion/Autenticar.php"));
    exit();
}

if(isset($_POST["autenticar"])){
    $correo = filter_var(trim($_POST["correo"]), FILTER_SANITIZE_EMAIL);
    $clave = trim($_POST["clave"]);
    
    if(empty($correo) || empty($clave)){
        echo "<div class='text-center text-danger mt-3'>Por favor complete todos los campos</div>";
        exit();
    }
    
    $admin = new Administrador("", "", $correo, "", $clave);
    if($admin->autenticar()){
        $_SESSION["id"] = $admin->getId();
        $_SESSION["rol"] = "admin";
        $_SESSION["administrador"] = serialize($admin);
        header("Location: ?pid=" . base64_encode("presentacion/sesionAdmin.php"));
        exit();
    }
    
    $tutor = new Tutor("", "", $correo, "", $clave);
    if($tutor->autenticar()){
        $_SESSION["id"] = $tutor->getId();
        $_SESSION["rol"] = "tutor";
        $_SESSION["tutor"] = serialize($tutor);
        header("Location: ?pid=" . base64_encode("presentacion/sesionTutor.php"));
        exit();
    }
    
    $estudiante = new Estudiante("", "", $correo, "", $clave);
    if($estudiante->autenticar()){
        $_SESSION["id"] = $estudiante->getId();
        $_SESSION["rol"] = "estudiante";
        $_SESSION["estudiante"] = serialize($estudiante);
        header("Location: ?pid=" . base64_encode("presentacion/sesionEstudiante.php"));
        exit();
    }
    
    echo "<div class='text-center text-danger mt-3'>Credenciales incorrectas. Por favor verifique sus datos.</div>";
}
?>

<div class="container py-4">
  <div class="row align-items-center">
    <div class="col-md-3 text-center">
      <i class="fas fa-cloud fa-5x" style="color: #007acc; filter: drop-shadow(0 2px 3px rgba(0,0,0,0.15));"></i>
    </div>
    <div class="col-md-9">
      <h1 class="fw-bold" style="color: #007acc;">Bienvenido a CloUD</h1>
      <p class="text-secondary fs-5" style="color: #336699;">Accede como administrador, tutor o estudiante para acceder a la información</p>
    </div>
  </div>
</div>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow rounded-4" style="background-color: #e6f0ff; border: none;">
        <div class="card-header text-white bg-primary rounded-top-4" style="background: linear-gradient(135deg, #1e90ff, #4ca3ff);">
          <h4 class="mb-0">Iniciar Sesión</h4>
        </div>
        <div class="card-body p-4">
          <form method="POST" action="">
            <div class="mb-3">
              <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
              <input type="email" class="form-control border-primary" id="correo" name="correo" required placeholder="correo@ejemplo.com" style="box-shadow: inset 0 0 6px #3399ff;">
            </div>
            <div class="mb-3">
              <label for="clave" class="form-label fw-semibold">Contraseña</label>
              <input type="password" class="form-control border-primary" id="clave" name="clave" required placeholder="********" style="box-shadow: inset 0 0 6px #3399ff;">
            </div>
            <button type="submit" name="autenticar" class="btn btn-primary w-100 fw-semibold" 
                    style="background: linear-gradient(135deg, #1e90ff, #4ca3ff); border-radius: 50px; padding: 12px 0; box-shadow: 0 6px 15px rgba(30, 144, 255, 0.5); transition: background-color 0.3s ease;">
              Iniciar Sesión
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  body {
    background: #f0f7ff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .form-control:focus {
    border-color: #3399ff;
    box-shadow: 0 0 8px #3399ff;
  }
  button.btn-primary:hover {
    filter: brightness(110%);
  }
</style>
