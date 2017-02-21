<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>ETSIemplea - UHU</title>
  <link rel="shortcut icon" href="../images/favicon.ico"/>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="../js/materialize.js"></script>
  <script src="../js/init.js"></script>
  <script src="../vendors/ckeditor/ckeditor.js"></script>
  <script type="text/javascript" src="../js/nhpup_1.1.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
    <nav id="oferta" class="ColorUHU" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="/etsi/etsiemplea" class="brand-logo white-text">
        <img src="../images/logo_etsiemplea1.png">
      </a>
      <div class="text-logo title">
        Rechazar oferta        
      </div>
    </div>
</nav>

    <div class="container">
      <div class="section">
        {!! Form::open(['url' => 'confirmreject', 'id'=>'formReject']) !!}

              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">thumb_down</i>
                  <label>Motivo del rechazo</label>
                  <div class="radioDiv">
                      <input required class="validate" name="motivo" type="radio" id="Perfil solicitado inapropiado" value="Perfil solicitado inapropiado"
                      onclick="$(this).parent().parent().find('i').addClass('active');" />
                      <label for="Perfil solicitado inapropiado">Perfil solicitado inapropiado</label>
                    <br/>
                      <input name="motivo" type="radio" id="Oferta incompleta" value="Oferta incompleta"
                      onclick="$(this).parent().parent().find('i').addClass('active');" />
                      <label for="Oferta incompleta">Oferta incompleta</label>
                    <br/>
                      <input name="motivo" type="radio" id="Oferta fraudulenta" value="Oferta fraudulenta"
                      onclick="$(this).parent().parent().find('i').addClass('active');" />
                      <label for="Oferta fraudulenta">Oferta fraudulenta</label>
                    <br/>
                      <input name="motivo" type="radio" id="Otros" value="Otros"
                      onclick="$(this).parent().parent().find('i').addClass('active');" />
                      <label for="Otros">Otros</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">mode_edit</i>
                  <textarea id="descript" name="descript" class="ckeditor materialize-textarea" required /></textarea>
                  <label for="descript">Descripción de Rechazo&nbsp;&nbsp;&nbsp;
                  <i class="tiny material-icons" onmouseover="nhpup.popup('No se permiten textos con mas de 1500 carácteres.');">live_help</i></label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input type="hidden" name="idhidden" id="idhidden" value=" <?=$id?>" />
                </div>
              </div>
      			  
      			  
                    <div class="row">
                      <div style="float: right;">
                        <button class="btn btn-primary waves-effect waves-light" id="submit-form" type="submit">Enviar
                          <i class="material-icons right">send</i>
                        </button>
                      </div>
                    </div>

              <br/>
          {!! Form::close() !!}
      </div>
    </div>

    <div class="parallax-container valign-wrapper">
      <div class="section no-pad-bot"></div>
      <div class="parallax"><img src="../images/background.jpg" alt="Unsplashed background img 3"></div>
    </div>

    <footer id="footer" class="page-footer ColorUHU">
    <div class="container">
      <div class="row">
        <div class="col l6 s12">
          <h5 class="white-text"><i class="small material-icons">class</i>ETSIEmplea - UHU</h5>
          <p class="grey-text text-lighten-4">Nuestra aplicación le facilitará el envío de ofertas a los estudiantes de la ETSI, la difusión de las mismas será mucho más rápida y personalizada encontrando el perfil que necesita.</p>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text"> <i class="small material-icons">thumb_up</i> Síguenos</h5>
          <ul>
            <li><a class="white-text" href="https://www.facebook.com/Escuela-T%C3%A9cnica-Superior-de-Ingenier%C3%ADa-Universidad-de-Huelva-160605473967785/"><img src="../images/facebook-40.png"></a>
            <a class="white-text" href="https://twitter.com/etsi_uhu"><img src="../images/twitter-40.png"></a>
            <a class="white-text" href="https://www.linkedin.com/in/universidaddehuelva"><img src="../images/linkedIn-40.png"></a></li>

          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text"> <i class="small material-icons">perm_identity</i> Contacto</h5>
          <ul>
      <li><a class="white-text" href="mailto:etsiemplea@uhu.es">Soporte</a></li>
            <li><a class="white-text" href="http://www.uhu.es/">UHU</a></li>
            <li><a class="white-text" href="http://www.uhu.es/etsi/">ETSI</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Copyright © <a class="brown-text text-lighten-3">ETSI - UHU | </a>
      <a class="brown-text text-lighten-3" href="tel:+34959217312">959217312 </a> 
      <a class="brown-text text-lighten-3" href=mailto:etsiemplea@uhu.es>| etsiemplea@uhu.es</a> 
      </div>
    </div>
  </footer>
</body>
</html>