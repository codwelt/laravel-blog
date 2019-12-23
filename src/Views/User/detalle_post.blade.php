<div style="background-color: rgba(255,255,255,1)">
    <div class="imgportada "
         style="width: 100%; height: 100vh; background-image: url({{$post['data']['url_imagen']}}); background-position: center; background-size: cover; background-attachment: fixed;">
        <div style="padding: 2%; width: 100%; height: 100vh; background-color: rgba(0,0,0,.5); display: flex; justify-content: center; vertical-align: middle; align-content: center; align-items: center;">
            <div >
                <h1 class="titulopost animated bounceIn"><strong>{{$post['data']['titulo']}}</strong></h1>
                <hr style="background-color: #fff;">
                <p style="color: #fff; text-shadow: 1px 2px 3px #000;">{{$post['data']['resumen']}}</p>
                <span style="color: #fff; text-shadow: 1px 2px 3px #000;">
                     <i>Autor: {{$post['data']['autor']['name']}}
                         - {{$post['data']['fecha_publicacion']}}</i>
                 </span>
                <ul class="redessocialespost letrasblancas">
                    <li><i class="fas fa-share-alt"></i></li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{$post['data']['url']}}"
                       target="_blank">
                        <li><i class="fab fa-facebook-f"></i></li>
                    </a>
                    <a href="https://twitter.com/home?status={{$post['data']['url']}}" target="_blank">
                        <li><i class="fab fa-twitter"></i></li>
                    </a>
                    <a href="https://plus.google.com/share?url={{$post['data']['url']}}"
                       target="_blank">
                        <li><i class="fab fa-google-plus-g"></i></li>
                    </a>
                    <a href="https://pinterest.com/pin/create/button/?url={{$post['data']['url_imagen']}}?v=23&media={{$post['data']['url']}}&description={{$post['data']['resumen']}}%0A="
                       target="_blank">
                        <li><i class="fab fa-pinterest-p"></i></li>
                    </a>
                    <a href="mailto:https://codwelt.com?&subject=Mira este post de codwelt&body=Hola,%20quiero%20compartirte%20este%20nuevo%20post%20de%20{{$post['data']['url']}}%20{{$post['data']['url_imagen']}}"
                       target="_blank">
                        <li><i class="far fa-envelope"></i></li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid postdetallep">
        <div class="row">
            <div class="col-md-9">
                <div style="width: 100%; display: block;">
                    {!! $post['data']['contenido'] !!}
                </div>
            </div>
            <div class="col-md-3">
                @include('lateralpost')
            </div>

            <div class="col-md-12">
                <hr>
                <spam class="creditospost scrollflow -slide-top -opacity">
                    <i>Autor: {{$post['data']['autor']['name']}}
                        - {{$post['data']['fecha_publicacion']}}</i>
                </spam>
                @if(isset($post['data']['hashtags']))
                    <p class="scrollflow -slide-top -opacity">@for($a = 0; $a < count($post['data']['hashtags']); $a++)
                            {{$post['data']['hashtags'][$a]['nombre']}} /
                        @endfor</p>
                @endif
                <ul class="redessocialespost letrasnegras scrollflow -slide-top -opacity">
                    <li><i class="fas fa-share-alt"></i></li>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{$post['data']['url']}}"
                       target="_blank">
                        <li><i class="fab fa-facebook-f"></i></li>
                    </a>
                    <a href="https://twitter.com/home?status={{$post['data']['url']}}" target="_blank">
                        <li><i class="fab fa-twitter"></i></li>
                    </a>
                    <a href="https://plus.google.com/share?url={{$post['data']['url']}}"
                       target="_blank">
                        <li><i class="fab fa-google-plus-g"></i></li>
                    </a>
                    <a href="https://pinterest.com/pin/create/button/?url={{$post['data']['url_imagen']}}?v=23&media={{$post['data']['url']}}&description={{$post['data']['resumen']}}%0A="
                       target="_blank">
                        <li><i class="fab fa-pinterest-p"></i></li>
                    </a>
                    <a href="mailto:https://codwelt.com?&subject=Mira este post de codwelt&body=Hola,%20quiero%20compartirte%20este%20nuevo%20post%20de%20{{$post['data']['url']}}%20{{$post['data']['url_imagen']}}"
                       target="_blank">
                        <li><i class="far fa-envelope"></i></li>
                    </a>
                </ul>

                <div class="row">
                    <div class="col-md-8">
                        <div class="row scrollflow -slide-top -opacity">
                            <div class="col-md-6">
                                <div class="formcomentarios scrollflow -slide-top -opacity">
                                    <div id="nuevo-comentario animated  bounce">
                                        <form id="send-comment"
                                              action="{{route('blog.api.user.comments.store')}}"
                                              method="POST">
                                            <input type="hidden" name="postID" value="{{$post['data']['id']}}">
                                            <textarea required name="content"
                                                      placeholder="Escribir comentario ..."></textarea>
                                            @blogCodWelt_isCommentator
                                            <input type="hidden" name="commentatorID"
                                                   value="{{Auth::user()->getCommentatorIDEncrypted()}}">
                                            @else
                                                <input required type="email" name="email"
                                                       placeholder="Tucorreo@example.com">
                                                @endblogCodWelt_isCommentator
                                                <button type="submit" class="animated  bounce">ENVIAR</button>
                                        </form>

                                    </div>

                                    <div id="lista-comentarios">
                                        <h3>comentarios:</h3>
                                        <ul class="list-unstyled" id="lista-comentarioss">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        @if(count($post['data']['fuentes']) > 0)
                            <ul>
                                @for($a = 0; $a < count($post['data']['fuentes']); $a++)
                                    <li class="scrollflow -slide-top -opacity">{{$post['data']['fuentes'][$a]['titulo']}}
                                        , {{$post['data']['fuentes'][$a]['autor']}}
                                        , {{$post['data']['fuentes'][$a]['url']}}
                                        <br>Consulta: {{$post['data']['fuentes'][$a]['fecha_consulta']}},
                                        Publicacion: {{$post['data']['fuentes'][$a]['año_publicacion']}}
                                    </li>
                                @endfor
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('foot')
</div>
<codweltrelacionados id="rutarelacionados" value="{{$post['data']['urlRelated']}}"></codweltrelacionados>
<script type="text/javascript">
    $(document).ready(function () {
        cargarComent();
        $.ajax({
            url: $('#rutarelacionados').attr('value'),
            dataType: "json",
            data: "",
            method: "get",
            success: function (result) {
                console.log("Esto son los relacionados");
                console.log(result);
                for (var e = 0; e < result['data'].length; e++) {
                    var htmlrefe = '<li class="media zoomInLeft animated"><img class="mr-3" src="' + result['data'][e]['url_imagen'] + '" style="width: 200px;" alt="' + result['data'][e]['titulo'] + '"><div class="media-body"><h5 class="mt-0 mb-1"><a href="' + result['data'][e]['url'] + '">' + result['data'][e]['titulo'] + '</a></h5>' + result['data'][e]['fecha_publicacion'] + '</div></li>';
                    $('#listaderelacionados').append(htmlrefe);
                }
            },
            error: function (result) {
                console.log("Error al traer relacionados")
            },
            beforeSend: function () {
                $('#listaderelacionados').children('li').remove();
                console.log('buscando relacionados ...');
            }
        });
        //Cargar comentarios
        //Enviar comentario
        $("#send-comment").submit(function (event) {
            event.preventDefault();
            var formData = $("#send-comment").serialize() + "&_token=" + $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "{{route('blog.api.user.comments.store')}}",
                dataType: "json",
                data: formData,
                method: "POST",
                success: function (result) {
                    cargarComent();
                    $('#send-comment').css('display', 'none');
                },
                error: function (result) {

                },
                beforeSend: function () {
                }
            });
        });

        function cargarComent() {
            $.ajax({
                url: "{{route('blog.api.user.comments.search')}}",
                dataType: "json",
                data: "byPostID={{$post['data']['id']}}", //"_token=" + $("meta[name='csrf-token']").attr("content") +
                method: "GET",
                success: function (result) {
                    var comentarios = result.data;
                    for (i = 0; i < comentarios.length; i++) {
                        var comentarioHTML = "<li class='media listacomentarios'><i class='fas fa-user-circle mr-3' style='font-size:250%;'></i><div class='media-body'><h5 class='mt-0 mb-1'>" + comentarios[i].contenido + "</h5>" + comentarios[i].comentador.nombre + ": " + comentarios[i].comentador.email + " - " + comentarios[i].fecha_creacion + "</div></li>";
                        $("#lista-comentarioss").append(comentarioHTML);
                    }
                },
                error: function (result) {

                },
                beforeSend: function () {
                    $("#lista-comentarioss").children('li').remove();
                }
            });
        }
    });
</script>