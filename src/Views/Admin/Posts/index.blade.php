<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Titulo</th>
        <th scope="col">Autor</th>
        <th scope="col">Estado</th>
        <th scope="col">Fecha</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody class="listadepost">
    @for($a = 0; $a < count($posts['data']); $a++)
        @if($posts['data'][$a]['estado'] == 'Borrador')
            <tr style="border-left: 3px solid #3498db;">
        @else
            <tr style="border-left: 3px solid #27ae60;">
                @endif
                <th scope="row">
                    <h6>{{$posts['data'][$a]['titulo']}}</h6>
                    <ul class="listacompleta">
                        <li>
                            <a href="{{route(Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT . '.admin.posts.show',['postID' => $posts['data'][$a]['id']])}}">ver</a>
                        </li>
                        <li><a href="#"
                               onclick="document.getElementById('deletePost-{{$posts['data'][$a]['id']}}').submit();">Eliminar</a>
                        </li>
                    </ul>
                    <form id="deletePost-{{$posts['data'][$a]['id']}}"
                          action="{{route(Codwelt\Blog\BlogServiceProvider::NAMESPACE_PROYECT.'.admin.posts.destroy',['postID' => $posts['data'][$a]['id']])}}"
                          method="POST" style="display: none;"><input type="hidden" name="_method"
                                                                      value="delete">{{ csrf_field() }}</form>
                </th>
                <td>{{$posts['data'][$a]['autor']['name']}}</td>
                <td>{{$posts['data'][$a]['estado']}}</td>
                <td>{{$posts['data'][$a]['fecha_publicacion']}}</td>
                <td></td>
            </tr>
            @endfor
    </tbody>
</table>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>