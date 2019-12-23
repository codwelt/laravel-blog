<div>
    <form action="{{route('codwelt_blog.admin.config.update')}}" method="post">
        <input type="hidden" name="_method" value="put">
        {{csrf_field()}}
        @foreach($configs as $config)
            <div class="form-group">
                <label>{{$config['name']}}</label>
                <input type="text" name="{{$config['name']}}" class="form-control" value="{{$config['value']}}">
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
