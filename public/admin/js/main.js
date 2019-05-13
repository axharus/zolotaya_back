$(function () {
    $(".deleteButton").click(function () {
        return confirm('Вы уверенны? Это действие нельзя отменить!');
    });
    submitForm();
    ListTable();
    hotPrice();
});

function hotPrice(){
    $('.hotPrice').dblclick(function () {
        var $this = $(this);
        var price = $this.text();
        var id = $this.data('id');
        $this.html('<input type="number" value="'+price+'">');
        $this.find('input').focus();
        $this.find('input').keypress(function (e) {
            if(e.which == 13){
                var price = $this.find('input').val();
                $.post('/superuser/product/hotPrice/'+id, {price: price});
                $this.find('input').remove();
                $this.text(price);
            }

        })
    })
}

function imageRequi() {
    var retValue = true;
    $('.imageRqui').each(function () {
        var $this = $(this);
        var val = $this.find('input[type=hidden]').val();
        if (!val || val == "[]") {
            $this.find('label').css('color', 'red');
            $('html, body').animate({
                scrollTop: $this.offset().top - 100
            }, 2000);
            retValue = false;
        }
    });
    return retValue;
}

function ListTable() {
    if ($('.table-responsive table').length > 0 && $('.payListTable').length == 0) {
        $('.table-responsive table').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json"
            }
        });
    } else if ($('.payListTable').length > 0) {
        $('.payListTable').DataTable({
            "order": [],
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdf', 'print'],
        });
    }
}


function summenrInstall(name) {
    var el = $("textarea[name='" + name + "']").parents('.summenrInstall').find('>div.summer_' + name + '');
    el.summernote({
        height: 300,
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files[0], el);
            },
            onMediaDelete: function ($target, editor, $editable) {
                var key = $target[0].src.substr($target[0].src.lastIndexOf('/') + 1);
                $.ajax({
                    data: {key: key},
                    type: "POST",
                    url: "/superadmin/ulpoad/delete",
                    success: function (data) {
                        console.log(data);
                    }
                });

                // remove element in editor
                $target.remove();
            }
        }

    });
    el.summernote('code', $("textarea[name='" + name + "']").val());
    el.parents("form").submit(function () {
        $("textarea[name='" + name + "']").val(el.summernote('code').replace(/&quot;/g, "'"));
    })
}

function sendFile(file, editor) {
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: "/superuser/ulpoad/image/0/0",
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            editor.summernote('insertNode', $('<img>').attr('src', (JSON.parse(url)).initialPreview)[0]);
        }
    });
}

function submitForm() {
    $("form").submit(function () {
        if(!imageRequi()) return false;

        var rep = $(this).find(".repeater");
        var chosen = $(this).find(".chosen");
        if (chosen.length > 0) {
            chosen.each(function () {
                var obj = $(this).find("*").serializeArray();
                var str = "";
                var name = $(this).find("select").attr("name");
                for (var o in obj) {
                    str += obj[o].value + ","
                }
                $(this).empty();
                $(this).append("<input name='" + name + "' type='hidden' value='" + str + "'>");
            })
        }
        if (rep.length > 0) {
            rep.each(function () {
                var items = [];
                $(this).find(".template").empty();
                $(this).find(".item").each(function () {
                    var array = $(this).find(":input").serializeArray();
                    if ($(this).find(".summenrInstall").length > 0) {
                        array.push({
                            name: $(this).find(".summenrInstall > textarea").attr("name"),
                            value: $(this).find(".summenrInstall > div").summernote('code').replace(/\&quot\;/g, "'"),
                        })
                    }
                    var obj = {};
                    for (var a in array) {
                        obj[array[a]["name"].split("[")[0]] = array[a]["value"];
                    }
                    items.push(obj);
                });
                var data = JSON.stringify(items);
                $(this).empty();
                $(this).append("<textarea name='" + $(this).data("name") + "'>" + data + "</textarea>")
            })
        }
    })
}

function fileInput(name, width, height, max, data) {
    var inp = $("input[name='inP" + name + "']"),
        inpOrigin = $("input[name='" + name + "']");
    var options = {
        language: 'ru',
        uploadUrl: "/superuser/ulpoad/image/" + width + "/" + height + "", // server upload action
        uploadAsync: true,
        maxFileCount: max,
        validateInitialCount: true,
        initialPreviewShowDelete: true,
        initialPreviewFileType: 'image',
        initialPreview: [],
        initialPreviewAsData: true,
        initialPreviewConfig: [],
        allowedFileExtensions: ['jpg', 'png']

    };
    if (data) {
        try {
            var jso = JSON.parse(data);


            for (var a in jso) {
                options.initialPreview.push("/image/" + jso[a]);
                options.initialPreviewConfig.push({width: "120px", url: "/superuser/ulpoad/delete", key: jso[a]})
            }

        } catch (e) {
            options.initialPreview = [
                "/image/" + data
            ];
            options.initialPreviewAsData = true;
            options.initialPreviewFileType = 'image';
            options.initialPreviewConfig = [
                {width: "120px", url: "/superuser/ulpoad/delete", key: data}
            ];
            options.initialPreviewAsData = true;
        }

    }


    inp.fileinput(options)

    inp.on("filebatchselected", function (event, files) {
        inp.fileinput("upload");
    });

    inp.on('fileuploaded', function (event, data, previewId, index) {
        key = data.response.initialPreviewConfig[0].key;
        var js;
        js = inpOrigin.val()
        if (js && js != 'null' && js !== true) {
            js = JSON.parse(js);
            js.push(key);
            inpOrigin.val(JSON.stringify(js));
        } else {
            inpOrigin.val(JSON.stringify([key]));
        }

    });

    inp.on('filedeleted', function (event, key) {
        if (js = inpOrigin.val()) {
            if (IsJsonString(js)) {
                js = JSON.parse(js);
                js.splice(js.indexOf(key), 1);
                inpOrigin.val(JSON.stringify(js));
            } else {
                inpOrigin.val(JSON.stringify([]));
            }

        }
    });
}

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function repeater(id) {
    var r = {};
    var template = $(id).find(".template").html();
    $(id).find(".template").empty()
    $(id).each(function () {
        var i = $(this).find(".body").data("i");
        if (i && i.length > 0) {
            for (var a in i) {
                addOne($(this), i[a], template)
            }
        }

        if ($(this).data("class")) {
            $(this).find(".body").addClass("row");
        }
    })


    $(id).find(".add").click(function () {
        addOne($(this).parent(), false, template)
    });

    function addOne(its, data, template) {
        var n = its.data("name");
        if (!r[n]) {
            r[n] = its.find(".body > div").length;
        }
        r[n]++;
        its.find(".body").append("<div class='item " + its.data("class") + " item" + r[n] + "'>" + template + "</div>");
        var imps = its.find(".body .item" + r[n] + " *[name]");
        imps.each(function () {
            if (data) {
                if ($(this).attr("type") == 'checkbox') {
                    $(this).prop('checked', data[$(this).attr("name")] == 'on')
                } else {
                    $(this).val(data[$(this).attr("name")]);
                }
            }

            if ($(this).hasClass('datetimepicker')) {
                $(this).datetimepicker({
                    locale: 'ru',
                    format: $(this).data('format')
                });
                if (data && data[$(this).attr("name")] && $(this).hasClass('withtimestamp')) {
                    var time = data[$(this).attr("name")];
                    time = moment(parseInt(time) * 1000).format($(this).data('format'));
                    $(this).val(time);
                }
            }

            var attr = $(this).attr("name") + "[" + r[n] + "]";
            $(this).attr("name", attr);

            if ($(this).parents('.summenrInstall').length > 0) {
                summenrInstall(attr);
            }
        });


        imps.each(function () {
            if ($(this).hasClass("fileInput")) {
                fileInput(
                    $(this).data("name") + "[" + r[n] + "]",
                    $(this).data("width"),
                    $(this).data("height"),
                    $(this).data("max"),
                    (data && data[$(this).data("name")] ? (data[$(this).data("name")] == '[false]' ? '' : data[$(this).data("name")]) : "")
                )
            }
        });
        if (!data)
            its.find(".body .item" + r[n] + " input[name^=num]").val(r[n]);
        deleteBind(its.find(".body .item" + r[n] + " .delete"));
    }


    function deleteBind(selector) {
        selector.click(function () {
            $(this).parents(".item").remove();
        })
    }


}