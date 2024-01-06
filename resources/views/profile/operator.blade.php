@extends('layout')
@section('content')
<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card profile-card-2">
            <div class="card-img-block">
                <img class="img-fluid" src="/assets/assets/images/placeholder-undip.jpg" alt="Card image cap">
            </div>
            <div class="card-body pt-5">
                <img src="/assets/assets/images/pp.png" alt="profile-image" class="profile">
                <h5 class="card-title">{{$user->operator->nama}}</h5>
                <div class="icon-block">
                    <a href="javascript:void();"><i class="fa fa-facebook bg-facebook text-white"></i></a>
                    <a href="javascript:void();"> <i class="fa fa-twitter bg-twitter text-white"></i></a>
                    <a href="javascript:void();"> <i class="fa fa-google-plus bg-google-plus text-white"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#profile" data-toggle="pill" class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profile</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#edit" data-toggle="pill" class="nav-link"><i class="icon-note"></i> <span class="hidden-xs">Edit</span></a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">User Profile</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Nama</h6>
                                <p>
                                    {{$user->operator->nama}}
                                </p>
                                <h6>NIP</h6>
                                <p>
                                    {{$user->NIP}}
                                </p>
                                <h6>Alamat</h6>
                                <p>
                                    {{$user->operator->alamat}}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Email Official</h6>
                                <p>
                                    {{$user->user}}
                                </p>
                                <h6>Nomor Handphone</h6>
                                <p>
                                    {{$user->operator->no_HP}}
                                </p>
                            </div>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="tab-pane" id="edit">
                        <form action="/dashboard/operator/{{$user->NIP}}/profile/edit" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nama Lengkap</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->operator->nama}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" value="{{$user->user}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">NIP</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->NIP}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nomor Handphone</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="{{$user->operator->no_HP}}" id="hp" name="hp">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="submit" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--start overlay-->
<div class="overlay toggle-menu"></div>
<!--end overlay-->
@endsection