<body themebg-pattern="theme4" style="
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: url(vistas//img/plantilla/fondo.jpg);
    background-size: cover;
    overflow: hidden;
    z-index: -1;
">
<div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <section class="login-block" >
    <div class="container" >
      <div class="row">
        <div class="col-sm-12">
          <form id="formIngreso" method="post" class="md-float-material form-material">
            
            <div class="auth-box card">
              <div class="card-block">
                <div class="row m-b-20">
                  <div class="col-md-12">
                    <div class="text-center">
                      <img src="vistas/img/plantilla/logo.png" alt="logo.png">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="text-center">
                      <h4 class="text-center text-info p-t-20">Ingreso al sistema</h4>
                    </div>
                  </div>
                </div>
                <div class="form-group form-primary">
                  <input type="text" id="ingUsuario" name="ingUsuario" class="form-control"/>
                  <span class="form-bar"></span>
                  <label class="float-label">Usuario</label>
                </div>
                <div class="form-group form-primary">
                  <input type="password" name="ingPassword" id="ingPassword" class="form-control" autocomplete="new-password" #password />
                  <span class="form-bar"></span>
                  <label class="float-label">Contraseña</label>
                </div>
                <div class="row m-t-30">
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Ingresar</button>
                  </div>
                  <?php
                    $login = new ControladorIngreso();
                    $login -> ctrIngreso();
                  ?>
                </div>

                <div class="col-sm-12 text-center">
                  <span class="text-muted">UTN - Facultad Regional Tucumán</span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>