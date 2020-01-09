<div class="container-fluid postdetallep">
    <div class="row">
        <div class="col-md-9">

            @foreach($resourceData['data'] as $post)

                <div class="row">
                            <a href="{{$post['url']}}" class="postcard">
                                <div class="col-md-6 scrollflow -slide-top -opacity">
                                    <div style="background-image: url({{$post['files']['imgThumbnail']}}); background-size: cover; background-position: center; width: 100%; height:40vh;">
                                        <div style="background-color: rgba(0,0,0, .8); width: 100%; height: 40vh; padding: 2%;">
                                            <div style=" width: 100%; height: 40vh; display: flex; justify-content: center; align-items: center; vertical-align: center;">
                                                <div style="width: 90%;">
                                                    <h3 style="border-left: 1px solid #fff;">{{$post['titulo']}}</h3>
                                                    <p>{{$post['resumen']}}</p>
                                                    <hr>
                                                    <ul class="redessocialespost" style="padding-top: 1%;">
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$post['url']}}"
                                                           target="_blank" style="color: #fff; font-size: 90%;">
                                                            <li><i style="color: #fff;"
                                                                   class="fab fa-facebook-f"></i></li>
                                                        </a>
                                                        <a href="https://twitter.com/home?status={{$post['url']}}"
                                                           target="_blank" style="color: #fff; font-size: 90%;">
                                                            <li><i style="color: #fff;" class="fab fa-twitter"></i>
                                                            </li>
                                                        </a>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                </div>
            @endforeach
        </div>
    </div>
</div>