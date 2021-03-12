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

    //セレクトボックスが切り替わったら発動
    $('[name=id_img_result]').on('change', function () {
        $('#preview_result').attr('src', '');
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
                    $('#preview_result').attr('src', url);
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data) {
                console.log("失敗しました");
            });
    });


    //セレクトボックスが切り替わったら発動
    $('[name=id_img_disp]').on('change', function () {
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


    $("#add").on('click', function (e) {
        console.log($('[id=prize_data] > tbody > tr').length);
        var length = $('[id=prize_data] > tbody > tr').length;
        var tr_row = '' +
            '<tr>' +
            '<td class="">' +
            '<select id="id_' + length + '" name="prize_id[]" class="optionSelect"></select>' +
            '<td class=""><input type="text" id="prize_name[]" name="prize_name" class="form-control" readonly></td>' +
            '<td class=""><input type="number" class="form-control" id="frequency[]" name="frequency"></td>' +
            '<td class=""><input type="number" class="form-control" id="occurrence_rate[]" name="occurrence_rate"></td>' +
            '</tr>';// 挿入する行のテンプレート
        var row_cnt = $("[id=prize_data] tbody").children().length;// 現在のDOMで表示されているtrの数
        $(tr_row).appendTo($('[id=prize_data] > tbody'));// tbody末尾にテンプレートを挿入
        $('#id_0').find('option').clone().appendTo('#id_' + length);
        $('[id=prize_data] > tbody > tr:last > td > input').each(function () {
            var base_name = $(this).attr('name');
            $(this).attr('name', base_name + '[' + row_cnt + ']');
        });// input name部分を変更
    });

    $(document).on('change', '.optionSelect', function () {
        var select_str = $(this).attr("id");
        var str_start = select_str.indexOf("_");
        var num = select_str.substring(str_start + 1)
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/prize/get",
            type: 'POST',
            dataType: "json",
            data: { 'id': $(this).val() }
        })
            // Ajaxリクエストが成功した場合
            .done(function (data) {
                var name = data.name;
                console.log(data);
                if (data.name == '') {
                    console.log("失敗しました");
                } else {
                    console.log("成功しました");
                    console.log(name);
                    console.log(num);
                    $('#prize_name[' + num + ']').attr("value", name);
                }
            })
            // Ajaxリクエストが失敗した場合
            .fail(function (data) {
                console.log("失敗しました");
            });
    });
};
