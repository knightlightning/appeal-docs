$(document).ready(function () {
    $.getScript('js/jquery.cookie.js', function () {
        var index = $.cookie("court");
        if (index !== undefined) {
            $("#court")[0].selectedIndex = index;
            printCourtHistory();
        }
    });
});
function printCourtHistory() {
    var fd = new FormData();
    fd.append("court", $("#court").val());
    fd.append("mode", $("input[name=mode]:checked", "#uploadForm").val());
    fd.append("docType", $("input[name=docType]:checked", "#uploadForm").val());
    $.ajax({
        url: 'php/get_court_history.php',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            $("#output").val(data);
        }
    });
}
function enableUpload() {
    var court = $("#court").prop("selectedIndex");
    var fileCount = $("#docs")[0].files.length;
    $("#upload").prop("disabled", fileCount === 0 || court === 0);
}
$(function () {
    $("#court").change(function () {
        $.cookie("court", $("#court")[0].selectedIndex, {expires: 90, path: "/"});
        printCourtHistory();
        enableUpload();
    });
});
$(function () {
    $("[name=docType],[name=mode]").change(function () {
        printCourtHistory();
    });
});
$(function () {
    $("#docs").change(function () {
        var uploadBtn = $("#upload")[0];
        const MAX_FILE_SIZE = 50 * 1024 * 1024;
        const MAX_POST_SIZE = 50 * 1024 * 1024;
        const MAX_FILES = 20;
        var totalSize = 0;
        for (i = 0; i < this.files.length; i++) {
            var f = this.files[i];
            if (f.size > MAX_FILE_SIZE) {
                alert("Файл \"" + f.name + "\" превышает установленный лимит (50 МБ).");
                uploadBtn.disabled = true;
                this.value = "";
                return;
            }
            totalSize += f.size;
        }
        if (totalSize > MAX_POST_SIZE) {
            alert("Превышен установленный лимит загрузки (50 МБ).");
            uploadBtn.disabled = true;
            this.value = "";
            return;
        }
        if (this.files.length > MAX_FILES) {
            alert("Максимально допустимое количество файлов для загрузки - 20 штук.");
            uploadBtn.disabled = true;
            this.value = "";
            return;
        }
        enableUpload();
    });
});
$(function () {
    $("#uploadForm").submit(function (event) {
        var form = $("#formFields")[0];
        form.disabled = "disabled";
        event.preventDefault();
        var fd = new FormData();
        fd.append("court", $("#court").val());
        fd.append("mode", $("input[name=mode]:checked", "#uploadForm").val());
        fd.append("docType", $("input[name=docType]:checked", "#uploadForm").val());
        $.each($("#docs")[0].files, function (i, f) {
            fd.append("docs[]", f);
        });
        $.ajax({
            url: 'php/upload.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                if (!data) {
                    alert("Файл(ы) был(и) успешно загружен(ы).");
                } else {
                    alert("Некоторые файлы не были загружены:\n" + data);
                }
                $("#docs")[0].value = "";
                enableUpload();
                printCourtHistory();
                form.disabled = "";
            },
            error: function (data) {
                alert("Во время загрузки файлов произошла ошибка.");
                printCourtHistory();
                enableUpload();
            }
        });
    });
});
