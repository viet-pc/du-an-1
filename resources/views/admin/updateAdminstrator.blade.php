@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
            <div class="card">
                <div class="card-body">
                <h4>Nhập thông tin người quản trị</h4>
                <form action="{{route('admin.Administrator.update')}}" method="post">
                    @csrf
                    <div class="card-body row">
                        <div class="form-group col-6">
                            <label>Họ và Tên</label>
                            <input
                                type="text"
                                class="form-control date-inputmask"
                                id="date-mask"
                                placeholder="Nhập họ và tên"
                                name="Fullname"
                                value="{{$user->Fullname ??old('Fullname')}}"
                            />
                            <span class="text-danger">@error('Fullname') {{$message}}@enderror</span>
                        </div>
                        <div class="form-group col-6">
                            <label>Email</label>
                            <input

                                name="email"
                                class="form-control disabled"
                                placeholder="Nhập email"
                                value="{{ $user->Email ?? old('email')}}"
                            />
                            <span class="text-danger">@error('email') {{$message}}@enderror</span>
                        </div>
                    </div>
                    <div class="card-body row">
                    <div class="form-group col-6">
                            <label for="inputText4" class="col-form-label">Chọn nghiệp vụ cho user</label>
                            <select class="form-control" name="role" aria-label="Default select example">
                                <option value="" selected disabled hidden>Chọn 1 nghiệp vụ</option>
                                @if(Session('UserRole') == 'Manager' || Session('UserRole') == 'SuperAdmin')
                                    <optgroup label="Quản lý">
                                        @foreach($listRole as $role)
                                            @if($role->RoleName == 'Manager' || $role->RoleName == 'SuperAdmin')
                                                <option
                                                    {{old('role')}} {{ old('role') === $role->id_role ||$user->UserRole=== $role->id_role? 'selected="selected"':''}} value="{{$role->id_role}}">{{$role->RoleName}}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @endif
                                <optgroup label="Nhân viên">
                                    @foreach($listRole as $role)
                                        @if($role->RoleName != 'Manager' && $role->RoleName != 'SuperAdmin')
                                            <option
                                                {{old('role')}} {{ old('role') === $role->id_role ||$user->UserRole=== $role->id_role ? 'selected="selected"':''}} value="{{$role->id_role}}">{{$role->RoleName}}</option>
                                        @endif
                                    @endforeach
                                </optgroup>

                        </select>
                        <span class="text-danger">@error('role') {{$message}}@enderror</span>
                    </div>
                    <div class="form-group col-6">
                        <label>Chon trạng thái </label>
                        <label class="custom-control">
                            <input
                                checked
                                type="radio"
                                class="custom-control-input"
                                name="status"
                                value="0"
                            /><span class="custom-control-label">Chưa kích hoạt</span>
                        </label>
                        <label class="custom-control ">
                            <input
                                type="radio"
                                class="custom-control-input"
                                name="status"
                                value="1"
                                {{$user->Active === 1 ? 'checked':''}}
                            /><span class="custom-control-label">Đã kích hoạt</span>
                        </label>
                    </div>

                </div>
                    <button class="btn btn-outline-primary">Cập nhật</button>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop()
