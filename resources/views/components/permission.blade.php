@if($get_permission == 'Edit')
    <a href="{{$href}}" class="btn btn-outline-info"><i class="fab fa-edit"></i></a>
@elseif($get_permission == 'Delete')
    <a href="{{$href}}" class="btn btn-outline-danger"
       onclick="return confirm('Bạn có chắc muốn xóa không \n xóa sẻ hoàng tác đươc?')">
        <i class="fab fa-trash"></i>
    </a>
@elseif($get_permission == 'Create')
    <a href="{{$href}}" class="btn btn-outline-success"><i class="fab fa-external-link-alt"></i></a>
@endif
