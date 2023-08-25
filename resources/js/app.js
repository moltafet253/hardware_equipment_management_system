import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import $ from 'jquery';
import Swal from 'sweetalert2';

function swalFire(title = null, text, icon, confirmButtonText) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: confirmButtonText,
    });
}

function toggleModal(modalID) {
    var modal = document.getElementById(modalID);
    if (modal.classList.contains('modal-active')) {
        modal.classList.remove('animate-fade-in');
        modal.classList.add('animate-fade-out');
        setTimeout(() => {
            modal.classList.remove('modal-active');
            modal.classList.remove('animate-fade-out');
        }, 150);
    } else {
        modal.classList.add('modal-active');
        modal.classList.remove('animate-fade-out');
        modal.classList.add('animate-fade-in');
    }
}

function hasOnlyPersianCharacters(input) {
    var persianPattern = /^[\u0600-\u06FF\s]+$/;
    return persianPattern.test(input);
}

function hasOnlyEnglishCharacters(input) {
    var englishPattern = /^[a-zA-Z\s]+$/;
    return englishPattern.test(input);
}

function swalFireWithQuestion() {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'خیر',
        confirmButtonText: 'بله',
    }).then((result) => {
        if (result.isConfirmed) {
            // کدی که برای حالت بله نوشته می‌شود
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // کدی که برای حالت خیر نوشته می‌شود
        }
    });
}

function hasNumber(text) {
    return /\d/.test(text);
}

function resetFields() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => input.value = "");
    const selectors = document.querySelectorAll('select');
    selectors.forEach(select => select.value = "");
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => textarea.value = "");
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

$(document).ready(function () {
    resetFields();
    //Check Login Form
    $('#loginForm').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    if (response.errors.username) {
                        swalFire('خطای نام کاربری', response.errors.username[0], 'error', 'تلاش مجدد');
                        reloadCaptcha();
                        captcha.value = '';
                    }

                    if (response.errors.password) {
                        swalFire('خطای رمز عبور', response.errors.password[0], 'error', 'تلاش مجدد');
                        reloadCaptcha();
                        captcha.value = '';
                    }

                    if (response.errors.captcha) {
                        swalFire('کد امنیتی نامعتبر', response.errors.captcha[0], 'error', 'تلاش مجدد');
                        reloadCaptcha();
                        captcha.value = '';
                    }
                    if (response.errors.loginError) {
                        swalFire('نام کاربری یا رمز عبور نامعتبر', response.errors.loginError[0], 'error', 'تلاش مجدد');
                        reloadCaptcha();
                        captcha.value = '';
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                if (xhr.responseJSON['YouAreLocked']) {
                    swalFire('دسترسی غیرمجاز', 'آی پی شما به دلیل تعداد درخواست های زیاد بلاک شده است. لطفا یک ساعت دیگر مجددا تلاش کنید.', 'error', 'تایید');
                    const fields = [username, password, captcha];
                    fields.forEach(field => {
                        field.disabled = true;
                        field.value = null;
                        field.style.backgroundColor = 'gray';
                    });
                } else {
                    swalFire('خطای ناشناخته', 'ارتباط با سرور برقرار نشد.', 'error', 'تلاش مجدد');
                    console.clear();
                }

            }
        });
    });
    //Change Password
    $('#change-password').submit(function (e) {
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (response) {
                if (response.success) {
                    swalFire('عملیات موفقیت آمیز بود!', response.errors.passwordChanged[0], 'success', 'بستن');
                    oldPass.value = '';
                    newPass.value = '';
                    repeatNewPass.value = '';
                } else {
                    if (response.errors.oldPassNull) {
                        swalFire('خطا!', response.errors.oldPassNull[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.newPassNull) {
                        swalFire('خطا!', response.errors.newPassNull[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.repeatNewPassNull) {
                        swalFire('خطا!', response.errors.repeatNewPassNull[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.lowerThan8) {
                        swalFire('خطا!', response.errors.lowerThan8[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.higherThan12) {
                        swalFire('خطا!', response.errors.higherThan12[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.wrongRepeat) {
                        swalFire('خطا!', response.errors.wrongRepeat[0], 'error', 'تلاش مجدد');
                    } else if (response.errors.wrongPassword) {
                        swalFire('خطا!', response.errors.wrongPassword[0], 'error', 'تلاش مجدد');
                    } else {
                        location.reload();
                    }
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                // console.log(xhr);
            }
        });
    });
    switch (window.location.pathname) {
        case "/UserManager":
            //Search In User Manager
            $('#search-Username-UserManager').on('input', function () {
                var inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                var type = $('#search-type-UserManager').val();
                $.ajax({
                    url: '/Search',
                    type: 'GET',
                    data: {
                        username: inputUsername,
                        type: type,
                        work: 'UserManagerSearch'
                    },
                    success: function (data) {
                        var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                        tableBody.empty();

                        data.forEach(function (user) {
                            var type;
                            switch (user.type) {
                                case 1:
                                    type = 'ادمین کل';
                                    break;
                                case 2:
                                    type = 'کارشناس ستاد';
                                    break;
                                case 3:
                                    type = 'کارشناس فناوری استان';
                                    break;
                            }
                            var row = '<tr class="bg-white"><td class="px-6 py-4">' + user.username + '</td><td class="px-6 py-4">' + user.name + '</td><td class="px-6 py-4">' + type + '</td>';
                            if (user.active == 1) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="1">غیرفعال‌سازی</button>';
                            } else if (user.active == 0) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="0">فعال‌سازی</button>';
                            }
                            row += '</td>';
                            if (user.NTCP == 1) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="1">می باشد</button>';
                            } else if (user.NTCP == 0) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="0">نمی باشد</button>';
                            }
                            row += '</td>';
                            row += '<td class="px-6 py-4">' + '<button type="submit" data-rp-username="' + user.username + '" class="px-4 py-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 rp">بازنشانی رمز</button>';
                            row += '</td>';
                            row += '</tr>';
                            tableBody.append(row);
                        });
                    },
                    error: function () {
                        console.log('خطا در ارتباط با سرور');
                    }
                });
            });
            $('#search-type-UserManager').on('change', function () {
                var inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                var type = $('#search-type-UserManager').val();
                $.ajax({
                    url: '/Search',
                    type: 'GET',
                    data: {
                        username: inputUsername,
                        type: type,
                        work: 'UserManagerSearch'
                    },
                    success: function (data) {
                        var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                        tableBody.empty();

                        data.forEach(function (user) {
                            var type;
                            switch (user.type) {
                                case 1:
                                    type = 'ادمین کل';
                                    break;
                                case 2:
                                    type = 'کارشناس ستاد';
                                    break;
                                case 3:
                                    type = 'کارشناس فناوری استان';
                                    break;
                            }
                            var row = '<tr class="bg-white"><td class="px-6 py-4">' + user.username + '</td><td class="px-6 py-4">' + user.name + '</td><td class="px-6 py-4">' + type + '</td>';
                            if (user.active == 1) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="1">غیرفعال‌سازی</button>';
                            } else if (user.active == 0) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-username="' + user.username + '" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ASUM" data-active="0">فعال‌سازی</button>';
                            }
                            row += '</td>';
                            if (user.NTCP == 1) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="1">می باشد</button>';
                            } else if (user.NTCP == 0) {
                                row += '<td class="px-6 py-4">' + '<button type="submit" data-ntcp-username="' + user.username + '" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 ntcp" data-ntcp="0">نمی باشد</button>';
                            }
                            row += '</td>';
                            row += '<td class="px-6 py-4">' + '<button type="submit" data-rp-username="' + user.username + '" class="px-4 py-2 p-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 rp">بازنشانی رمز</button>';
                            row += '</td>';
                            row += '</tr>';
                            tableBody.append(row);
                        });
                    },
                    error: function () {
                        console.log('خطا در ارتباط با سرور');
                    }
                });
            });
            //Activation Status In User Manager
            $(document).on('click', '.ASUM', function (e) {
                const username = $(this).data('username');
                const active = $(this).data('active');
                let status = null;
                if (active == 1) {
                    status = 'غیرفعال';
                } else if (active == 0) {
                    status = 'فعال';
                }
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'کاربر انتخاب شده ' + status + ' خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '/ChangeUserActivationStatus',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                username: username,
                            },
                            success: function (response) {
                                if (response.success) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserActivation[0], 'success', 'بستن');
                                    const activeButton = $(`button[data-username="${username}"]`);
                                    if (active == 1) {
                                        activeButton.removeClass('bg-red-500').addClass('bg-green-500');
                                        activeButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                        activeButton.text('فعال‌سازی');
                                        activeButton.data('active', 0);
                                    } else if (active == 0) {
                                        activeButton.removeClass('bg-green-500').addClass('bg-red-500');
                                        activeButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                        activeButton.text('غیرفعال‌سازی');
                                        activeButton.data('active', 1);
                                    }
                                } else {
                                    swalFire('خطا!', response.errors.changedUserActivationFailed[0], 'error', 'تلاش مجدد');
                                }
                            }
                        });
                    }
                });
            });
            //NTCP Status In User Manager
            $(document).on('click', '.ntcp', function (e) {
                const username = $(this).data('ntcp-username');
                const NTCP = $(this).data('ntcp');
                let status = null;
                if (NTCP == 1) {
                    status = 'نمی باشد';
                } else if (NTCP == 0) {
                    status = 'می باشد';
                }
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'کاربر انتخاب شده نیازمند تغییر رمزعبور ' + status + '؟',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '/ChangeUserNTCP',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                username: username,
                            },
                            success: function (response) {
                                if (response.success) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.changedUserNTCP[0], 'success', 'بستن');
                                    const ntcpButton = $(`button[data-ntcp-username="${username}"]`);
                                    if (NTCP == 1) {
                                        ntcpButton.removeClass('bg-red-500').addClass('bg-green-500');
                                        ntcpButton.removeClass('hover:bg-red-600').addClass('hover:bg-green-600');
                                        ntcpButton.text('نمی باشد');
                                        ntcpButton.data('ntcp', 0);
                                    } else if (NTCP == 0) {
                                        ntcpButton.removeClass('bg-green-500').addClass('bg-red-500');
                                        ntcpButton.removeClass('hover:bg-green-600').addClass('hover:bg-red-600');
                                        ntcpButton.text('می باشد');
                                        ntcpButton.data('ntcp', 1);
                                    }
                                } else {
                                    swalFire('خطا!', response.errors.changedUserNTCPFailed[0], 'error', 'تلاش مجدد');
                                }
                            }
                        });
                    }
                });
            });
            //Reset Password In User Manager
            $(document).on('click', '.rp', function (e) {
                const username = $(this).data('rp-username');
                let status = null;

                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'رمز عبور کاربر انتخاب شده به 12345678 بازنشانی خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '/ResetPassword',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            data: {
                                username: username,
                            },
                            success: function (response) {
                                if (response.success) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.passwordResetted[0], 'success', 'بستن');
                                } else {
                                    swalFire('خطا!', response.errors.resetPasswordFailed[0], 'error', 'تلاش مجدد');
                                }
                            }
                        });
                    }
                });
            });
            //Showing Or Hiding Modal
            $('#new-user-button, #cancel-new-user').on('click', function () {
                toggleModal(newUserModal.id);
            });
            $('#edit-user-button, #cancel-edit-user').on('click', function () {
                toggleModal(editUserModal.id);
            });
            //New User
            $('#new-user').submit(function (e) {
                e.preventDefault();
                var name = document.getElementById('name').value;
                var family = document.getElementById('family').value;
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;
                var repeat_password = document.getElementById('repeat-password').value;
                var type = document.getElementById('type').value;

                if (name.length === 0) {
                    swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (family.length === 0) {
                    swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyPersianCharacters(name)) {
                    swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyPersianCharacters(family)) {
                    swalFire('خطا!', 'نام خانوادگی نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                } else if (username.length === 0) {
                    swalFire('خطا!', 'نام کاربری وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (password.length === 0) {
                    swalFire('خطا!', 'رمز عبور وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (repeat_password.length === 0) {
                    swalFire('خطا!', 'تکرار رمز عبور وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (type.length === 0) {
                    swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                } else if (hasOnlyPersianCharacters(username)) {
                    swalFire('خطا!', 'نام کاربری نمی تواند مقدار فارسی داشته باشد.', 'error', 'تلاش مجدد');
                } else if (hasOnlyPersianCharacters(password)) {
                    swalFire('خطا!', 'رمز عبور نمی تواند مقدار فارسی داشته باشد.', 'error', 'تلاش مجدد');
                } else if (hasOnlyPersianCharacters(repeat_password)) {
                    swalFire('خطا!', 'تکرار رمز عبور نمی تواند مقدار فارسی داشته باشد.', 'error', 'تلاش مجدد');
                } else if (password !== repeat_password) {
                    swalFire('خطا!', 'رمز عبور و تکرار آن برابر نیست.', 'error', 'تلاش مجدد');
                } else {
                    var form = $(this);
                    var data = form.serialize();

                    $.ajax({
                        type: 'POST',
                        url: '/NewUser',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.errors && response.errors.userFounded) {
                                swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                            } else if (response.success) {
                                swalFire('عملیات موفقیت آمیز بود!', response.message.userAdded[0], 'success', 'بستن');
                                toggleModal(newUserModal.id);
                                resetFields();
                            }

                        }
                    });
                }
            });
            //Getting User Information
            $('#userIdForEdit').change(function (e) {
                e.preventDefault();
                if (userIdForEdit.value === null || userIdForEdit.value === '') {
                    swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                } else {
                    $.ajax({
                        type: 'GET',
                        url: '/GetUserInfo',
                        data: {
                            userID: userIdForEdit.value
                        },
                        success: function (response) {
                            userEditDiv.hidden = false;
                            editedName.value = response.name;
                            editedFamily.value = response.family;
                            editedType.value = response.type;
                        }
                    });
                }
            });
            //Edit User
            $('#edit-user').submit(function (e) {
                e.preventDefault();
                var userID = userIdForEdit.value;
                var name = editedName.value;
                var family = editedFamily.value;
                var type = editedType.value;

                if (name.length === 0) {
                    swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (family.length === 0) {
                    swalFire('خطا!', 'نام خانوادگی وارد نشده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyPersianCharacters(name)) {
                    swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyPersianCharacters(family)) {
                    swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
                } else if (userID.length === 0) {
                    swalFire('خطا!', 'کاربر انتخاب نشده است.', 'error', 'تلاش مجدد');
                } else if (type.length === 0) {
                    swalFire('خطا!', 'نوع کاربری انتخاب نشده است.', 'error', 'تلاش مجدد');
                } else {
                    var form = $(this);
                    var data = form.serialize();

                    $.ajax({
                        type: 'POST',
                        url: '/EditUser',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            if (response.errors && response.errors.userFounded) {
                                swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                            } else if (response.success) {
                                swalFire('عملیات موفقیت آمیز بود!', response.message.userEdited[0], 'success', 'بستن');
                                toggleModal(editUserModal.id);
                                resetFields();
                            }

                        }
                    });
                }
            });
            break;
        case '/Brands':
            $('#search-brand-catalog-name').on('input', function () {
                var nameValue = $('#search-brand-catalog-name').val();
                $.ajax({
                    url: '/Search',
                    type: 'GET',
                    data: {
                        name: nameValue,
                        work: 'BrandCatalogSearch'
                    },
                    success: function (data) {
                        var a = 1;
                        var tableBody = $('.datasheet tbody');
                        tableBody.empty();
                        data.forEach(function (brand) {
                            var row = '<tr class="bg-white">' + '<td class="px-6 py-4">' + a++ + '</td>' + '<td class="px-6 py-4">' + brand.name + '</td>' + '<td class="px-6 py-4">' + brand.products + '</td>' + '</tr>';
                            tableBody.append(row);
                        });
                    },
                    error: function () {
                        console.log('خطا در ارتباط با سرور');
                    }
                });
            });
            $('#new-brand-button, #cancel-new-brand').on('click', function () {
                toggleModal(newBrandModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newBrandModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editBrandModal.id)
            });
            $('.BrandControl,#cancel-edit-brand').on('click', function () {
                toggleModal(editBrandModal.id);
            });
            $('#new-brand').on('submit', function (e) {
                e.preventDefault();
                let name = document.getElementById('name');
                if (!hasOnlyEnglishCharacters(name.value)) {
                    swalFire('خطا!', 'نام شرکت نمی تواند فارسی باشد.', 'error', 'تلاش مجدد');
                } else {
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = $(this);
                            var data = form.serialize();
                            $.ajax({
                                type: 'POST',
                                url: '/newBrand',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                data: data,
                                success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nameIsNull) {
                                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.repeatedName) {
                                            swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.productIsNull) {
                                            swalFire('خطا!', response.errors.productIsNull[0], 'error', 'تلاش مجدد');
                                        }
                                    } else if (response.success) {
                                        // swalFire('عملیات ثبت برند موفقیت آمیز بود!', response.message.companyAdded[0], 'success', 'بستن');
                                        // toggleModal(newBrandModal.id);
                                        location.reload();
                                        resetFields();
                                    }
                                }
                            });
                        }
                    });
                }
            });
            $('.BrandControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getBrandInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        companyID.value = response.id;
                        editedName.value = response.name;
                        let selectElement = document.getElementById('editedProducts[]');
                        for (let i = 0; i < selectElement.options.length; i++) {
                            let option = selectElement.options[i];
                            if (response.products.includes(option.value)) {
                                option.selected = true;
                            } else {
                                option.selected = false;
                            }
                        }
                    }
                });
            });
            $('#edit-brand').on('submit', function (e) {
                e.preventDefault();
                let name = document.getElementById('editedName');
                if (!hasOnlyEnglishCharacters(name.value)) {
                    swalFire('خطا!', 'نام شرکت نمی تواند فارسی باشد.', 'error', 'تلاش مجدد');
                } else {
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = $(this);
                            var data = form.serialize();
                            $.ajax({
                                type: 'POST',
                                url: '/editBrand',
                                data: data,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nameIsNull) {
                                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.repeatedName) {
                                            swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.productIsNull) {
                                            swalFire('خطا!', response.errors.productIsNull[0], 'error', 'تلاش مجدد');
                                        }
                                    } else if (response.success) {
                                        // swalFire('ویرایش برند موفقیت آمیز بود!', response.message.companyEdited[0], 'success', 'بستن');
                                        // toggleModal(editBrandModal.id);
                                        location.reload();
                                        resetFields();
                                    }
                                }
                            });
                        }
                    });
                }
            });
            $('.deactiveBrandControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeBrandStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/MotherboardCatalog':
            $('#new-motherboard-button, #cancel-new-motherboard').on('click', function () {
                toggleModal(newMotherboardModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newMotherboardModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editMotherboardModal.id)
            });
            $('.MotherboardControl,#cancel-edit-motherboard').on('click', function () {
                toggleModal(editMotherboardModal.id);
            });
            $('#new-motherboard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newMotherboard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCPUSlotNumbers) {
                                        swalFire('خطا!', response.errors.nullCPUSlotNumbers[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRAMSlotNumbers) {
                                        swalFire('خطا!', response.errors.nullRAMSlotNumbers[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCPUSlotType) {
                                        swalFire('خطا!', response.errors.nullCPUSlotType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRamSlotGeneration) {
                                        swalFire('خطا!', response.errors.nullRamSlotGeneration[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullGeneration) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت مادربورد موفقیت آمیز بود!', response.message.motherboardAdded[0], 'success', 'بستن');
                                    // toggleModal(newMotherboardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.MotherboardControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getMotherboardInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            mb_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            mb_genForEdit.value = response.generation;
                            ram_slot_genForEdit.value = response.ram_slot_generation;
                            cpu_slot_typeForEdit.value = response.cpu_slot_type;
                            cpu_slot_numForEdit.value = response.cpu_slots_number;
                            ram_slot_numForEdit.value = response.ram_slots_number;
                        }
                    }
                });
            });
            $('#edit-motherboard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editMotherboard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCPUSlotNumbers) {
                                        swalFire('خطا!', response.errors.nullCPUSlotNumbers[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRAMSlotNumbers) {
                                        swalFire('خطا!', response.errors.nullRAMSlotNumbers[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCPUSlotType) {
                                        swalFire('خطا!', response.errors.nullCPUSlotType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRamSlotGeneration) {
                                        swalFire('خطا!', response.errors.nullRamSlotGeneration[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullGeneration) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش مادربورد موفقیت آمیز بود!', response.message.motherboardEdited[0], 'success', 'بستن');
                                    // toggleModal(editMotherboardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveMotherboardControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeMotherboardStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/CaseCatalog':
            $('#new-case-button, #cancel-new-case').on('click', function () {
                toggleModal(newCaseModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newCaseModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editCaseModal.id)
            });
            $('.CaseControl,#cancel-edit-case').on('click', function () {
                toggleModal(editCaseModal.id);
            });
            $('#new-case').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newCase',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات کیس موفقیت آمیز بود!', response.message.caseAdded[0], 'success', 'بستن');
                                    // toggleModal(newCaseModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.CaseControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getCaseInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            case_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-case').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editCase',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش کیس موفقیت آمیز بود!', response.message.caseEdited[0], 'success', 'بستن');
                                    // toggleModal(editCaseModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveCaseControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeCaseStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/CPUCatalog':
            $('#new-cpu-button, #cancel-cpu-case').on('click', function () {
                toggleModal(newCPUModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newCPUModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editCPUModal.id)
            });
            $('.CPUControl,#cancel-edit-case').on('click', function () {
                toggleModal(editCPUModal.id);
            });
            $('#new-cpu').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newCPU',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullGeneration) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات پردازنده موفقیت آمیز بود!', response.message.cpuAdded[0], 'success', 'بستن');
                                    // toggleModal(newCPUModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.CPUControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getCPUInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            cpu_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            generationForEdit.value = response.generation;
                        }
                    }
                });
            });
            $('#edit-cpu').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editCPU',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullGeneration) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش پردازنده موفقیت آمیز بود!', response.message.cpuEdited[0], 'success', 'بستن');
                                    // toggleModal(editCPUModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveCPUControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeCPUStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/RAMCatalog':
            $('#new-ram-button, #cancel-new-ram').on('click', function () {
                toggleModal(newRAMModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newRAMModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editRAMModal.id)
            });
            $('.RAMControl,#cancel-edit-ram').on('click', function () {
                toggleModal(editRAMModal.id);
            });
            $('#new-ram').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newRAM',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullType) {
                                        swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFrequency) {
                                        swalFire('خطا!', response.errors.nullFrequency[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSize) {
                                        swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات رم موفقیت آمیز بود!', response.message.ramAdded[0], 'success', 'بستن');
                                    // toggleModal(newRAMModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.RAMControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getRAMInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            ram_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            typeForEdit.value = response.type;
                            sizeForEdit.value = response.size;
                            frequencyForEdit.value = response.frequency;
                        }
                    }
                });
            });
            $('#edit-ram').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editRAM',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullType) {
                                        swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFrequency) {
                                        swalFire('خطا!', response.errors.nullFrequency[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSize) {
                                        swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش رم موفقیت آمیز بود!', response.message.ramEdited[0], 'success', 'بستن');
                                    // toggleModal(editRAMModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveRAMControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeRAMStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/PowerCatalog':
            $('#new-power-button, #cancel-new-power').on('click', function () {
                toggleModal(newPowerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newPowerModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editPowerModal.id)
            });
            $('.PowerControl,#cancel-edit-power').on('click', function () {
                toggleModal(editPowerModal.id);
            });
            $('#new-power').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newPower',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVoltage) {
                                        swalFire('خطا!', response.errors.nullVoltage[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات منبع تغذیه موفقیت آمیز بود!', response.message.powerAdded[0], 'success', 'بستن');
                                    // toggleModal(newPowerModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.PowerControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getPowerInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            power_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            output_voltageForEdit.value = response.output_voltage;
                        }
                    }
                });
            });
            $('#edit-power').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editPower',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVoltage) {
                                        swalFire('خطا!', response.errors.nullVoltage[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش منبع تغذیه موفقیت آمیز بود!', response.message.powerEdited[0], 'success', 'بستن');
                                    // toggleModal(editPowerModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactivePowerControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangePowerStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/GraphicCardCatalog':
            $('#new-graphiccard-button, #cancel-new-graphiccard').on('click', function () {
                toggleModal(newGraphicCardModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newGraphicCardModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editGraphicCardModal.id)
            });
            $('.GraphicCardControl,#cancel-edit-graphiccard').on('click', function () {
                toggleModal(editGraphicCardModal.id);
            });
            $('#new-graphiccard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newGraphicCard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRamSize) {
                                        swalFire('خطا!', response.errors.nullRamSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات کارت گرافیک موفقیت آمیز بود!', response.message.graphiccardAdded[0], 'success', 'بستن');
                                    // toggleModal(newGraphicCardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.GraphicCardControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getGraphicCardInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            graphiccard_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            ram_sizeForEdit.value = response.ram_size;
                        }
                    }
                });
            });
            $('#edit-graphiccard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editGraphicCard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRamSize) {
                                        swalFire('خطا!', response.errors.nullRamSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش کارت گرافیک موفقیت آمیز بود!', response.message.graphiccardEdited[0], 'success', 'بستن');
                                    // toggleModal(editGraphicCardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveGraphicCardControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeGraphicCardStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/HarddiskCatalog':
            $('#new-harddisk-button, #cancel-new-harddisk').on('click', function () {
                toggleModal(newHarddiskModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newHarddiskModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editHarddiskModal.id)
            });
            $('.HarddiskControl,#cancel-edit-harddisk').on('click', function () {
                toggleModal(editHarddiskModal.id);
            });
            $('#new-harddisk').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newHarddisk',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullType) {
                                        swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCapacity) {
                                        swalFire('خطا!', response.errors.nullCapacity[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullConnectivityType[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات هارد موفقیت آمیز بود!', response.message.harddiskAdded[0], 'success', 'بستن');
                                    // toggleModal(newHarddiskModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.HarddiskControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getHarddiskInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            harddisk_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            typeForEdit.value = response.type;
                            capacityForEdit.value = response.capacity;
                            connectivity_typeForEdit.value = response.connectivity_type;
                        }
                    }
                });
            });
            $('#edit-Harddisk').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editHarddisk',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullType) {
                                        swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCapacity) {
                                        swalFire('خطا!', response.errors.nullCapacity[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullConnectivityType[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش هارد موفقیت آمیز بود!', response.message.harddiskEdited[0], 'success', 'بستن');
                                    // toggleModal(editHarddiskModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveHarddiskControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeHarddiskStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/ODDCatalog':
            $('#new-ODD-button, #cancel-ODD-case').on('click', function () {
                toggleModal(newODDModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newODDModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editODDModal.id)
            });
            $('.ODDControl,#cancel-edit-ODD').on('click', function () {
                toggleModal(editODDModal.id);
            });
            $('#new-ODD').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newODD',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات درایو نوری موفقیت آمیز بود!', response.message.ODDAdded[0], 'success', 'بستن');
                                    // toggleModal(newODDModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.ODDControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getODDInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            ODD_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            connectivity_typeForEdit.value = response.connectivity_type;
                        }
                    }
                });
            });
            $('#edit-ODD').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editODD',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش درایو نوری موفقیت آمیز بود!', response.message.ODDEdited[0], 'success', 'بستن');
                                    // toggleModal(editODDModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveODDControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeODDStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/NetworkCardCatalog':
            $('#new-NetworkCard-button, #cancel-new-NetworkCard').on('click', function () {
                toggleModal(newNetworkCardModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newNetworkCardModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editNetworkCardModal.id)
            });
            $('.NetworkCardControl,#cancel-edit-NetworkCard').on('click', function () {
                toggleModal(editNetworkCardModal.id);
            });
            $('#new-NetworkCard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newNetworkCard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات کارت شبکه موفقیت آمیز بود!', response.message.NetworkCardAdded[0], 'success', 'بستن');
                                    // toggleModal(newNetworkCardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.NetworkCardControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getNetworkCardInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            NetworkCard_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            connectivity_typeForEdit.value = response.connectivity_type;
                        }
                    }
                });
            });
            $('#edit-NetworkCard').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editNetworkCard',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullConnectivityType) {
                                        swalFire('خطا!', response.errors.nullGeneration[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش کارت شبکه موفقیت آمیز بود!', response.message.NetworkCardEdited[0], 'success', 'بستن');
                                    // toggleModal(editNetworkCardModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveNetworkCardControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeNetworkCardStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/MonitorCatalog':
            $('#new-Monitor-button, #cancel-new-Monitor').on('click', function () {
                toggleModal(newMonitorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newMonitorModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editMonitorModal.id)
            });
            $('.MonitorControl,#cancel-edit-Monitor').on('click', function () {
                toggleModal(editMonitorModal.id);
            });
            $('#new-Monitor').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newMonitor',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSize) {
                                        swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات مانیتور موفقیت آمیز بود!', response.message.MonitorAdded[0], 'success', 'بستن');
                                    // toggleModal(newMonitorModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.MonitorControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getMonitorInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            Monitor_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            sizeForEdit.value = response.size;
                        }
                    }
                });
            });
            $('#edit-monitor').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editMonitor',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSize) {
                                        swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش مانیتور موفقیت آمیز بود!', response.message.MonitorEdited[0], 'success', 'بستن');
                                    // toggleModal(editMonitorModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveMonitorControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeMonitorStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/PrinterCatalog':
            $('#new-printer-button, #cancel-new-printer').on('click', function () {
                toggleModal(newPrinterModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newPrinterModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editPrinterModal.id)
            });
            $('.PrinterControl,#cancel-edit-printer').on('click', function () {
                toggleModal(editPrinterModal.id);
            });
            $('#new-printer').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newPrinter',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات پرینتر موفقیت آمیز بود!', response.message.printerAdded[0], 'success', 'بستن');
                                    // toggleModal(newPrinterModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.PrinterControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getPrinterInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            printer_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-printer').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editPrinter',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش پرینتر موفقیت آمیز بود!', response.message.printerEdited[0], 'success', 'بستن');
                                    // toggleModal(editPrinterModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactivePrinterControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangePrinterStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/ScannerCatalog':
            $('#new-scanner-button, #cancel-new-printer').on('click', function () {
                toggleModal(newScannerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newScannerModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editScannerModal.id)
            });
            $('.ScannerControl,#cancel-edit-scanner').on('click', function () {
                toggleModal(editScannerModal.id);
            });
            $('#new-scanner').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newScanner',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات اسکنر موفقیت آمیز بود!', response.message.scannerAdded[0], 'success', 'بستن');
                                    // toggleModal(newScannerModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.ScannerControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getScannerInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            scanner_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-scanner').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editScanner',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش اسکنر موفقیت آمیز بود!', response.message.scannerEdited[0], 'success', 'بستن');
                                    // toggleModal(editScannerModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveScannerControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeScannerStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/CopyMachineCatalog':
            $('#new-copy-machine-button, #cancel-new-copy-machine').on('click', function () {
                toggleModal(newCopyMachineModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newCopyMachineModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editCopyMachineModal.id)
            });
            $('.CopyMachineControl,#cancel-edit-copy-machine').on('click', function () {
                toggleModal(editCopyMachineModal.id);
            });
            $('#new-copy-machine').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newCopyMachine',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات دستگاه کپی موفقیت آمیز بود!', response.message.CopyMachineAdded[0], 'success', 'بستن');
                                    // toggleModal(newCopyMachineModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.CopyMachineControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getCopyMachineInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            copy_machine_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-copy-machine').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editCopyMachine',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش دستگاه کپی موفقیت آمیز بود!', response.message.CopyMachineEdited[0], 'success', 'بستن');
                                    // toggleModal(editCopyMachineModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveCopyMachineControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeCopyMachineStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/VOIPCatalog':
            $('#new-VOIP-button, #cancel-new-VOIP').on('click', function () {
                toggleModal(newVOIPModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newVOIPModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editVOIPModal.id)
            });
            $('.VOIPControl,#cancel-edit-VOIP').on('click', function () {
                toggleModal(editVOIPModal.id);
            });
            $('#new-VOIP').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newVOIP',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات VOIP موفقیت آمیز بود!', response.message.VOIPAdded[0], 'success', 'بستن');
                                    // toggleModal(newVOIPModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.VOIPControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getVOIPInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            VOIP_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-VOIP').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editVOIP',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullBrand) {
                                        swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModel) {
                                        swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش VOIP موفقیت آمیز بود!', response.message.VOIPEdited[0], 'success', 'بستن');
                                    // toggleModal(editVOIPModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveVOIPControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeVOIPStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/AssistanceCatalog':
            $('#new-assistance-button, #cancel-new-assistance').on('click', function () {
                toggleModal(newAssistanceModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newAssistanceModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editAssistanceModal.id)
            });
            $('.AssistanceControl,#cancel-edit-assistance').on('click', function () {
                toggleModal(editAssistanceModal.id);
            });
            $('#new-assistance').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newAssistance',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات جدید موفقیت آمیز بود!', response.message.assistanceAdded[0], 'success', 'بستن');
                                    // toggleModal(newAssistanceModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.AssistanceControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getAssistanceInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            assistance_id.value = response.id;
                            nameForEdit.value = response.name;
                        }
                    }
                });
            });
            $('#edit-assistance').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editAssistance',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش اطلاعات موفقیت آمیز بود!', response.message.assistanceEdited[0], 'success', 'بستن');
                                    // toggleModal(editAssistanceModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveAssistanceControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeAssistanceStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/JobCatalog':
            $('#new-job-button, #cancel-new-job').on('click', function () {
                toggleModal(newJobModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newJobModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editJobModal.id)
            });
            $('.JobControl,#cancel-edit-job').on('click', function () {
                toggleModal(editJobModal.id);
            });
            $('#new-job').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newJob',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات جدید موفقیت آمیز بود!', response.message.jobAdded[0], 'success', 'بستن');
                                    // toggleModal(newJobModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.JobControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getJobInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            job_id.value = response.id;
                            titleForEdit.value = response.title;
                        }
                    }
                });
            });
            $('#edit-job').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editJob',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش اطلاعات موفقیت آمیز بود!', response.message.jobEdited[0], 'success', 'بستن');
                                    // toggleModal(editJobModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveJobControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeJobStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/EstablishmentPlaceCatalog':
            $('#new-establishment-place-button, #cancel-new-establishment-place').on('click', function () {
                toggleModal(newEstablishmentPlaceModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newEstablishmentPlaceModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editEstablishmentPlaceModal.id)
            });
            $('.EstablishmentPlaceControl,#cancel-edit-establishment-place').on('click', function () {
                toggleModal(editEstablishmentPlaceModal.id);
            });
            $('#new-establishment-place').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newEstablishmentPlace',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت اطلاعات جدید موفقیت آمیز بود!', response.message.establishmentPlaceAdded[0], 'success', 'بستن');
                                    // toggleModal(newEstablishmentPlaceModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.EstablishmentPlaceControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getEstablishmentPlaceInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            establishment_place_id.value = response.id;
                            titleForEdit.value = response.title;
                        }
                    }
                });
            });
            $('#edit-establishment-place').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editEstablishmentPlace',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupName) {
                                        swalFire('خطا!', response.errors.dupName[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش اطلاعات موفقیت آمیز بود!', response.message.establishmentPlaceEdited[0], 'success', 'بستن');
                                    // toggleModal(editEstablishmentPlaceModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.deactiveEstablishmentPlaceControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    $.ajax({
                        type: 'POST',
                        url: '/ManageCatalogStatus',
                        data: {
                            id: $(this).data('id'),
                            work: 'ChangeEstablishmentPlaceStatus'
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;
        case '/Person':
            $('#new-person-button, #cancel-new-person').on('click', function () {
                toggleModal(newPersonModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newPersonModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editPersonModal.id)
            });
            $('.PersonControl,#cancel-edit-person').on('click', function () {
                toggleModal(editPersonModal.id);
            });
            $('#new-person').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/newPerson',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFamily) {
                                        swalFire('خطا!', response.errors.nullFamily[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupPersonnelCode) {
                                        swalFire('خطا!', response.errors.dupPersonnelCode[0], 'error', 'تلاش مجدد');
                                    }else if (response.errors.wrongNationalCode) {
                                        swalFire('خطا!', response.errors.wrongNationalCode[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    $('table tbody').append(response.html);
                                    // swalFire('ثبت موفقیت آمیز بود!', 'ثبت اطلاعات پرسنل موفقیت آمیز بود.', 'success', 'بستن');
                                    // toggleModal(newPersonModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('.PersonControl').on('click', function () {
                $.ajax({
                    type: 'GET',
                    url: '/getPersonInfo',
                    data: {
                        id: $(this).data('id')
                    },
                    success: function (response) {
                        if (response) {
                            personID.value = response.id;
                            nameForEdit.value = response.name;
                            familyForEdit.value = response.family;
                            national_codeForEdit.value = response.national_code;
                            personnel_codeForEdit.value = response.personnel_code;
                            phoneForEdit.value = response.phone;
                            mobileForEdit.value = response.mobile;
                            net_usernameForEdit.value = response.net_username;
                            room_numberForEdit.value = response.room_number;
                            assistanceForEdit.value = response.assistance;
                            establishmentplaceForEdit.value = response.establishment_place;
                        }
                    }
                });
            });
            $('#edit-person').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'با ویرایش این مقدار، تمامی فیلدها تغییر خواهند کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST',
                            url: '/editPerson',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFamily) {
                                        swalFire('خطا!', response.errors.nullFamily[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    }else if (response.errors.nullNationalCode) {
                                        swalFire('خطا!', response.errors.nullNationalCode[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ویرایش پرسنل موفقیت آمیز بود!', response.message.personEdited[0], 'success', 'بستن');
                                    // toggleModal(editPersonModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            break;
        case '/showEquipmentStatus':
            $('.AddCase, #cancel-add-case').on('click', function () {
                toggleModal(addCaseModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcase').on('click', function () {
                toggleModal(addCaseModal.id)
            });
            $('.AddMonitor, #cancel-add-monitor').on('click', function () {
                toggleModal(addMonitorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addmonitor').on('click', function () {
                toggleModal(addMonitorModal.id)
            });
            $('.AddPrinter, #cancel-add-printer').on('click', function () {
                toggleModal(addPrinterModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addprinter').on('click', function () {
                toggleModal(addPrinterModal.id)
            });
            $('.AddScanner, #cancel-add-scanner').on('click', function () {
                toggleModal(addScannerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addscanner').on('click', function () {
                toggleModal(addScannerModal.id)
            });
            $('.AddCopyMachine, #cancel-add-copymachine').on('click', function () {
                toggleModal(addCopyMachineModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcopymachine').on('click', function () {
                toggleModal(addCopyMachineModal.id)
            });
            $('.AddVOIP, #cancel-add-voip').on('click', function () {
                toggleModal(addVOIPModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addVOIP').on('click', function () {
                toggleModal(addVOIPModal.id)
            });
            $('.AddComment, #cancel-add-comment').on('click', function () {
                toggleModal(addCommentModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcomment').on('click', function () {
                toggleModal(addCommentModal.id)
            });

            $('#new-case').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentCase',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullStampNumber) {
                                        swalFire('خطا!', response.errors.nullStampNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCaseInfo) {
                                        swalFire('خطا!', response.errors.nullCaseInfo[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullMotherboard) {
                                        swalFire('خطا!', response.errors.nullMotherboard[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPower) {
                                        swalFire('خطا!', response.errors.nullPower[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCPU) {
                                        swalFire('خطا!', response.errors.nullCPU[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRAM) {
                                        swalFire('خطا!', response.errors.nullRAM[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullHDD) {
                                        swalFire('خطا!', response.errors.nullHDD[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت کیس جدید موفقیت آمیز بود!', response.message.caseAdded[0], 'success', 'بستن');
                                    // toggleModal(addCaseModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-monitor').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentMonitor',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullMonitor) {
                                        swalFire('خطا!', response.errors.nullMonitor[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت مانیتور جدید موفقیت آمیز بود!', response.message.monitorAdded[0], 'success', 'بستن');
                                    // toggleModal(addMonitorModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-printer').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentPrinter',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPrinter) {
                                        swalFire('خطا!', response.errors.nullPrinter[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت پرینتر جدید موفقیت آمیز بود!', response.message.printerAdded[0], 'success', 'بستن');
                                    // toggleModal(addPrinterModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-scanner').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentScanner',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullScanner) {
                                        swalFire('خطا!', response.errors.nullScanner[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت پرینتر جدید موفقیت آمیز بود!', response.message.scannerAdded[0], 'success', 'بستن');
                                    // toggleModal(addScannerModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-copymachine').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentCopyMachine',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCopyMachine) {
                                        swalFire('خطا!', response.errors.nullCopyMachine[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت دستگاه کپی جدید موفقیت آمیز بود!', response.message.copymachineAdded[0], 'success', 'بستن');
                                    // toggleModal(addCopyMachineModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-voip').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        var idFromLink = getParameterByName('id', window.location.href);
                        data += "&person=" + idFromLink;
                        $.ajax({
                            type: 'POST',
                            url: '/newEquipmentVOIP',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVOIP) {
                                        swalFire('خطا!', response.errors.nullVOIP[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.success) {
                                    // swalFire('ثبت VOIP جدید موفقیت آمیز بود!', response.message.VOIPAdded[0], 'success', 'بستن');
                                    // toggleModal(addVOIPModal.id);
                                    location.reload();
                                    resetFields();
                                }
                            }
                        });
                    }
                });
            });
            $('#new-comment').on('submit', function (e) {
                e.preventDefault();
                if (isNaN(ticket_number.value)){
                    swalFire('خطا!', 'مقدار شماره تیکت اشتباه می باشد.', 'error', 'تلاش مجدد');
                }else {
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: 'این مقدار به صورت دائمی اضافه خواهد شد.',
                        icon: 'warning',
                        showCancelButton: true,
                        cancelButtonText: 'خیر',
                        confirmButtonText: 'بله',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var form = $(this);
                            var data = form.serialize();
                            var idFromLink = getParameterByName('id', window.location.href);
                            data += "&person=" + idFromLink;
                            $.ajax({
                                type: 'POST',
                                url: '/newComment',
                                data: data,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                },
                                success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullPersonnelCode) {
                                            swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullDescription) {
                                            swalFire('خطا!', response.errors.nullDescription[0], 'error', 'تلاش مجدد');
                                        }
                                    } else if (response.success) {
                                        $('table tbody').append(response.html);
                                        CommentErr.hidden = true;
                                        swalFire('ثبت کار جدید موفقیت آمیز بود!', 'کامنت با موفقیت اضافه شد.', 'success', 'بستن');
                                        toggleModal(addCommentModal.id);
                                        resetFields();
                                    }
                                }
                            });
                        }
                    });
                }
            });
    }
});
