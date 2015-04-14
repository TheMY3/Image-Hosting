$(function () {
    $(document).on('click', '.ajaxRequest', function (ev) {
        ev.preventDefault();
        var url = $(this).attr('href');
        bootbox.confirm("Вы хотите выполнить данное действие?", function (result) {
            if (result == true) {
                $.post(url, function (data) {
                    if (data.updateList) {
                        $.fn.yiiListView.update(data.updateList);
                    }
                    if (data.notify) {
                        $.notify(data.notify, "info");
                    }
                    else {
                        $.notify("Действие выполнено успешно!", "info");
                    }

                }, 'json');
            } else {
                $.notify("Действие отменено!", "error");
            }
        });
    });

    $(document).on('click', '.modalWindow', function (ev) {
        ev.preventDefault();
        var url = $(this).attr('href');
        var modal = $(document).find('.modal');
        $.post(url, function (data) {
            modal.html(data).modal('show');
        });
    });
});