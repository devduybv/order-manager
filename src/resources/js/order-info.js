import $ from 'jquery';
import "jquery/dist/jquery.min";
import "jquery-validation/dist/jquery.validate.min";

$(document).ready(function() {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function() {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function() {
        return false;
    })

});

$(document).ready(function() {
    $("form").validate({
        rules: {
            last_name: {
                required: true
            },
            address: {
                required: true
            },
            phone_number: {
                required: true,
                number: true
            }
        },
        messages: {
            last_name: {
                required: "Vui lòng nhập tên của bạn"
            },
            address: {
                required: "Vui lòng nhập địa chỉ"
            },
            phone_number: {
                required: "Vui lòng nhập số điện thoại",
                number: "Số điện thoại chỉ cho phép nhập số"
            }
        }
    })

    // $("#btn-continue").click(function() {
    //     alert("Vui lòng nhập các thông tin bắt buộc");

    //     $("form").validate({
    //         rules: {
    //             last_name: {
    //                 required: true
    //             },
    //             address: {
    //                 required: true
    //             },
    //             phone_number: {
    //                 required: true,
    //                 number: true
    //             }
    //         },
    //         messages: {
    //             last_name: {
    //                 required: "Vui lòng nhập tên của bạn"
    //             },
    //             address: {
    //                 required: "Vui lòng nhập địa chỉ"
    //             },
    //             phone_number: {
    //                 required: "Vui lòng nhập số điện thoại",
    //                 number: "Số điện thoại chỉ cho phép nhập số"
    //             }
    //         }
    //     })
    //   });

    $('form input').on('keyup blur', function () { // fires on every keyup & blur
        if ($('form').valid()) {                   // checks form for validity
            $('#btn-continue').prop('disabled', false); // enables button

            var formData = {
                last_name: $("#last-name").val(),
                address: $("#address").val(),
                phone_number: $("#phone-number").val(),
                first_name: $("#first-name").val(),
                email: $("#email").val(),
            }

            console.log(formData);
        } else {
            $('#btn-continue').prop('disabled', 'disabled');   // disables button
        }
    });

    // ajax();
    // // Will accure at every click
    // $(document).click(function() { ajax(); });

    // console.log($("form").validate());

    // if ($("form").valid()) {
    //   console.log('dấdasdasd');
    //     $('#btn-continue').removeAttr("disabled");
    // }
});

// function reloadForm() {
//     $("#form_info").load(location.href + " #form_info");
//     $.ajax({
//         url: "./services/finn_bilder.php",
//         type:"POST",
//         data:{ads: ads},
//         success:function(data){
//             $('#AdsDiv').html(data);
//         });
// }

