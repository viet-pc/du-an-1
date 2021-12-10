@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h3 class="card-header">Sửa tên danh mục bài viết</h3>
                <div class="card-body">
                    <form id="pulseForm">
                        <div class="form-group">
                          <label for="exampleFormControlInput1">Tên hiện tại</label>
                          <input type="text" class="form-control" disabled value="{{$data->BlogName}}" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Tên mới</label>
                            <input type="text" class="form-control" id="title" placeholder="Nhập tên danh mục mới">
                            <span>Việc thay đổi tên danh mục cũng sẽ thay đổi <strong>Slug</strong> hiện tại.</span>
                        </div>
                        <div class="form-group p-4">
                            <button id="post" type="button" class="btn btn-primary waves-effect waves-light">Cập nhật</button>
                        </div>
                      </form>
                </div>
            </div>
        </div>
    </div>
@stop()
@section('scripts')
<script>
    $(document).ready(function() {
        $('#post').click(function(e) {
            Notiflix.Block.Pulse('#pulseForm');
            e.preventDefault();
            id = {{$data->Blog_CategoryID}};
            $.ajax({
                url: '{{url("api/post/category")}}/'+id+'/edit',
                type: 'POST',
                data: {
                    title: $('#title').val(),
                    _token: "{{csrf_token()}}"
                }
            }).done(function(res) {
                Notiflix.Block.Remove('#pulseForm');
                if(res.success == true){
                    Notiflix.Notify.Success(res.messages);
                    setTimeout(function () {
                        location.href = "{{url('admin/blog/category')}}";
                    }, 2000);
                }else{
                    Notiflix.Notify.Warning(res.messages);
                }
            });
        });
    })

</script>

@stop()
