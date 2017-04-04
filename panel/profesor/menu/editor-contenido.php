
<hr>
<div class="row align-center">
	<div class="col col-10">
	<div id="editor" placeholder="Contenido..." class="animated fadeIn">
	<?php
	$op = explode('$', $_COOKIE['opcion']);
    switch($op[1])
    {
    	  case 'ed-te':
    	  case 'cr-te':
    	  include('../../php/consultar-ediciones.php');
		  $obj = new Ediciones();
           echo $obj->consultarTemario();
        break;
        case 'ed-ta-p':
           echo $info[4];
        break;
        case 'ed-per':
           echo $info[6];
        break;
    }
	
	?>
	</div>
	</div>
</div>

<div class="row align-center">
	<div class="col col-3">
	<button class="button w100 animated fadeIn" id="guardar">Guardar</button>
	</div>
</div>

<script>
EasyEditor.prototype.youtube = function(){
        var _this = this;
        var settings = {
            buttonIdentifier: 'insertar-video-youtube',
            buttonHtml: 'Insert youtube video',
            clickHandler: function(){
            	var videoLink = prompt('Insertar vídeo de youtube', '');
                var videoId = _this.getYoutubeVideoIdFromUrl(videoLink);

                if(videoId.length > 0) {
                    var iframe = document.createElement('iframe');
                    $(iframe).attr({ width: '560', height: '315', frameborder: 0, allowfullscreen: true, src: 'https://www.youtube.com/embed/' + videoId });
                    _this.insertAtCaret(iframe);
                }
                else {
                   alertify.error('Link de Youtube invalido.');
                }

            }
        };

        _this.injectButton(settings);
    };
					
$(document).ready(function() {
    new EasyEditor('#editor', {
    buttons: ['bold', 'italic', 'link', 'h2', 'h3', 'h4', 'alignleft', 'aligncenter', 'alignright', 'quote', 'code', 'image', 'youtube','list', 'x'],
    buttonsHtml: {
        'bold': '<i class="fa fa-bold"></i>',
        'italica': '<i class="fa fa-italic"></i>',
        'link': '<i class="fa fa-link"></i>',
        'header-2': '<i class="fa fa-header"></i>2',
        'header-3': '<i class="fa fa-header"></i>3',
        'header-4': '<i class="fa fa-header"></i>4',
        'alinear-izquierda': '<i class="fa fa-align-left"></i>',
        'centrar': '<i class="fa fa-align-center"></i>',
        'alinear-derecha': '<i class="fa fa-align-right"></i>',
        'comillas': '<i class="fa fa-quote-left"></i>',
        'codigo': '<i class="fa fa-code"></i>',
        'insert-image': '<i class="fa fa-picture-o"></i>',
        'insertar-video-youtube': '<i class="fa fa-youtube"></i>',
        'lista': '<i class="fa fa-list-ol"></i>',
        'borrar': '<i class="fa fa-ban"></i>'
    }
    });
});
</script>