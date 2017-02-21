<script>
  //Nombre de la empresa
  $("#company_name").on("change", function() {
    $("#preview-company_name1").text(this.value);
    $("#preview-company_name2").text(this.value);
  });

  //Descripción
  CKEDITOR.replace( 'descript' );
  CKEDITOR.instances['descript'].on( 'change', function(e) {
    var data = e.editor.getData();
    $("#preview-descript").html(data);
    
    if(data.length > 0) {
      $("#descript").parent().find('i').addClass('active');
    } else {
      $("#descript").parent().find('i').removeClass('active');
    }
  });

  CKEDITOR.instances['descript'].on( 'focus', function(e) {
      $("#descript").parent().find('i').addClass('active');
  });

  CKEDITOR.instances['descript'].on( 'blur', function(e) {
    if(e.editor.getData().length === 0) {
      $("#descript").parent().find('i').removeClass('active');
    }
  });

  //Contacto
  $("#telephone").on("change", function() {
    $("#preview-telephone").html('<a href="tel: ' + this.value + '">' + this.value + '</a>');
  });
  $("#email").on("change", function() {
    $("#preview-email").html('<a href="mailto: ' + this.value + '">' + this.value + '</a>');
  });

  //Oferta de Trabajo
  function radioValueChanged()
  {
    $("#preview-tipo-oferta1").text($(this).val());
    $("#preview-tipo-oferta2").text($(this).val());
  }

  //Destinatarios
  function selectValueChanged()
  {
    var texto = "";
    $.each($(this).val(), function(i, val) {
      texto += "- Ingeniería "+val+"<br>";
    });
    $("#preview-destinatarios").html(texto);
  }

  //URLs
  function urlValueChanged()
  {
    var links = $("#url").val().split('\n');

    var texto = "";
    var substring = "http://";
    var substring2 = "https://";
    $.each(links, function (i, val) {
      if(val.indexOf(substring) > -1 || val.indexOf(substring2) > -1) {
        texto += '<a href="' + val + '">' + val + '</a><br>'
      } else {
        texto += '<a href="http://' + val + '">http://' + val + '</a><br>'
      }
    });
    $("#preview-url").html(texto);
  }


  jQuery(document).ready(function ()
  {
    //Oferta de Trabajo
    $("input[name='TipoOferta']").change(radioValueChanged);
    //Destinatarios
    $("#select1").change(selectValueChanged);
    //URLs
    $("#url").change(urlValueChanged);
  })
</script>

<style>
  .preview-descript ul li:before {
    content: "• ";
    padding-left: 2em;
  }
</style>

<div class="section">
  <span class="text-ColorUHU">Asunto</span>
  <table class="bordered-preview">
    <tbody>
      <tr>
        <td>
          <b><span id="preview-tipo-oferta1"></span> - <span id="preview-company_name1"></span></b>
        </td>
      </tr>
    </tbody>
  </table>
</div>
<div class="section">
  <span class="text-ColorUHU">Cuerpo</span>
  <table class="bordered-preview">
    <tbody>
      <tr>
        <td>
          <span id="preview-company_name2" class="company_name"></span>
          </br>
          <span id="preview-tipo-oferta2"></span>
          </br></br><span class="text-ColorUHU-secundary">Destinatarios</span></br>
          <span id="preview-destinatarios"></span>
          </br><span class="text-ColorUHU-secundary">Descripción</span></br>
          <span id="preview-descript" class="preview-descript"></span>
          </br></br><span class="text-ColorUHU-secundary">URLs</span></br>
          <span id="preview-url"></span>
          </br><span class="text-ColorUHU-secundary">Contacto</span></br>
          <span id="preview-telephone"></span></br>
          <span id="preview-email"></span>
        </td>
      </tr>
    </tbody>
  </table>
</div>