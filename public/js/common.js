window.onload = function () {
    $('#myImage').on('change', function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#preview").attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    $('#image').on('change', function (e) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#preview").attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files[0]);
    });

    //セレクトボックスが切り替わったら発動
    $('[name=picture_id]').on('change', function () {
        $('#preview').attr('src', '');
        var url = '';
        var id = $(this).val();
        console.log(id);
        if (id == 0) {
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/picture/get",
            type: 'POST',
            dataType: "json",
            data: { 'id': id }
        })
            // Ajaxリクエストが成功した場合
            .done(function (data) {
                var url = data.url;
                if (data.url == '') {
                    console.log("失敗しました");
                } else {
                    console.log("成功しました");
                    $('#preview').attr('src', url);
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data) {
                console.log("失敗しました");
            });
    });

};
