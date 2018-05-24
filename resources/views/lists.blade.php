@extends('layouts.app')

@section('title', $title )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$title}}</div>
                    <div class="panel-body">
                        @if($data['items'])
                            @foreach($data['items'] as $item)
                        <div class="article">
                            <h4><a href="{{ route('show',$item['url']) }}?nav={{$uri}}">{!! $item['title'] !!}</a></h4>
                            <div class="content">
                                {!! $item['description'] !!}
                            </div>
                            <div class="tags">
                                @foreach($item['tags'] as $tag)
                                <span class="label label-info">{{$tag}}</span>
                                @endforeach
                            </div>
                        </div>
                        <hr />
                            @endforeach
                        @endif

                        <div class="text-center">
                            {{$paginator->links()}}
                        </div>

                    </div>
                </div>


            </div>


            <div class="col-md-4">
                @include('layouts.sidebar')
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#nav-{{$data['nav_id']}}").addClass('active');
    </script>
@endsection