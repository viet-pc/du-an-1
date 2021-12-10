@extends('layouts.site')
@section('main')
    @if(count($data)>1)
        <div class="blog-area pt-100 pb-100">
            <div class="container">
                @if(isset($categoryData))
                    {{Breadcrumbs::render('blogCategory',$categoryData->BlogName, $categoryData->slug)}}
                @else
                    {{Breadcrumbs::render('blog')}}
                @endif
                <div class="row">
                    @foreach($data as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-wrap mb-50" data-aos="fade-up" data-aos-delay="200">
                            <div class="blog-img-date-wrap mb-25">
                                <div class="blog-img">
                                    <a href="{{url('blog')}}/{{$item->categorySlug}}/{{$item->blogSlug}}"><img src="{{asset('/images/blog')}}/{{$item->thumbnail}}" alt=""></a>
                                </div>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <ul>
                                        <li>Tác giả:<a href="#"> {{$item->Fullname}}</a></li>
                                    </ul>
                                </div>
                                <h3><a href="{{url('blog')}}/{{$item->categorySlug}}/{{$item->blogSlug}}">{{$item->Title}}</a></h3>
                                <p>{{Str::limit($item->Blog_des),'150','(...)'}}</p>
                                <div class="blog-btn-2 btn-hover">
                                    <a class="btn hover-border-radius theme-color" href="{{url('blog')}}/{{$item->categorySlug}}/{{$item->blogSlug}}">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <center>
                {!! $data->links() !!}
                </center>
            </div>
        </div>
    @else
    <center>Oops! Chưa có bài viết nào ở đây cả</center>
    @endif
@stop()
