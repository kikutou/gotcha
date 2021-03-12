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
        var length = $('[id=prize_data] > tbody > tr').length;
        var tr_row = '' +
            '<tr>' +
            '<td class="">' +
            '<select id="id_' + length + '" name="prize_id[]" class="optionSelect"></select>' +
            '<td class=""><input type="text" class="form-control" id="prize_name" name="prize_name"  readonly></td>' +
            '<td class=""><input type="number" class="frequency form-control" id="frequency" name="frequency" class="frequency" readonly></td>' +
            '<td class=""><input type="number" class="form-control" id="occurrence_rate" name="occurrence_rate" readonly></td>' +
            '</tr>';// 挿入する行のテンプレート
        var row_cnt = $("[id=prize_data] tbody").children().length;// 現在のDOMで表示されているtrの数
        $(tr_row).appendTo($('[id=prize_data] > tbody'));// tbody末尾にテンプレートを挿入
        $('#id_0').find('option').clone().appendTo('#id_' + length);
        $('[id=prize_data] > tbody > tr:last > td > input').each(function () {
            var base_name = $(this).attr('name');
            $(this).attr('name', base_name + '[' + row_cnt + ']');
        });// input name部分を変更
    });

    function occurrence_rate_sum() {
        var frequency_sum = 0;
        var occurrence_rate = 0;
        $('.frequency').each(function (index, value) {
            $('input[name="occurrence_rate[' + index + ']"]').attr("value", "");

            var prize_id = $("#id_" + index).find("option:selected").val();
            var frequency = parseInt($('input[name="frequency[' + index + ']"').val());
            // $('input[name="frequency[' + index + ']"').val(frequency)
            if (prize_id != "" && frequency > 0) {
                frequency_sum = parseInt(frequency_sum) + parseInt(frequency);
            }
        });
        $('.frequency').each(function (index) {
            var prize_id = $("#id_" + index).find("option:selected").val();
            var frequency = parseInt($('input[name="frequency[' + index + ']"').val());
            if (prize_id != "" && frequency > 0) {
                occurrence_rate = frequency / frequency_sum;
                console.log(frequency);
                console.log(frequency_sum);
                console.log(occurrence_rate);
                $('input[name="occurrence_rate[' + index + ']"]').attr("value", (occurrence_rate * 100).toFixed(1));
            }

        });
    }

    $(document).on('change', '.frequency', function () {

        occurrence_rate_sum();
    });


    $(document).on('change', '.optionSelect', function () {
        var select_str = $(this).attr("id");
        var str_start = select_str.indexOf("_");
        var num = select_str.substring(str_start + 1)
        if ($(this).val() != "") {
            $('input[name="frequency[' + num + ']"').removeAttr("readonly");
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
                    if (data.name == '') {
                        console.log("失敗しました");
                    } else {
                        console.log("成功しました");
                        $('input[name="prize_name[' + num + ']"]').attr("value", name);
                    }
                })
                // Ajaxリクエストが失敗した場合
                .fail(function (data) {
                    console.log("失敗しました");
                });
        } else {
            $('input[name="frequency[' + num + ']"').attr('readonly', 'readonly');
            $('input[name="frequency[' + num + ']"').val("");
            occurrence_rate_sum();
        }
    });
};
