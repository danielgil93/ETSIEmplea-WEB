@extends('layouts.template')

@section('title', 'ETSIemplea - UHU')

@section('content')

<style>
  .preview-descript ul li:before {
    content: "- ";
    padding-left: 2em;
  }
</style>
    <div class="container">
      <div class="section">
	  
	  <div class="row">
		<p class="text-confirm"><b>Oferta enviada correctamente</b>
		<br/>Recibir&aacute; un correo electr&oacute;nico cuando la oferta haya sido validada</p>
	  </div>
	  
	  <div class="row">
		  <span class="text-ColorUHU">Asunto</span>
		  <table class="bordered-preview">
			<tbody>
			  <tr>
				<td>
				  <b><span id="preview-tipo-oferta1"><?php echo $type;?></span> - <span id="preview-company_name1"><?php echo $name;?></span></b>
				</td>
			  </tr>
			</tbody>
		  </table>
		<div class="section">
		  <span class="text-ColorUHU">Cuerpo</span>
		  <table class="bordered-preview">
			<tbody>
			  <tr>
				<td>
				  <span id="preview-company_name2" class="company_name"><?php echo $name;?></span>
				  </br>
				  <span id="preview-tipo-oferta2"><?php echo $type;?></span>
				  </br></br><span class="text-ColorUHU-secundary">Destinatarios</span></br>
				  <span id="preview-destinatarios"><?php echo $target;?></span></br>
				  </br><span class="text-ColorUHU-secundary">Descripci&oacute;n</span></br>
				  <span id="preview-descript" class="preview-descript"><?php echo $description;?></span>
				  </br></br><span class="text-ColorUHU-secundary">URLs</span></br>
				  <span id="preview-url"><?php echo $urls;?></span></br>
				  </br><span class="text-ColorUHU-secundary">Contacto</span></br>
				  <span id="preview-telephone"></span><a href="tel:<?php echo $phone;?>"><?php echo $phone;?></a></br>
				  <span id="preview-email"><a href="mailto:<?php echo $email;?>"><?php echo $email;?></a></span>
				</td>
			  </tr>
			</tbody>
		  </table>
		  </div>
		  </div>
      </div>
    </div>

    <div class="parallax-container valign-wrapper">
      <div class="section no-pad-bot"></div>
      <div class="parallax"><img src="images/background.jpg" alt="Unsplashed background img 3"></div>
    </div>
	

@endsection