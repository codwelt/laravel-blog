<div class="container-fluid">
    <form method="post" id="formUpdate" class="formulariodeposts" action="{{route('codwelt_blog.admin.posts.store')}}"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-10">
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
                        <textarea id="ckeditor" class="ckeditor" style="display: none;" name="contenido"
                                  required>{{old('contenido')}}</textarea>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-light mb-3">
                    <input type="button" id="publicar" value="Publicar" class="btn btn-success block inpubli">
                    <div class="card-body">
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