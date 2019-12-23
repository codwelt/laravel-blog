<form id="formUpdate" method="post" class="formulariodeposts"
      action="{{route(\Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.admin.posts.update',['postID' => $post['id']])}}" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put">
    <div class="row">
        <div class="col-md-9">
            <div class="col-md-12 form-group">
                <h2>Titulo</h2>

                <input type="text" value="{{old('titulo')}}" name="titulo" id="titleToSlug" required  class="form-control"/>
                <script src="https://cdn.jsdelivr.net/npm/slugify@1.3.6/slugify.min.js"></script>
                <script type="text/javascript">
                    $(function () {
                        $('#inputSlug').slugIt({
                            output: '#inputSlug'
                        });
                    });
                </script>
            </div>
            <div class="col-md-12 form-group">
                    <textarea id="ckeditor" class="ckeditor" name="contenido" required
                              style="display: none">{{ !empty(old('contenido')) ? old('contenido') : $post['contenido']}}</textarea>
            </div>
            <div class="col-md-12 form-group">
                <h2>Resumen</h2>
                <textarea class="form-control" name="resumen"
                          required>{{ !empty(old('resumen')) ? old('resumen') : $post['resumen']}}</textarea>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light mb-12">
                <div class="card-body"><input type="button" id="publicar" value="Publicar"
                                              class="btn btn-success block inpubli">
                    <div class="card-header"></div>
                    <label for="imagen" class="btn btn-link"><i class="fas fa-upload"></i> Subir imagen</label>
                    <input type="file" name="imagen" onchange="readURL(this);" id="imagen" class="imagensubir" required>
                    <img id="preview-mini" class="img-thumbnail" src="http://placehold.it/180" alt="Preview"/>
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
                    </script>
                    <i>Especificaciones maximas dimenciones min_width=100, min_height=200, max_width=4096,
                        max_height=2304</i>

                </div>
            </div>
            <div class="card bg-light mb-12">
                <div class="card-header">Fuente</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <button type="button" id="addfuente" class="btn btn-link inpubli">Agregar fuente</button>
                    </div>
                    <div id="cuerpofuente">

                    </div>
                </div>
            </div>
            <div class="card bg-light mb-12">
                <div class="card-header">Hashtags</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <button type="button" id="addcategorias" class="btn btn-link inpubli">Agregar hastags
                        </button>
                    </div>
                    <div id="cuerpohashtags">
                        @for($a = 0; $a < count($post['hashtags']); $a++)
                            <span class="badge badge-primary">{{$post['hashtags'][$a]['nombre']}}</span>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="card bg-light mb-12">
                <div class="card-header">SEO</div>
                <div class="card-body">
                    <h6>KeyWords</h6>
                    <input type="text" name="meta_keywords" class="form-control"
                           value="{{$post['meta_keywords']}}"/>
                    <h6>Slug</h6>
                    <input type="text" name="slug" id="inputSlug" class="form-control" value="{{$post['slug']}}"/>
                </div>
            </div>
        </div>
    </div>
    @csrf
</form>
<script type="text/javascript">
    $("#publicar").on('click', function ($event) {

        var $form = $("#formUpdate");
        var confirmacion = confirm("Esta seguro que quiere publicar?");

        if (confirmacion) {
            $form.append('<input type="hidden" value="Publicado" name="state"/>');
            $form.submit();

        }

    });
</script>