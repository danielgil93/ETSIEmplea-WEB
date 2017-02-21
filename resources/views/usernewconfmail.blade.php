<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
</head>

<body>
  <table style="padding: 20px;">
    <tbody>
      <tr>
        <td><span style="font-size: 20px; font-weight: bold; border-bottom:1px solid #d0d0d0; padding-bottom: 10px;">{!! $name !!}</span></td>
      </tr>
      <tr>
        <td>
            <ul style="list-style: none;">
              <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">Datos</li>
              <li>Dni: {!! $dni !!}</li>
              <li>Estudios: {!! $degree !!}</li>
            </ul>
        </td>
      </tr>
      <tr>
        <td>
            <ul style="list-style: none;">
                <li style="font-size: 15px; color: #8A0B0B; font-weight: bold;">Contacto</li>
                <li style="text-decoration: none;">{!! $email !!}</li>
            </ul>
        </td>
      </tr>
      <!--Si tiene enlace de confirmacion se añade esto al correo: -->
      <tr>
        <td>
          <b>Para verificar su usuario haga <a style="text-decoration: none; margin-top: 10px;" href='{!! $url !!}'>click aquí</a></b>
        </td>
      </tr>
    </tbody>
  </table>
  <footer style="font-style: italic; margin: 20px; text-align: center; padding-top: 10px; border-top: 2px solid black;">
    Para más información póngase en contacto con el webmaster de la aplicación en el siguiente email: 
    <a href=mailto:etsiemplea@uhu.es>etsiemplea@uhu.es</a><br>
    Muchas gracias.
    <br><br>
    <b><span style="font-size:10px;">ETSIEmplea - Escuela Técnica Superior de Ingeniería - Universidad de Huelva</span></b>
  </footer>
</body>
</html>
