@extends('layouts.app')

@section('title', $title )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">PHP语言, PHP扩展, Zend引擎相关的研究,技术,新闻分享 – 左手代码 右手诗</div>
                    <div class="panel-body">
                        <div class="article">
                            <h2>{{$title}}</h2>
                            <div class="tags">
                                @if(isset($data['tags']) && $data['tags'])
                                @foreach($data['tags'] as $tag)
                                <span class="label label-info">{{$tag}}</span>
                                @endforeach
                                @endif
                            </div>
                            <hr />

                            <div class="bs-callout bs-callout-warning text-normal">
                                <ul>
                                    <li>作者：<strong>Laruence</strong></li>
                                    <li>原文地址： <a target="_blank" href="{{$data['source']}}">{{$data['source']}}</a></li>
                                    <li>转载请注明出处。</li>
                                </ul>
                            </div>

                            <div class="content text-normal">
                                {!! $data['content'] !!}
                            </div>

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
