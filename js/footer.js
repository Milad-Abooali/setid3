$('body').on('click', '.gp-add', function() {
    $("#content").html("<form>نام کاربری:<br><input type=\"text\" id=\"fa-user\" placeholder=\"username\"><br>رمز عبور:<br><input type=\"password\" id=\"fa-pass\" placeholder=\"password\"><br>تکرار رمز عبور:<br><input type=\"password\" id=\"fa-repass\" placeholder=\"retype password\"><br><span class=\"b-add button\">ایجاد حساب کاربری</span></form>")
});
$('body').on('click', '.b-add', function() {
    var fuser = $("#fa-user").val();
    var fpass = $("#fa-pass").val();
    var frepass = $("#fa-repass").val();
    if (fuser.length < 1) {
        $.notify('ورود نام کاربری الزامی است !', "warn")
    } else if (fpass.length < 1) {
        $.notify('ورود رمز عبور الزامی است !', "warn")
    } else {
        if (fpass === frepass) {
            var dataval = 'u=' + fuser + '&p=' + fpass;
            $.post("ajax.php?act=add", dataval, function(data, status) {
                if (status === "success") {
                    var myObj = JSON.parse(data);
                    if (myObj.IO) {
                        $.notify("حساب کاربری " + fuser + "ایجاد شد.", "success")
                    } else {
                        $.notify(myObj.ERR.login, "warn")
                    }
                } else if (status === "error") {
                    $.notify("خطا در عملیات", "error")
                } else {
                    $.notify("Server Alert! Please contact admin", "warn")
                }
            })
        } else {
            $.notify('تکرار رمز عبور نادرست است !', "warn")
        }
    }
});
$('body').on('click', '.gp-update', function() {
    $("#content").html("<form>رمز عبور جدید:<br><input type=\"password\" id=\"fu-pass\" placeholder=\"password\"><br>تکرار رمز عبور:<br><input type=\"password\" id=\"fu-repass\" placeholder=\"retype password\"><br><span class=\"b-update button\">تغییر رمز عبور</span></form>")
});
$('body').on('click', '.b-update', function() {
    var fpass = $("#fu-pass").val();
    var frepass = $("#fu-repass").val();
    if (fpass === frepass) {
        var dataval = 'p=' + fpass;
        $.post("ajax.php?act=update", dataval, function(data, status) {
            if (status === "success") {
                var myObj = JSON.parse(data);
                if (myObj.IO) {
                    $.notify("رمز عبور شما به روز شد.", "success")
                } else {
                    $.notify(myObj.ERR.login, "warn")
                }
            } else if (status === "error") {
                $.notify("خطا در عملیات", "error")
            } else {
                $.notify("Server Alert! Please contact admin", "warn")
            }
        })
    } else {
        $.notify('تکرار رمز عبور نادرست است !', "warn")
    }
});
$('body').on('click', '.b-logout', function() {
    $.get("ajax.php?act=logout", function(data, status) {
        if (status === "success") {
            $.notify("خروج با موفقیت انجام شد.", "info");
            $("#page").load(location.href + " #container")
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    })
});
$('body').on('click', '.b-login', function() {
    var fuser = $("#f-user").val();
    var fpass = $("#f-pass").val();
    var dataval = 'u=' + fuser + '& p=' + fpass;
    $.post("ajax.php?act=login", dataval, function(data, status) {
        if (status === "success") {
            var myObj = JSON.parse(data);
            if (myObj.IO) {
                $.notify("شما با موفقیت وارد حساب کاربری خود شدید.", "success");
                $("#page").load(location.href + " #container")
            } else {
                $.notify(myObj.ERR.login, "warn")
            }
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    })
});
$('body').on('click', '.b-cleartmp', function() {
    var dataval = '';
    $.post("ajax.php?act=cleartmp", dataval, function(data, status) {
        if (status === "success") {
            var myObj = JSON.parse(data);
            if (myObj.IO) {
                $.notify("تعداد " + myObj.COUNT + " فایل حذف شد.", "success");
                $("#cctmp").html('0');
                $(".buttonct").fadeOut()
            } else {
                $.notify("خطا در عملیات", "error")
            }
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    })
});
$('body').on('click', '.b-edittag', function() {
    var dataval = $('#editorf').serialize();
    $.post("ajax.php?act=edittag", dataval, function(data, status) {
        if (status === "success") {
            var myObj = JSON.parse(data);
            if (myObj.IO) {
                $("#result").html(myObj.TEXT);
                $.notify("عملیات با موفقیت انجام شد.", "success")
            } else {
                $.notify("خطا در عملیات", "error");
                $("#result").html(myObj.ERR.toString())
            }
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    })
});
$('body').on('click', '.b-setting', function() {
    var dataval = $('#settingf').serialize();
    $.post("ajax.php?act=setting", dataval, function(data, status) {
        if (status === "success") {
            var myObj = JSON.parse(data);
            if (myObj.IO) {
                $.notify("تنظیمات شما ذخیره شد.", "success");
                $("#page").load(location.href + " #container")
            } else {
                $.notify(myObj.ERR.login, "warn")
            }
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    })
});
$(".b-reset").click(function() {
    $(this).closest('form').find("input[type=text], textarea").val("")
});

function fileSizeSI(a, b, c, d, e) {
    return (b = Math, c = b.log, d = 1e3, e = c(a) / c(d) | 0, a / b.pow(d, e)).toFixed(2) + ' ' + (e ? 'kMGTPEZY' [--e] + 'B' : 'Bytes')
}
$('body').on('click', '.b-listfiles', function() {
    var folder = $('#foldersel :selected').val();
    var dataval = 'dir=' + folder;
    $.post("ajax.php?act=listdir", dataval, function(data, status) {
        if (status === "success") {
            var myObj = JSON.parse(data);
            if (myObj.IO) {
                var i = 0;
                text = "<table><tr><th style='width: 350px;'>Name</th><th>Type</th><th>Size</th><th>Last Modified</th><th>Action</th></tr>";
                for (; myObj.LIST[i];) {
                    text += "<tr><td>" + myObj.LIST[i].name + "</td>";
                    text += "<td>" + myObj.LIST[i].type + "</td>";
                    text += "<td>" + fileSizeSI(myObj.LIST[i].size) + "</td>";
                    text += "<td>" + myObj.LIST[i].lastmod + "</td><td>";
                    if (myObj.LIST[i].type != 'dir') {
                        text += "<a class='b-tagedit' href='tageditor.php?fp=" + myObj.LIST[i].path + "'>ویرایش</a>"
                    }
                    text += "</td></tr>";
                    i++
                }
                text += "</table>";
                $("#files").html(text)
            } else {
                $.notify(myObj.ERR, "warn")
            }
        } else if (status === "error") {
            $.notify("خطا در عملیات", "error")
        } else {
            $.notify("Server Alert! Please contact admin", "warn")
        }
    });
});

$('body').on('click', '.btnurl', function() {
    var urllink = $('#songfileweb').val();
   if (urllink.length < 11) {
        $.notify('آدرس وارد شده صحیح نمی باشد !', "warn")
    } else {
		var dataval = 'u=' + urllink;
		$.post("ajax.php?act=uploadurl", dataval, function(data, status) {
			if (status === "success") {
				var myObj = JSON.parse(data);
				if (myObj.IO) {
					var text = myObj.NAME + '<br>[ <a href="tageditor.php?fp=' + myObj.NAME + '">ویرایش</a> ]';
					$.notify("فایل منتقل شد.", "success");
				} else {
					var text;
					var i = 0;
					for (; myObj.ERR[i];) {
						text += "<br>" + myObj.ERR[i];
						i++
					}
					$.notify("Server Alert! Please contact admin", "warn");
				}
				$("#resuweb").html(text);
			} else if (status === "error") {
				$.notify("خطا در عملیات", "error");
			} else {
				$.notify("Server Alert! Please contact admin", "warn");
			}
		});
    }
});
