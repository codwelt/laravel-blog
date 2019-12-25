<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Configuracion del Blog</title>
</head>
<body>
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<div class="container-fluid">
    @if (count($errors) > 0)
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" id="formUpdate" class="formulariodeposts" action="{{route('codwelt_blog.admin.posts.store')}}"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-10">
                <div class="col-md-12 form-group">
                    <h2>Titulo</h2>


                    <input type="text" value="{{old('titulo')}}" name="titulo" id="titleToSlug" required
                           class="form-control"/>

                    <script type="text/javascript">
                        $(function () {
                            $('#inputSlug').slugIt({
                                output: '#inputSlug'
                            });
                        });
                    </script>

                </div>
                <div class="col-md-12 form-group">
                    <textarea id="ckeditor" class="ckeditor" style="display: none;" name="contenido"
                              required>{{old('contenido')}}</textarea>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light mb-3">
                    <input type="button" id="publicar" value="Publicar" class="btn btn-success block inpubli">
                    <div class="card-body">
                        <label for="imagen" class="btn btn-link"><i class="fas fa-upload"></i> Subir imagen</label>
                        <input type="file" name="imagen" onchange="readURL(this);" id="imagen" class="imagensubir"
                               required>
                        <img id="preview-mini" class="img-thumbnail" src="http://placehold.it/180" alt="Preview"/>

                        <i>Especificaciones maximas dimenciones min_width=100, min_height=200, max_width=4096,
                            max_height=2304</i>

                    </div>
                </div>
                <div class="card bg-light ">
                    <div class="card-header">Resumen</div>
                    <div class="card-body">
                            <textarea class="form-control" name="resumen" required
                                      style="height:20vh;">{{old('resumen')}}</textarea>
                    </div>
                </div>
                <div class="card bg-light " style="max-width: 18rem;">
                    <div class="card-header">Fuentes</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <button type="button" id="addfuente" class="btn btn-link inpubli">Agregar fuente
                            </button>
                        </div>
                        <div id="cuerpofuente">

                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header">Hashtags</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <button type="button" id="addcategorias" class="btn btn-link inpubli">Agregar hastags
                            </button>
                        </div>
                        <div id="cuerpohashtags">
                        </div>
                    </div>
                </div>
                <div class="card bg-light mb-3" style="max-width: 18rem;">
                    <div class="card-header">SEO</div>
                    <div class="card-body">
                        <h6>KeyWords</h6>
                        <input type="text" class="form-control" name="meta_keywords"
                               value="{{old('meta_keywords')}}"/>
                        <h6>Slug</h6>
                        <input type="text" name="slug" id="inputSlug" class="form-control" value="{{old('slug')}}"/>
                    </div>
                </div>
            </div>
        </div>
        @csrf
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/slugify@1.3.6/slugify.min.js"></script>
<script type="text/javascript">
    //Previwe
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-mini')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function () {

        ClassicEditor.create(document.querySelector('#ckeditor'), {
            link: {
                decorators: {
                    addGreenLink: {
                        mode: 'automatic',
                        attributes: {
                            class: 'my-green-link'
                        }
                    }
                }
            }
        })
            .catch(error => {
                console.error(error);
            });

        let contadorfuentes = $('#etiquetasfuentes').attr('value');

        $('#addfuente').click(function () {
            let cuerpofuen = $('#cuerpofuente');
            contadorfuentes++;
            cuerpofuen.append('<div class="form-group"><label for="">Autor</label><input class="form-control" type="text" name="fuentes[' + contadorfuentes + '][autor]" ></div>');
            cuerpofuen.append('<div class="form-group"><label for="">Url</label><input class="form-control" type="text" name="fuentes[' + contadorfuentes + '][url]"></div>');
            cuerpofuen.append('<div class="form-group"><label for="">Titulo</label><input class="form-control" type="text" name="fuentes[' + contadorfuentes + '][titulo]" ></div>');
            cuerpofuen.append('<div class="form-group"><label for="">Año Publicacion</label><input class="form-control" type="number" min="1960" max="2018" name="fuentes[' + contadorfuentes + '][ano_publicacion]" ></div>');
            cuerpofuen.append('<div class="form-group"><label for="">Fecha de fecha_consulta</label><input class="form-control" type="date" min="1960" max="2018" name="fuentes[' + contadorfuentes + '][fecha_consulta]" ></div>');
            cuerpofuen.append('<div class="form-group"><hr></div>');

        });
        $('#addcategorias').click(function () {
            $('#cuerpohashtags').append('<div class="form-group"><label for="">Nombre</label><input type="text" class="form-control" name="hashtags[][nombre]"></div>');
        });

        $(function () {
            $('#titleToSlug').slugIt({
                output: '#inputSlug'
            });
        });
        $("#publicar").on('click', function (event) {
            let $form = $("#formUpdate");
            let confirmacion = confirm("Esta seguro que quiere publicar?");
            if (confirmacion) {
                $form.append('<input type="hidden" value="Publicado" name="state"/>');
                $form.submit();
            }

        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>

</body>
</html>
