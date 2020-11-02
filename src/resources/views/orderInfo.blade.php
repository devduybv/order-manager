<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/app.css" />
        <style>
            .success{border: solid 1px blue;}
            .error {border:solid 1px red;}
        </style>
        <script src="/js/app.js"></script>
        {{-- <script src="/node_modules/jquery/dist/jquery.js"></script> --}}
        {{-- <script src="/node_modules/jquery-validation/dist/jquery.validate.js"></script> --}}
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script> --}}
    </head>
    <body>
        <div class="container-fluid">
            {{-- @csrf --}}
            <div class="row">
                <div class="form-order col-md-9">
                    <div class="container">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('alert'))
                        <div class="alert alert-danger">
                            {!! session('alert') !!}
                        </div>
                        @endif
                        <ul id="progressbar">
                            <li class="active" id="account">01 THÔNG TIN KHÁCH HÀNG</li>
                            <li id="personal">02 THÔNG TIN THANH TOÁN</li>
                        </ul>
                        <form id="form_checkout" action="{{ route('order.payment') }}" method="POST" class="form-card">
                            @csrf
                                <fieldset id="fs-info">
                                    <h3>Thông tin khách hàng</h3>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-info">
                                            <p>Họ</p>
                                            <input id="first-name" type="text" name="first_name" value="{!! Auth::check() ? Auth::user()->first_name : '' !!}">
                                        </div>
                                        <div class="form-info">
                                            <p>Tên (<b class="text-danger">*</b>)</p>
                                        <input id="last-name" type="text" name="last_name" value="{{ (isset($last_name)) ? $last_name : "" }}">
                                        </div>
                                    </div>
                                    <div class="address">
                                        <p>Địa chỉ (<b class="text-danger">*</b>)</p>
                                        <input id="address" type="text" name="address" value="{!! Auth::check() ? Auth::user()->address : '' !!}">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-info">
                                            <p>Email</p>
                                            <input id="email" type="text" name="email" value="{!! Auth::check() ? Auth::user()->email : '' !!}">
                                        </div>
                                        <div class="form-info">
                                            <p>Số điện thoại (<b class="text-danger">*</b>)</p>
                                            <input id="phone-number" type="text" name="phone_number" value="{!! Auth::check() ? Auth::user()->phone_number : '' !!}">
                                        </div>
                                    </div>
                                    <div class="address">
                                        <p>Ghi chú</p>
                                        <textarea name="note" id="note" placeholder="Note...."></textarea>
                                    </div>
                                    <a href="/cart" class="btn-back"><b><i class="fa fa-arrow-left" aria-hidden="true"></i> Quay lại giỏ hàng</b></a>
                                    <input onclick="store()" id="btn-continue" type="submit" name="next" class="action-button" value="Tiếp tục" />
                                </fieldset>
                            </form>
                            
                            {{-- <fieldset>
                            <form id="form_checkout" action="{{ route('order.create') }}" method="POST">
                                <div class="form-card">
                                    <h3>Phương thức thanh toán</h3>
                                    <div class="row mt-4">
                                        <div class="checkbx col-12">
                                            <label class="cbx">
                                                <div>
                                                    <div class="cbx-width d-flex justify-content-between">
                                                        <div>Thanh toán khi nhận hàng</div>
                                                    </div>
                                                    <div><p>Thời gian nhận hàng từ 7 đến 14 ngày</p></div>
                                                </div>
                                                <input checked type="radio" value="1" name="payment_method">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="checkbx col-12">
                                            <label class="cbx">
                                                <div>
                                                    <div class="cbx-width d-flex justify-content-between">
                                                        <div>Thanh toán online (VNPay)</div>
                                                    </div>
                                                    <p>Thời gian nhận hàng từ 4 đến 7 ngày</p>
                                                </div>
                                                <input type="radio" value="2" name="payment_method">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <i class="fa fa-arrow-left icon-back" aria-hidden="true"></i><input type="button" name="previous" class="previous action-button-previous" value="Quay lại" />
                                <button type="button" class="action-button col-12 col-md-3" data-toggle="modal" data-target="#confirmModal">Thanh toán</button>
                            </fieldset> --}}
                            
                        </div>
                    </div>
                    <div class="col-12 col-md-3 background">
                        <div class="row ">
                            <div class="product-info">
                                <div class="product-head d-flex justify-content-between">
                                    <h4>Giỏ hàng</h4>
                                    <div class="value d-flex align-items-center">
                                        <div class="circle d-flex align-items-center justify-content-center">{!! $cartItemsCount !!}</div>
                                    </div>
                                </div>
                                @foreach ($carts->cartItems as $cartItem)
                                <div class="product-item row">
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="img "><img src="{!! $cartItem->product->thumbnail !!}" width="100%" alt=""></div>
                                    </div>
                                    <div class="col-12 col-md-12 col-lg-6">
                                        <div class="product-name">{!! $cartItem->product->name !!}</div>
                                        <div class="product-price">Đơn giá : {!! number_format($cartItem->price) !!} đ
                                        </div>
                                        <div class="product-price">Số lượng : {!! $cartItem->quantity !!}</div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="total-price">
                                    <div class="d-flex justify-content-between">
                                        <div>Tổng giá</div>
                                        <div>{!! number_format($carts->total) !!} đ</div>
                                        <input type="" name="total" value="{!! $carts->total !!}" hidden >
                                    </div>
                                </div>
                                <div>
                                    <input type="" name="cart_id" value="{{ Cookie::get('cart') }}" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="confirmModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content mt-5">
                            <div class="modal-body mb-5">
                                <h4 class="text-center mt-3">Xác nhận thanh toán hóa đơn ?</h4>
                                <div class="d-flex justify-content-center mt-5">
                                    <input type="submit" class="btn btn-primary col-12 col-md-3"  value="Thanh toán !" />
                                    <button type="button" class="btn btn-danger ml-5" data-dismiss="modal">Quay lại</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>

<script>
//  function store(){
//      var inputFirstName = document.getElementById("first-name");
//      var inputLastName = document.getElementById("last-name");
//      var inputAddress = document.getElementById("address");
//      var inputEmail= document.getElementById("email");
//      var inputPhoneNumber = document.getElementById("phone-number");
//      var inputNote = document.getElementById("note");
     
//      localStorage.setItem("first_name", inputFirstName.value);
//      localStorage.setItem("last_name", inputLastName.value);
//      localStorage.setItem("address", inputAddress.value);
//      localStorage.setItem("email", inputEmail.value);
//      localStorage.setItem("phone_number", inputPhoneNumber.value);
//      localStorage.setItem("note", inputNote.value);
//     }

// var first_name = $('#first-name').val();
// var last_name = $('#last-name').val();
// var address = $('#address').val();
// var email = $('#email').val();
// var phone_number = $('#phone-number').val();
// var note = $('#note').val();

// localStorage.setItem("first_name", first_name);
// localStorage.setItem("last_name", last_name);
// localStorage.setItem("address", address);
// localStorage.setItem("email", email);
// localStorage.setItem("phone_number", phone_number);
// localStorage.setItem("note", note);

// console.log(localStorage.getItem("email"));

</script>

</html>
