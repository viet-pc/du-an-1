@extends('layouts.admin')
@section('main')
    <div class="row">
        <div class="col-xl-11 col-lg-11 col-md-11 col-sm-11 col-11">
            <div class="card">
                <div class="card-body">
                    <h4>Thiết lập phí vận chuyển</h4>
                    @if (session('update-shipfee-success'))
                        <div class="alert alert-success">
                            {{ session('update-shipfee-success') }}
                        </div>
                    @endif
                    <form action="{{route('update.config.shipfee')}}" method="post">
                        @csrf
                        <div class="card-body row">
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Nội thành(VNĐ/KM)</label>
                                <input
                                    type="text"
                                    class="form-control date-inputmask"
                                    placeholder="Nhập số tiền trên mỗi Ki-lô-mét"
                                    name="Inside"
                                    value="{{$inside->PricePerKm}}"
                                />
                            </div>
                            <div class="form-group col-6">
                                <label for="inputText4" class="col-form-label">Ngoại Thành(VNĐ/KM)</label>
                                <input
                                    type="text"
                                    class="form-control date-inputmask"
                                    placeholder="Nhập số tiền trên mỗi Ki-lô-mét"
                                    name="Outside"
                                    value="{{$outside->PricePerKm}}"
                                />
                            </div>
                        </div>
                        <button type="submit" name="" class="btn btn-outline-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop()
