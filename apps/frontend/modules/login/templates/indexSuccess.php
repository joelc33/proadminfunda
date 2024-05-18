<div id="login-page" class="row">
      <div class="col s12 z-depth-4 card-panel">
        <form class="login-form" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>/login/validar" method="post">

          <div class="row" class="center">
            <div class="input-field col s12 center"></div>
            <div class="input-field col s12 center">
              <img src="<?php echo image_path('admbmp.png'); ?>"  class="center" width="350" height="120" alt="PROTRIB" >

              <?php if ($resultado):?>
              <div id="card-alert" class="card gradient-45deg-amber-amber">
                <div class="card-content black-text">
                  <p><i class="material-icons">warning</i> Hay problemas con su validacion</p>
                  <ul>
                    <li><?php echo $resultado; ?></li>
                  </ul>
                </div>
              </div>
              <?php endif; ?>

            </div>
          </div>

          <div class="row margin">
            <div class="input-field col s12">
              <i class="material-icons prefix pt-5">person_outline</i>
              <input id="usuario" name="usuario" type="text" value="" >
              <label for="usuario" class="center-align">Usuario</label>
            </div>
          </div>

          <div class="row margin">
            <div class="input-field col s12">
              <i class="material-icons prefix pt-5">lock_outline</i>
              <input id="password" name="password" type="password"  >
              <label for="password">Contraseña</label>
            </div>
          </div>

          <div class="row">
            <div class="col s12 m12 l12 ml-2 mt-3">
              <input type="checkbox" id="remember-me" />
              <label for="remember-me">Recordarme</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <button type="submit" class="btn waves-effect waves-light col s12 blue"><b>Ingresar</b></button>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m12 l12">
              <p class="margin right-align medium-small">Sistema Administrativo</p>
            </div>
          </div>
        </form>
      </div>
	</div>
	