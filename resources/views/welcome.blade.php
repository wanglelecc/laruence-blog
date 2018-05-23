@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">首页</div>
                    <div class="panel-body">
                        <div class="article">
                            <h4>PHP的性能演进(从PHP5.0到PHP7.1的性能全评测)</h4>
                            <div class="content">
                                <p>
                                    PHP 是 Web 开发最常用的语言，每个大版本的更新都带来不少新特性和性能提升。特别是 PHP 7.0 的发布，带来 PHP 性能飞跃。本文作者对各个 PHP 版本进行了 CPU 性能基准测试，并且带来了PHP下个大版本的消息。本文中文版由高可用架构志愿者翻译。
                                </p>
                            </div>
                            <div class="tags">
                                <span class="label label-info">PHP7</span>
                                <span class="label label-info">PHP源码分析</span>
                            </div>
                        </div>

                        <hr />

                        <div class="article">
                            <h4>PHP的性能演进(从PHP5.0到PHP7.1的性能全评测)</h4>
                            <div class="content">
                                <p>
                                    PHP 是 Web 开发最常用的语言，每个大版本的更新都带来不少新特性和性能提升。特别是 PHP 7.0 的发布，带来 PHP 性能飞跃。本文作者对各个 PHP 版本进行了 CPU 性能基准测试，并且带来了PHP下个大版本的消息。本文中文版由高可用架构志愿者翻译。
                                </p>
                            </div>
                            <div class="tags">
                                <span class="label label-info">PHP7</span>
                                <span class="label label-info">PHP源码分析</span>
                            </div>
                        </div>

                        <hr />

                        <div class="article">
                            <h4>PHP的性能演进(从PHP5.0到PHP7.1的性能全评测)</h4>
                            <div class="content">
                                <p>
                                    PHP 是 Web 开发最常用的语言，每个大版本的更新都带来不少新特性和性能提升。特别是 PHP 7.0 的发布，带来 PHP 性能飞跃。本文作者对各个 PHP 版本进行了 CPU 性能基准测试，并且带来了PHP下个大版本的消息。本文中文版由高可用架构志愿者翻译。
                                </p>
                            </div>
                            <div class="tags">
                                <span class="label label-info">PHP7</span>
                                <span class="label label-info">PHP源码分析</span>
                            </div>
                        </div>

                        <hr />

                    </div>
                </div>

                <div class="text-center">
                    <nav aria-label="">
                        <ul class="pagination">
                            <li><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                            <li><a href="#">1</a></li>
                            <li class="active"><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>


            <div class="col-md-4">
                @include('layouts.sidebar')
            </div>

        </div>
    </div>
@endsection
