import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.css';
import $ from 'jquery';
import Swal from 'sweetalert2';

window.Swal = Swal;

function swalFire(title = null, text, icon, confirmButtonText) {
    Swal.fire({
        title: title, text: text, icon: icon, confirmButtonText: confirmButtonText,
    });
}



function hasOnlyPersianCharacters(input) {
    var persianPattern = /^[\u0600-\u06FF0-9()\s]+$/;
    return persianPattern.test(input);
}

function hasOnlyEnglishCharacters(input) {
    var englishPattern = /^[a-zA-Z0-9\s]+$/;
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
    // const radios = document.querySelectorAll('input');
    // radios.forEach(input => input.selected = "");
    // const checkboxes = document.querySelectorAll("input");
    // checkboxes.forEach(input => input.selected = "");
}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'), results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

//Get Jalali time and date
function getJalaliDate() {
    return new Promise(function (resolve, reject) {
        $.ajax({
            type: 'GET',
            url: "/date",
            success: function (response) {
                resolve(response);
            },
            error: function (error) {
                reject(error);
            }
        });
    });
}

$(document).ready(function () {


    switch (window.location.pathname) {

        case "/Profile":
            resetFields();

            $('#change-password').submit(function (e) {
                e.preventDefault();

                var form = $(this);
                var data = form.serialize();

                $.ajax({
                    type: 'POST', url: "/ChangePasswordInc", data: data, headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }, success: function (response) {
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
                    }, error: function (xhr, textStatus, errorThrown) {
                        // console.log(xhr);
                    }
                });
            });
            $('#change-user-image').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                $.ajax({
                    type: 'POST',
                    url: "/ChangeUserImage",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            if (response.errors.wrongImage) {
                                swalFire('خطا!', response.errors.wrongImage[0], 'error', 'تلاش مجدد');
                            } else {
                                location.reload();
                            }
                        }
                    }, error: function (xhr, textStatus, errorThrown) {
                        // console.log(xhr);
                    }
                });
            });
            break;
        case "/UserManager":
            resetFields();

            //Search In User Manager
            $('#search-Username-UserManager').on('input', function () {
                var inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                var type = $('#search-type-UserManager').val();
                $.ajax({
                    url: '/Search', type: 'GET', data: {
                        username: inputUsername, type: type, work: 'UserManagerSearch'
                    }, success: function (data) {
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
                    }, error: function () {
                        console.log('خطا در ارتباط با سرور');
                    }
                });
            });
            $('#search-type-UserManager').on('change', function () {
                var inputUsername = $('#search-Username-UserManager').val().trim().toLowerCase();
                var type = $('#search-type-UserManager').val();
                $.ajax({
                    url: '/Search', type: 'GET', data: {
                        username: inputUsername, type: type, work: 'UserManagerSearch'
                    }, success: function (data) {
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
                    }, error: function () {
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
                            type: 'POST', url: '/ChangeUserActivationStatus', headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, data: {
                                username: username,
                            }, success: function (response) {
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
                            type: 'POST', url: '/ChangeUserNTCP', headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, data: {
                                username: username,
                            }, success: function (response) {
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
                            type: 'POST', url: '/ResetPassword', headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, data: {
                                username: username,
                            }, success: function (response) {
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
            $('#type').on('change', function () {
                let provinceDiv = document.getElementById('provinceDiv');
                if (this.value === '2') {
                    provinceDiv.classList.remove('hidden');
                } else {
                    provinceDiv.classList.add('hidden');
                }
            });
            $('#editedType').on('change', function () {
                let provinceDiv = document.getElementById('editedProvinceDiv');
                if (this.value === '2') {
                    provinceDiv.classList.remove('hidden');
                } else {
                    provinceDiv.classList.add('hidden');
                }
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
                        type: 'POST', url: '/NewUser', data: data, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.errors && response.errors.userFounded) {
                                swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                            } else if (response.errors && response.errors.emptyProvince) {
                                swalFire('خطا!', response.errors.emptyProvince[0], 'error', 'تلاش مجدد');
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
                        type: 'GET', url: '/GetUserInfo', data: {
                            userID: userIdForEdit.value
                        }, success: function (response) {
                            userEditDiv.hidden = false;
                            editedName.value = response.name;
                            editedFamily.value = response.family;
                            editedType.value = response.type;
                            editedProvince.value = response.province_id;
                            let provinceDiv = document.getElementById('editedProvinceDiv');
                            if (response.type == '3') {
                                provinceDiv.classList.remove('hidden');
                            } else {
                                provinceDiv.classList.add('hidden');
                            }
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
                        type: 'POST', url: '/EditUser', data: data, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            if (response.errors && response.errors.userFounded) {
                                swalFire('خطا!', response.errors.userFounded[0], 'error', 'تلاش مجدد');
                            } else if (response.errors && response.errors.emptyProvince) {
                                swalFire('خطا!', response.errors.emptyProvince[0], 'error', 'تلاش مجدد');
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
            resetFields();

            $('#search-brand-catalog-name').on('input', function () {
                var nameValue = $('#search-brand-catalog-name').val();
                $.ajax({
                    url: '/Search', type: 'GET', data: {
                        name: nameValue, work: 'BrandCatalogSearch'
                    }, success: function (data) {
                        var a = 1;
                        var tableBody = $('.datasheet tbody');
                        tableBody.empty();
                        data.forEach(function (brand) {
                            var row = '<tr class="bg-white">' + '<td class="px-6 py-4">' + a++ + '</td>' + '<td class="px-6 py-4">' + brand.name + '</td>' + '<td class="px-6 py-4">' + brand.products + '</td>' + '</tr>';
                            tableBody.append(row);
                        });
                    }, error: function () {
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
                                type: 'POST', url: '/newBrand', headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, data: data, success: function (response) {
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
                    type: 'GET', url: '/getBrandInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                                type: 'POST', url: '/editBrand', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                        type: 'POST', url: '/ManageCatalogStatus', data: {
                            id: $(this).data('id'), work: 'ChangeBrandStatus'
                        }, headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }, success: function (response) {
                            location.reload();
                        }
                    });
                });

            });
            break;

        case '/MotherboardCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newMotherboard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.MotherboardControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getMotherboardInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editMotherboard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeMotherboardStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/CaseCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newCase', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.CaseControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getCaseInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editCase', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeCaseStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/CPUCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newCPU', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.CPUControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getCPUInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editCPU', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeCPUStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/RAMCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newRAM', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.RAMControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getRAMInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editRAM', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeRAMStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/PowerCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(output_voltage.value)) {
                    swalFire('خطا!', 'ولتاژ خروجی وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newPower', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.PowerControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getPowerInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(output_voltageForEdit.value)) {
                    swalFire('خطا!', 'ولتاژ خروجی وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editPower', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangePowerStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/GraphicCardCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newGraphicCard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.GraphicCardControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getGraphicCardInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editGraphicCard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeGraphicCardStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/HarddiskCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newHarddisk', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.HarddiskControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getHarddiskInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editHarddisk', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeHarddiskStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/ODDCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newODD', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.ODDControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getODDInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editODD', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeODDStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/NetworkCardCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newNetworkCard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.NetworkCardControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getNetworkCardInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editNetworkCard', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeNetworkCardStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });
            });
            break;
        case '/MonitorCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(size.value)) {
                    swalFire('خطا!', 'سایز صفحه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newMonitor', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.MonitorControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getMonitorInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(sizeForEdit.value)) {
                    swalFire('خطا!', 'سایز صفحه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editMonitor', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeMonitorStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/PrinterCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newPrinter', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.function_typeForEdit) {
                                            swalFire('خطا!', response.errors.function_typeForEdit[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.PrinterControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getPrinterInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            printer_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            function_typeForEdit.value = response.function_type;
                        }
                    }
                });
            });
            $('#edit-printer').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editPrinter', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.function_typeForEdit) {
                                            swalFire('خطا!', response.errors.function_typeForEdit[0], 'error', 'تلاش مجدد');
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangePrinterStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/ScannerCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newScanner', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.ScannerControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getScannerInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editScanner', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeScannerStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/CopyMachineCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newCopyMachine', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.CopyMachineControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getCopyMachineInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editCopyMachine', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeCopyMachineStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/VOIPCatalog':
            resetFields();

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
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newVOIP', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.VOIPControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getVOIPInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
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
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editVOIP', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeVOIPStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;

        case '/SwitchCatalog':
            resetFields();

            $('#new-switch-button, #cancel-new-switch').on('click', function () {
                toggleModal(newSwitchModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newSwitchModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editSwitchModal.id)
            });
            $('.SwitchControl,#cancel-edit-switch').on('click', function () {
                toggleModal(editSwitchModal.id);
            });
            $('#new-switch').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(ports_number.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newSwitch', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullPortsNumber) {
                                            swalFire('خطا!', response.errors.nullPortsNumber[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.wrongPortsNumber) {
                                            swalFire('خطا!', response.errors.wrongPortsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.SwitchControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getSwitchInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            switch_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            ports_numberForEdit.value = response.ports_number;
                        }
                    }
                });
            });
            $('#edit-switch').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(ports_numberForEdit.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editSwitch', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullPortsNumber) {
                                            swalFire('خطا!', response.errors.nullPortsNumber[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.wrongPortsNumber) {
                                            swalFire('خطا!', response.errors.wrongPortsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveSwitchControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeSwitchStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/ModemCatalog':
            resetFields();

            $('#new-modem-button, #cancel-new-modem').on('click', function () {
                toggleModal(newModemModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newModemModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editModemModal.id)
            });
            $('.ModemControl,#cancel-edit-modem').on('click', function () {
                toggleModal(editModemModal.id);
            });
            $('#new-modem').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(ports_number.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newModem', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullPortsNumber) {
                                            swalFire('خطا!', response.errors.nullPortsNumber[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullType) {
                                            swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullConnectivityType) {
                                            swalFire('خطا!', response.errors.nullConnectivityType[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.wrongPortsNumber) {
                                            swalFire('خطا!', response.errors.wrongPortsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.ModemControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getModemInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            modem_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            ports_numberForEdit.value = response.ports_number;
                            typeForEdit.value = response.type;
                            let selectElement = document.getElementById('connectivity_typeForEdit[]');
                            for (let i = 0; i < selectElement.options.length; i++) {
                                let option = selectElement.options[i];
                                if (response.connectivity_type.includes(option.value)) {
                                    option.selected = true;
                                } else {
                                    option.selected = false;
                                }
                            }
                        }
                    }
                });
            });
            $('#edit-modem').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (isNaN(ports_numberForEdit.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editModem', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullPortsNumber) {
                                            swalFire('خطا!', response.errors.nullPortsNumber[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullType) {
                                            swalFire('خطا!', response.errors.nullType[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullConnectivityType) {
                                            swalFire('خطا!', response.errors.nullConnectivityType[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.wrongPortsNumber) {
                                            swalFire('خطا!', response.errors.wrongPortsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveModemControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeModemStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;

        case '/LaptopCatalog':
            resetFields();

            $('#new-laptop-button, #cancel-new-laptop').on('click', function () {
                toggleModal(newLaptopModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newLaptopModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editLaptopModal.id)
            });
            $('.LaptopControl,#cancel-edit-laptop').on('click', function () {
                toggleModal(editLaptopModal.id);
            });
            $('#new-laptop').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyEnglishCharacters(cpu.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyEnglishCharacters(graphic_card.value) && graphic_card.value !== null) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newLaptop', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullCPU) {
                                            swalFire('خطا!', response.errors.nullCPU[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.LaptopControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getLaptopInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            laptop_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            cpuForEdit.value = response.cpu;
                            graphic_cardForEdit.value = response.graphic_card;
                            screen_sizeForEdit.value = response.screen_size;
                        }
                    }
                });
            });
            $('#edit-laptop').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyEnglishCharacters(cpuForEdit.value)) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                } else if (!hasOnlyEnglishCharacters(graphic_cardForEdit.value) && graphic_cardForEdit.value !== null) {
                    swalFire('خطا!', 'تعداد پورت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editLaptop', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullCPU) {
                                            swalFire('خطا!', response.errors.nullCPU[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullGraphicCard) {
                                            swalFire('خطا!', response.errors.nullGraphicCard[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveLaptopControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeLaptopStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/MobileCatalog':
            resetFields();

            $('#new-mobile-button, #cancel-new-mobile').on('click', function () {
                toggleModal(newMobileModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newMobileModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editMobileModal.id)
            });
            $('.MobileControl,#cancel-edit-mobile').on('click', function () {
                toggleModal(editMobileModal.id);
            });
            $('#new-mobile').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newMobile', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullRam) {
                                            swalFire('خطا!', response.errors.nullRam[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullInternalMemory) {
                                            swalFire('خطا!', response.errors.nullInternalMemory[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSimcardsNumber) {
                                            swalFire('خطا!', response.errors.nullSimcardsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.MobileControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getMobileInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            mobile_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            ramForEdit.value = response.ram;
                            internal_memoryForEdit.value = response.internal_memory;
                            simcards_numberForEdit.value = response.simcards_number;
                        }
                    }
                });
            });
            $('#edit-mobile').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editMobile', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullRam) {
                                            swalFire('خطا!', response.errors.nullRam[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullInternalMemory) {
                                            swalFire('خطا!', response.errors.nullInternalMemory[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSimcardsNumber) {
                                            swalFire('خطا!', response.errors.nullSimcardsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveMobileControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeMobileStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/TabletCatalog':
            resetFields();

            $('#new-tablet-button, #cancel-new-tablet').on('click', function () {
                toggleModal(newTabletModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newTabletModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editTabletModal.id)
            });
            $('.TabletControl,#cancel-edit-tablet').on('click', function () {
                toggleModal(editTabletModal.id);
            });
            $('#new-tablet').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newTablet', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullRam) {
                                            swalFire('خطا!', response.errors.nullRam[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullInternalMemory) {
                                            swalFire('خطا!', response.errors.nullInternalMemory[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSimcardsNumber) {
                                            swalFire('خطا!', response.errors.nullSimcardsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.TabletControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getTabletInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            tablet_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            ramForEdit.value = response.ram;
                            internal_memoryForEdit.value = response.internal_memory;
                            simcards_numberForEdit.value = response.simcards_number;
                        }
                    }
                });
            });
            $('#edit-tablet').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editTablet', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullRam) {
                                            swalFire('خطا!', response.errors.nullRam[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullInternalMemory) {
                                            swalFire('خطا!', response.errors.nullInternalMemory[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSimcardsNumber) {
                                            swalFire('خطا!', response.errors.nullSimcardsNumber[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveTabletControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeTabletStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/WebcamCatalog':
            resetFields();

            $('#new-webcam-button, #cancel-new-webcam').on('click', function () {
                toggleModal(newWebcamModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newWebcamModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editWebcamModal.id)
            });
            $('.WebcamControl,#cancel-edit-webcam').on('click', function () {
                toggleModal(editWebcamModal.id);
            });
            $('#new-webcam').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newWebcam', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.WebcamControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getWebcamInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            webcam_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-webcam').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editWebcam', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveWebcamControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeWebcamStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/RecorderCatalog':
            resetFields();

            $('#new-recorder-button, #cancel-new-recorder').on('click', function () {
                toggleModal(newRecorderModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newRecorderModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editRecorderModal.id)
            });
            $('.RecorderControl,#cancel-edit-recorder').on('click', function () {
                toggleModal(editRecorderModal.id);
            });
            $('#new-recorder').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newRecorder', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.RecorderControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getRecorderInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            recorder_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-recorder').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editRecorder', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveRecorderControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeRecorderStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/HeadphoneCatalog':
            resetFields();

            $('#new-headphone-button, #cancel-new-headphone').on('click', function () {
                toggleModal(newHeadphoneModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newHeadphoneModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editHeadphoneModal.id)
            });
            $('.HeadphoneControl,#cancel-edit-headphone').on('click', function () {
                toggleModal(editHeadphoneModal.id);
            });
            $('#new-headphone').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newHeadphone', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.HeadphoneControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getHeadphoneInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            headphone_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-headphone').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editHeadphone', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveHeadphoneControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeHeadphoneStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/SpeakerCatalog':
            resetFields();

            $('#new-speaker-button, #cancel-new-speaker').on('click', function () {
                toggleModal(newSpeakerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newSpeakerModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editSpeakerModal.id)
            });
            $('.SpeakerControl,#cancel-edit-speaker').on('click', function () {
                toggleModal(editSpeakerModal.id);
            });
            $('#new-speaker').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newSpeaker', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.SpeakerControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getSpeakerInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            speaker_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-speaker').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editSpeaker', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveSpeakerControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeSpeakerStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/VideoProjectorCatalog':
            resetFields();

            $('#new-videoProjector-button, #cancel-new-videoProjector').on('click', function () {
                toggleModal(newVideoProjectorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newVideoProjectorModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editVideoProjectorModal.id)
            });
            $('.VideoProjectorControl,#cancel-edit-videoProjector').on('click', function () {
                toggleModal(editVideoProjectorModal.id);
            });
            $('#new-videoProjector').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newVideoProjector', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.VideoProjectorControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getVideoProjectorInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            videoProjector_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                        }
                    }
                });
            });
            $('#edit-videoProjector').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editVideoProjector', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveVideoProjectorControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeVideoProjectorStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/VideoProjectorCurtainCatalog':
            resetFields();

            $('#new-videoProjectorCurtain-button, #cancel-new-videoProjectorCurtain').on('click', function () {
                toggleModal(newVideoProjectorCurtainModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newVideoProjectorCurtainModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editVideoProjectorCurtainModal.id)
            });
            $('.VideoProjectorCurtainControl,#cancel-edit-videoProjectorCurtain').on('click', function () {
                toggleModal(editVideoProjectorCurtainModal.id);
            });
            $('#new-videoProjectorCurtain').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(model.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newVideoProjectorCurtain', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSize) {
                                            swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.VideoProjectorCurtainControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getVideoProjectorCurtainInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            videoProjectorCurtain_id.value = response.id;
                            brandForEdit.value = response.company_id;
                            modelForEdit.value = response.model;
                            sizeForEdit.value = response.size;
                        }
                    }
                });
            });
            $('#edit-videoProjectorCurtain').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyEnglishCharacters(modelForEdit.value)) {
                    swalFire('خطا!', 'مدل اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editVideoProjectorCurtain', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullBrand) {
                                            swalFire('خطا!', response.errors.nullBrand[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullModel) {
                                            swalFire('خطا!', response.errors.nullModel[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullSize) {
                                            swalFire('خطا!', response.errors.nullSize[0], 'error', 'تلاش مجدد');
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
                }
            });
            $('.deactiveVideoProjectorCurtainControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeVideoProjectorCurtainStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;

        case '/AssistanceCatalog':
            resetFields();

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
                if (!hasOnlyPersianCharacters(name.value)) {
                    swalFire('خطا!', 'نام معاونت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newAssistance', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.AssistanceControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getAssistanceInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            assistance_id.value = response.id;
                            nameForEdit.value = response.name;
                        }
                    }
                });
            });
            $('#edit-assistance').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyPersianCharacters(nameForEdit.value)) {
                    swalFire('خطا!', 'نام معاونت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editAssistance', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeAssistanceStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/ExecutivePositionCatalog':
            resetFields();

            $('#new-executivePosition-button, #cancel-new-executivePosition').on('click', function () {
                toggleModal(newExecutivePositionModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newExecutivePositionModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.edit').on('click', function () {
                toggleModal(editExecutivePositionModal.id)
            });
            $('.ExecutivePositionControl,#cancel-edit-executivePosition').on('click', function () {
                toggleModal(editExecutivePositionModal.id);
            });
            $('#new-executivePosition').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyPersianCharacters(title.value)) {
                    swalFire('خطا!', 'نام سمت اجرایی اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newExecutivePosition', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.ExecutivePositionControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getExecutivePositionInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            executivePosition_id.value = response.id;
                            titleForEdit.value = response.title;
                        }
                    }
                });
            });
            $('#edit-executivePosition').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyPersianCharacters(titleForEdit.value)) {
                    swalFire('خطا!', 'نام سمت اجرایی اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editExecutivePosition', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.deactiveExecutivePositionControl').on('click', function () {
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'وضعیت این کاتالوگ تغییر خواهد کرد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeExecutivePositionStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/EstablishmentPlaceCatalog':
            resetFields();

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
                if (!hasOnlyPersianCharacters(title.value)) {
                    swalFire('خطا!', 'عنوان کار اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newEstablishmentPlace', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.EstablishmentPlaceControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getEstablishmentPlaceInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            establishment_place_id.value = response.id;
                            titleForEdit.value = response.title;
                        }
                    }
                });
            });
            $('#edit-establishment-place').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyPersianCharacters(titleForEdit.value)) {
                    swalFire('خطا!', 'عنوان کار اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editEstablishmentPlace', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeEstablishmentPlaceStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;
        case '/JobCatalog':
            resetFields();

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
                if (!hasOnlyPersianCharacters(title.value)) {
                    swalFire('خطا!', 'عنوان کار اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/newJob', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
            });
            $('.JobControl').on('click', function () {
                $.ajax({
                    type: 'GET', url: '/getJobInfo', data: {
                        id: $(this).data('id')
                    }, success: function (response) {
                        if (response) {
                            job_id.value = response.id;
                            titleForEdit.value = response.title;
                        }
                    }
                });
            });
            $('#edit-job').on('submit', function (e) {
                e.preventDefault();
                if (!hasOnlyPersianCharacters(titleForEdit.value)) {
                    swalFire('خطا!', 'عنوان کار اشتباه وارد شده است.', 'error', 'تلاش مجدد');
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
                                type: 'POST', url: '/editJob', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
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
                }
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
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST', url: '/ManageCatalogStatus', data: {
                                id: $(this).data('id'), work: 'ChangeJobStatus'
                            }, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                location.reload();
                            }
                        });
                    }
                });

            });
            break;

        case '/Person':
            resetFields();
            $('#new-person-button, #cancel-new-person').on('click', function () {
                toggleModal(newPersonModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.add').on('click', function () {
                toggleModal(newPersonModal.id)
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
                            type: 'POST', url: '/newPerson', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFamily) {
                                        swalFire('خطا!', response.errors.nullFamily[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.dupPersonnelCode) {
                                        swalFire('خطا!', response.errors.dupPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongNationalCode) {
                                        swalFire('خطا!', response.errors.wrongNationalCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullAssistance) {
                                        swalFire('خطا!', response.errors.nullAssistance[0], 'error', 'تلاش مجدد');
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
                            type: 'POST', url: '/editPerson', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullName) {
                                        swalFire('خطا!', response.errors.nullName[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullFamily) {
                                        swalFire('خطا!', response.errors.nullFamily[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullNationalCode) {
                                        swalFire('خطا!', response.errors.nullNationalCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullAssistance) {
                                        swalFire('خطا!', response.errors.nullAssistance[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullExecutivePosition) {
                                        swalFire('خطا!', response.errors.nullExecutivePosition[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullEstablishmentPlace) {
                                        swalFire('خطا!', response.errors.nullEstablishmentPlace[0], 'error', 'تلاش مجدد');
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

            $('.Reset').on('click', function () {
                location.reload();
            });

            break;
        case '/showEquipmentStatus':
            resetFields();

            //set all delivery date fields to now
        function setInputValue(date) {
            let inputElement = $('.deliveryDate');
            inputElement.val(date);
        }

            getJalaliDate()
                .then(function (date) {
                    setInputValue(date);
                })
                .catch(function (error) {
                    console.error("خطا در دریافت تاریخ: " + error);
                });

            //tab management scripts

            const tab1Button = document.getElementById('tab1');
            const tab2Button = document.getElementById('tab2');
            const tab3Button = document.getElementById('tab3');
            const content1 = document.getElementById('content1');
            const content2 = document.getElementById('content2');
            const content3 = document.getElementById('content3');

        function showTabContent(tabButton, tabContent) {
            content1.style.display = 'none';
            content2.style.display = 'none';
            content3.style.display = 'none';

            tabContent.style.display = 'block';

            tab1Button.classList.remove('bg-blue-600');
            tab2Button.classList.remove('bg-blue-600');
            tab3Button.classList.remove('bg-blue-600');

            tabButton.classList.add('bg-blue-600');
        }

        function saveTabState(tabIndex) {
            localStorage.setItem('selectedTab', tabIndex);
        }

        function loadTabState() {
            const selectedTab = localStorage.getItem('selectedTab');

            if (selectedTab === '1') {
                showTabContent(tab1Button, content1);
                tab1Button.classList.add('bg-blue-600');
            } else if (selectedTab === '2') {
                showTabContent(tab2Button, content2);
                tab2Button.classList.add('bg-blue-600');
            } else if (selectedTab === '3') {
                showTabContent(tab3Button, content3);
                tab3Button.classList.add('bg-blue-600');
            } else {
                showTabContent(tab1Button, content1);
                tab1Button.classList.add('bg-blue-600');
            }
        }

            tab1Button.addEventListener('click', function () {
                showTabContent(tab1Button, content1);
                saveTabState(1);
            });

            tab2Button.addEventListener('click', function () {
                showTabContent(tab2Button, content2);
                saveTabState(2);
            });

            tab3Button.addEventListener('click', function () {
                showTabContent(tab3Button, content3);
                saveTabState(3);
            });

            loadTabState();

            //end tab management scripts

            //Hardware Equipments
            $('.AddCase, #cancel-add-case').on('click', function () {
                toggleModal(addCaseModal.id);
            });
            $('#cancel-edit-case').on('click', function () {
                toggleModal(editCaseModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcase').on('click', function () {
                toggleModal(addCaseModal.id)
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.editcase').on('click', function () {
                toggleModal(editCaseModal.id)
            });
            $('#addRAM').on('click', function () {
                if (ram2Div.classList.contains('hidden')) {
                    ram2Div.classList.remove('hidden');
                } else if (ram3Div.classList.contains('hidden')) {
                    ram3Div.classList.remove('hidden');
                } else if (ram4Div.classList.contains('hidden')) {
                    ram4Div.classList.remove('hidden');
                    addRAM.classList.add('hidden');
                }
            });
            $('#addHDD').on('click', function () {
                if (hdd2Div.classList.contains('hidden')) {
                    hdd2Div.classList.remove('hidden');
                } else if (hdd3Div.classList.contains('hidden')) {
                    hdd3Div.classList.remove('hidden');
                } else if (hdd4Div.classList.contains('hidden')) {
                    hdd4Div.classList.remove('hidden');
                    addHDD.classList.add('hidden');
                }
            });
            $('#edited_addRAM').on('click', function () {
                if (edited_ram2Div.classList.contains('hidden')) {
                    edited_ram2Div.classList.remove('hidden');
                } else if (edited_ram3Div.classList.contains('hidden')) {
                    edited_ram3Div.classList.remove('hidden');
                } else if (edited_ram4Div.classList.contains('hidden')) {
                    edited_ram4Div.classList.remove('hidden');
                    edited_addRAM.classList.add('hidden');
                }
            });
            $('#edited_addHDD').on('click', function () {
                if (edited_hdd2Div.classList.contains('hidden')) {
                    edited_hdd2Div.classList.remove('hidden');
                } else if (edited_hdd3Div.classList.contains('hidden')) {
                    edited_hdd3Div.classList.remove('hidden');
                } else if (edited_hdd4Div.classList.contains('hidden')) {
                    edited_hdd4Div.classList.remove('hidden');
                    edited_addHDD.classList.add('hidden');
                }
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
                            type: 'POST', url: '/newEquipmentCase', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
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
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            $('#edit-case').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار ویرایش خواهد شد.',
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
                            url: '/editEquipment',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                console.log(response);
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
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
                                    }
                                }
                                    else if (response.success) {
                                    // swalFire('ثبت کیس جدید موفقیت آمیز بود!', response.message.caseAdded[0], 'success', 'بستن');
                                    // toggleModal(addCaseModal.id);
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

            $('.AddMonitor, #cancel-add-monitor').on('click', function () {
                toggleModal(addMonitorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addmonitor').on('click', function () {
                toggleModal(addMonitorModal.id)
            });
            $('#cancel-edit-monitor').on('click', function () {
                toggleModal(editMonitorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.editmonitor').on('click', function () {
                toggleModal(editMonitorModal.id)
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
                            type: 'POST', url: '/newEquipmentMonitor', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullMonitor) {
                                        swalFire('خطا!', response.errors.nullMonitor[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            $('#edit-monitor').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار ویرایش خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST', url: '/editEquipment', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullMonitor) {
                                        swalFire('خطا!', response.errors.nullMonitor[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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

            $('.AddPrinter, #cancel-add-printer').on('click', function () {
                toggleModal(addPrinterModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addprinter').on('click', function () {
                toggleModal(addPrinterModal.id)
            });
            $('#cancel-edit-printer').on('click', function () {
                toggleModal(editPrinterModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.editprinter').on('click', function () {
                toggleModal(editPrinterModal.id)
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
                            type: 'POST', url: '/newEquipmentPrinter', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPrinter) {
                                        swalFire('خطا!', response.errors.nullPrinter[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            $('#edit-printer').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار ویرایش خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST', url: '/editEquipment', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPrinter) {
                                        swalFire('خطا!', response.errors.nullPrinter[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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

            $('.AddScanner, #cancel-add-scanner').on('click', function () {
                toggleModal(addScannerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addscanner').on('click', function () {
                toggleModal(addScannerModal.id)
            });
            $('#cancel-edit-scanner').on('click', function () {
                toggleModal(editScannerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.editscanner').on('click', function () {
                toggleModal(editScannerModal.id)
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
                            type: 'POST', url: '/newEquipmentScanner', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullScanner) {
                                        swalFire('خطا!', response.errors.nullScanner[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            $('#edit-scanner').on('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: 'این مقدار ویرایش خواهد شد.',
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'خیر',
                    confirmButtonText: 'بله',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form = $(this);
                        var data = form.serialize();
                        $.ajax({
                            type: 'POST', url: '/editEquipment', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullScanner) {
                                        swalFire('خطا!', response.errors.nullScanner[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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

            $('.AddCopyMachine, #cancel-add-copymachine').on('click', function () {
                toggleModal(addCopyMachineModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcopymachine').on('click', function () {
                toggleModal(addCopyMachineModal.id)
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
                            type: 'POST', url: '/newEquipmentCopyMachine', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullCopyMachine) {
                                        swalFire('خطا!', response.errors.nullCopyMachine[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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

            $('.AddVOIP, #cancel-add-voip').on('click', function () {
                toggleModal(addVOIPModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addVOIP').on('click', function () {
                toggleModal(addVOIPModal.id)
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
                            type: 'POST', url: '/newEquipmentVOIP', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVOIP) {
                                        swalFire('خطا!', response.errors.nullVOIP[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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

            //Network Equipments
            $('.AddSwitch, #cancel-add-switch').on('click', function () {
                toggleModal(addSwitchModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addswitch').on('click', function () {
                toggleModal(addSwitchModal.id)
            });
            $('#new-switch').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentSwitch', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSwitch) {
                                        swalFire('خطا!', response.errors.nullSwitch[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddModem, #cancel-add-modem').on('click', function () {
                toggleModal(addModemModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addmodem').on('click', function () {
                toggleModal(addModemModal.id)
            });
            $('#new-modem').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentModem', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullModem) {
                                        swalFire('خطا!', response.errors.nullModem[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddLaptop, #cancel-add-laptop').on('click', function () {
                toggleModal(addLaptopModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addlaptop').on('click', function () {
                toggleModal(addLaptopModal.id)
            });
            $('#new-laptop').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentLaptop', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullLaptop) {
                                        swalFire('خطا!', response.errors.nullLaptop[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddMobile, #cancel-add-mobile').on('click', function () {
                toggleModal(addMobileModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addmobile').on('click', function () {
                toggleModal(addMobileModal.id)
            });
            $('#new-mobile').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentMobile', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullMobile) {
                                        swalFire('خطا!', response.errors.nullMobile[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddTablet, #cancel-add-tablet').on('click', function () {
                toggleModal(addTabletModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addtablet').on('click', function () {
                toggleModal(addTabletModal.id)
            });
            $('#new-tablet').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentTablet', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullTablet) {
                                        swalFire('خطا!', response.errors.nullTablet[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddWebcam, #cancel-add-webcam').on('click', function () {
                toggleModal(addWebcamModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addwebcam').on('click', function () {
                toggleModal(addWebcamModal.id)
            });
            $('#new-webcam').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentWebcam', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullWebcam) {
                                        swalFire('خطا!', response.errors.nullWebcam[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddRecorder, #cancel-add-recorder').on('click', function () {
                toggleModal(addRecorderModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addrecorder').on('click', function () {
                toggleModal(addRecorderModal.id)
            });
            $('#new-recorder').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentRecorder', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullRecorder) {
                                        swalFire('خطا!', response.errors.nullRecorder[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddHeadphone, #cancel-add-headphone').on('click', function () {
                toggleModal(addHeadphoneModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addheadphone').on('click', function () {
                toggleModal(addHeadphoneModal.id)
            });
            $('#new-headphone').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentHeadphone', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullHeadphone) {
                                        swalFire('خطا!', response.errors.nullHeadphone[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddSpeaker, #cancel-add-speaker').on('click', function () {
                toggleModal(addSpeakerModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addspeaker').on('click', function () {
                toggleModal(addSpeakerModal.id)
            });
            $('#new-speaker').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentSpeaker', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullSpeaker) {
                                        swalFire('خطا!', response.errors.nullSpeaker[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddVideoProjector, #cancel-add-videoprojector').on('click', function () {
                toggleModal(addVideoProjectorModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addvideoprojector').on('click', function () {
                toggleModal(addVideoProjectorModal.id)
            });
            $('#new-videoprojector').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentVideoProjector', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVideoProjector) {
                                        swalFire('خطا!', response.errors.nullVideoProjector[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })

            $('.AddVideoProjectorCurtain, #cancel-add-videoprojectorcurtain').on('click', function () {
                toggleModal(addVideoProjectorCurtainModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addvideoprojectorcurtain').on('click', function () {
                toggleModal(addVideoProjectorCurtainModal.id)
            });
            $('#new-videoprojectorcurtain').on('submit', function (e) {
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
                            type: 'POST', url: '/newEquipmentVideoProjectorCurtain', data: data, headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            }, success: function (response) {
                                if (response.errors) {
                                    if (response.errors.nullPersonnelCode) {
                                        swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullPropertyNumber) {
                                        swalFire('خطا!', response.errors.nullPropertyNumber[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nullVideoProjectorCurtain) {
                                        swalFire('خطا!', response.errors.nullVideoProjectorCurtain[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.wrongPerson) {
                                        swalFire('خطا!', response.errors.wrongPerson[0], 'error', 'تلاش مجدد');
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
            })
            break;

        case '/Works':
            $('.AddComment, #cancel-add-comment').on('click', function () {
                toggleModal(addCommentModal.id);
            });
            $('.absolute.inset-0.bg-gray-500.opacity-75.addcomment').on('click', function () {
                toggleModal(addCommentModal.id)
            });
            $('#new-comment').on('submit', function (e) {
                e.preventDefault();
                if (isNaN(ticket_number.value)) {
                    swalFire('خطا!', 'مقدار شماره تیکت اشتباه می باشد.', 'error', 'تلاش مجدد');
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
                            var idFromLink = getParameterByName('id', window.location.href);
                            data += "&person=" + idFromLink;
                            $.ajax({
                                type: 'POST', url: '/newComment', data: data, headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                }, success: function (response) {
                                    if (response.errors) {
                                        if (response.errors.nullPersonnelCode) {
                                            swalFire('خطا!', response.errors.nullPersonnelCode[0], 'error', 'تلاش مجدد');
                                        } else if (response.errors.nullDescription) {
                                            swalFire('خطا!', response.errors.nullDescription[0], 'error', 'تلاش مجدد');
                                        }
                                    } else if (response.success) {
                                        // $('table tbody').append(response.html);
                                        // CommentErr.hidden = true;
                                        // swalFire('ثبت کار جدید موفقیت آمیز بود!', 'کامنت با موفقیت اضافه شد.', 'success', 'بستن');
                                        // toggleModal(addCommentModal.id);
                                        resetFields();
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
                }
            });

            break;
        case '/ExcelAllReports':

            break;

    }
});
