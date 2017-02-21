<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
</head>

<body>
  <span style="font-size: 20px; font-weight: bold;">Descripción de rechazo - {!! $motivo !!}</span>
  <p><?php echo nl2br($desc_motivo) ?></p>
  <table style="padding: 20px;">
    <tbody>
      <tr>
        <td><span style="font-size: 15px; font-weight: bold;">{!! $name !!}</span></td>
      </tr>
      <tr>
        <td style="border-bottom:1px solid #d0d0d0; padding-bottom: 10px;">{!! $type !!}</td>
      </tr>
      </tr>
      <tr>
        <td>
            <ul style="list-style: none;">
              <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">Destinatarios</li>
              <li>{!! $target !!}</li>
            </ul>
        </td>
      </tr>
      <tr>
        <td>
          <ul style="list-style: none;">
            <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">Descripción</li>
            <li>
              <?php echo nl2br($description) ?>
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <td>
            <ul style="list-style: none;">
                <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">Contacto</li>
                <li>{!! $phone !!}</li>
                <li style="text-decoration: none;">{!! $email !!}</li>
            </ul>
        </td>
      </tr>
      <tr>
        <td>
            <ul style="list-style: none;">
                <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">URLs</li>
                <li style="text-decoration: none;">{!! $urls !!}</li>
            </ul>
        </td>
      </tr>
      <!--Si tiene enlace de confirmacion se añade esto al correo: -->
      <?php
        if(isset($url)){
      ?>
      <tr>
        <td>
          <b>Para confirmar la oferta haga <a style="text-decoration: none; margin-top: 10px;" href='{!! $url !!}'>click aquí</a></b>
        </td>
      </tr>
      <tr>
        <td>
          <b>Para rechazar la oferta haga <a style="text-decoration: none; margin-top: 10px;" href='{!! $url2 !!}'>click aquí</a></b>
        </td>
      </tr>
      <?php
        }
      ?>
      <!--Si tiene enlace de desubscripcion se añade esto al correo: -->
      <?php
        if(isset($urluns)){
      ?>
      <tr>
        <td>
          <b>Si no desea recibir mas correos haga <a style="text-decoration: none; margin-top: 10px;" href='{!! $urluns !!}'>click aquí</a></b>
        </td>
      </tr>
      <?php
        }
      ?>
    </tbody>
  </table>
  <footer style="font-style: italic; margin: 20px; text-align: center; padding-top: 10px; border-top: 2px solid black;">
    Para más información póngase en contacto con la dirección del centro en el siguiente email: 
    <a href=mailto:direccion@etsi.uhu.es>direccion@etsi.uhu.es</a><br>
    Muchas gracias.
    <br><br>
    <b><span style="font-size:10px;">ETSIEmplea - Escuela Técnica Superior de Ingeniería - Universidad de Huelva</span></b>
  </footer>
</body>
</html>
