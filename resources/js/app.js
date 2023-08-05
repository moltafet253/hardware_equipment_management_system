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

$(document).ready(function () {
    //Get The Current Date And Time
    if (window.location.pathname !== '/login' && window.location.pathname !== '/') {
        // $.ajax({
        //     type: 'GET',
        //     url: '/date',
        //     success: function (response) {
        //         headerTime.innerText = "امروز: " + response;
        //     },
        //     error: function (xhr, textStatus, errorThrown) {
        //         console.log(xhr);
        //     }
        // });
    }

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

    //Car Catalog
    $('#catalog-car').submit(function (e) {
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
                var url = form.attr('action');
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            swalFire('عملیات موفقیت آمیز بود!', response.message.carAdded[0], 'success', 'بستن');
                        } else {
                            if (response.errors.nameIsNull) {
                                swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                            } else if (response.errors.repeatedName) {
                                swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                            } else {
                                location.reload();
                            }
                        }
                    }
                });
            }
        });

    });

    //Search In Car Catalog
    if (window.location.pathname === '/Cars') {
        $('#search-car-catalog-code, #search-car-catalog-name').on('input', function () {
            var codeValue = $('#search-car-catalog-code').val();
            var nameValue = $('#search-car-catalog-name').val();
            $.ajax({
                url: '/Search',
                type: 'GET',
                data: {
                    code: codeValue,
                    name: nameValue,
                    work: 'CarCatalogSearch'
                },
                success: function (data) {
                    var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                    tableBody.empty();

                    data.forEach(function (car) {
                        var row = '<tr class="bg-white"><td class="px-6 py-4">' + car.CarCode + '</td><td class="px-6 py-4">' + car.CarName + '</td></tr>';
                        tableBody.append(row);
                    });
                },
                error: function () {
                    console.log('خطا در ارتباط با سرور');
                }
            });
        });
    }

    //Search In Organization Catalog
    $('#search-org-catalog-code, #search-org-catalog-name').on('input', function () {
        var codeValue = $('#search-org-catalog-code').val();
        var nameValue = $('#search-org-catalog-name').val();
        $.ajax({
            url: '/Search',
            type: 'GET',
            data: {
                code: codeValue,
                name: nameValue,
                work: 'OrgCatalogSearch'
            },
            success: function (data) {
                var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                tableBody.empty();

                data.forEach(function (org) {
                    var row = '<tr class="bg-white"><td class="px-6 py-4">' + org.OrgCode + '</td><td class="px-6 py-4">' + org.OrgName + '</td></tr>';
                    tableBody.append(row);
                });
            },
            error: function () {
                console.log('خطا در ارتباط با سرور');
            }
        });
    });

    //Search In Weighbridge Catalog
    $('#search-wb-catalog-code, #search-wb-catalog-name').on('input', function () {
        var codeValue = $('#search-wb-catalog-code').val();
        var nameValue = $('#search-wb-catalog-name').val();
        $.ajax({
            url: '/Search',
            type: 'GET',
            data: {
                code: codeValue,
                name: nameValue,
                work: 'WBCatalogSearch'
            },
            success: function (data) {
                var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                tableBody.empty();

                data.forEach(function (wb) {
                    var row = '<tr class="bg-white"><td class="px-6 py-4">' + wb.WBCode + '</td><td class="px-6 py-4">' + wb.WBName + '</td></tr>';
                    tableBody.append(row);
                });
            },
            error: function () {
                console.log('خطا در ارتباط با سرور');
            }
        });
    });

    //Search In Contractor Catalog
    $('#search-contractor-catalog-code, #search-contractor-catalog-name').on('input', function () {
        var codeValue = $('#search-contractor-catalog-code').val();
        var nameValue = $('#search-contractor-catalog-name').val();
        $.ajax({
            url: '/Search',
            type: 'GET',
            data: {
                code: codeValue,
                name: nameValue,
                work: 'ContractorCatalogSearch'
            },
            success: function (data) {
                var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                tableBody.empty();

                data.forEach(function (contractor) {
                    var row = '<tr class="bg-white"><td class="px-6 py-4">' + contractor.ContCode + '</td><td class="px-6 py-4">' + contractor.ContName + '</td></tr>';
                    tableBody.append(row);
                });
            },
            error: function () {
                console.log('خطا در ارتباط با سرور');
            }
        });
    });


    //Search In Tariffs Catalog
    if (window.location.pathname === '/Tariffs') {
        $('#search-tariff-catalog-code, #search-car-catalog-code,  #search-load-catalog-code,  #search-tariff-catalog-price').on('input', function () {
            var tariffCode = $('#search-tariff-catalog-code').val();
            var carCode = $('#search-car-catalog-code').val();
            var loadCode = $('#search-load-catalog-code').val();
            var tariffPrice = $('#search-tariff-catalog-price').val();
            $.ajax({
                url: '/Search',
                type: 'GET',
                data: {
                    tariffCode: tariffCode,
                    carCode: carCode,
                    loadCode: loadCode,
                    tariffPrice: tariffPrice,
                    work: 'TariffCatalogSearch'
                },
                success: function (data) {
                    console.log(data);
                    var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                    tableBody.empty();
                    data.forEach(function (tariff) {
                        var row = '<tr class="bg-white"><td class="px-6 py-4">' + tariff.TariffCode + '</td>' + '<td class="px-6 py-4">' + tariff.CarCode + '</td>' + '<td class="px-6 py-4">' + tariff.cars.CarName + '</td>' + '<td class="px-6 py-4">' + tariff.LoadCode + '</td>' + '<td class="px-6 py-4">' + tariff.loads.LoadName + '</td>' + '<td class="px-6 py-4">' + tariff.tariff + '</td>' + '</tr>';
                        tableBody.append(row);
                    });
                },
                error: function () {
                    console.log('خطا در ارتباط با سرور');
                }
            });
        });
    }

    //Search In Load Catalog
    if (window.location.pathname === '/Loads') {
        $('#search-load-catalog-code, #search-load-catalog-name').on('input', function () {
            var codeValue = $('#search-load-catalog-code').val();
            var nameValue = $('#search-load-catalog-name').val();
            $.ajax({
                url: '/Search',
                type: 'GET',
                data: {
                    code: codeValue,
                    name: nameValue,
                    work: 'LoadCatalogSearch'
                },
                success: function (data) {
                    var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                    tableBody.empty();

                    data.forEach(function (load) {
                        var row = '<tr class="bg-white"><td class="px-6 py-4">' + load.LoadCode + '</td><td class="px-6 py-4">' + load.LoadName + '</td></tr>';
                        tableBody.append(row);
                    });
                },
                error: function () {
                    console.log('خطا در ارتباط با سرور');
                }
            });
        });
    }

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
                        case 5:
                            type = 'سازمان';
                            break;
                        case 6:
                            type = 'باسکول';
                            break;
                    }
                    var row = '<tr class="bg-white"><td class="px-6 py-4">' + user.id + '</td><td class="px-6 py-4">' + user.name + '</td><td class="px-6 py-4">' + type + '</td>';
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
                        case 5:
                            type = 'سازمان';
                            break;
                        case 6:
                            type = 'باسکول';
                            break;
                    }
                    var row = '<tr class="bg-white"><td class="px-6 py-4">' + user.id + '</td><td class="px-6 py-4">' + user.name + '</td><td class="px-6 py-4">' + type + '</td>';
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

    $('#new-contractor-button, #cancel-new-contractor').on('click', function () {
        toggleModal(newContractorModal.id);
    });

    $('#edit-contractor-button, #cancel-edit-contractor').on('click', function () {
        toggleModal(editContractorModal.id);
    });

    //New User
    $('#new-user').submit(function (e) {
        e.preventDefault();
        var name = document.getElementById('name').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var repeat_password = document.getElementById('repeat-password').value;
        var type = document.getElementById('type').value;

        if (name.length === 0) {
            swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
        } else if (!hasOnlyPersianCharacters(name)) {
            swalFire('خطا!', 'نام نمی تواند مقدار غیر از کاراکتر فارسی یا عدد داشته باشد.', 'error', 'تلاش مجدد');
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
                        name = '';
                        toggleModal(newUserModal.id);
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
        var type = editedType.value;

        if (name.length === 0) {
            swalFire('خطا!', 'نام وارد نشده است.', 'error', 'تلاش مجدد');
        } else if (!hasOnlyPersianCharacters(name)) {
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
                    }

                }
            });
        }
    });

    //New Organization
    $('#catalog-org').submit(function (e) {
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
                var url = form.attr('action');
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (response) {
                        if (response.length >= 2 && response[1]) {
                            var orgData = response[1];
                            if ('orgCode' in orgData && 'orgName' in orgData) {
                                var newRow = '<tr class="bg-white"><td class="px-6 py-4">' + orgData.orgCode + '</td><td class="px-6 py-4">' + orgData.orgName + '</td></tr>';
                                $('#org-table-body').append(newRow);
                                swalFire('عملیات موفقیت آمیز بود!', response[0].original.message.orgAdded[0], 'success', 'بستن');
                                document.getElementById('name').value = '';
                            }
                        } else if (response.errors.nameIsNull) {
                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.repeatedName[0]) {
                            swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                        }
                    },
                });
            }
        });
    });

    //New Weighbridge
    $('#catalog-weighbridge').submit(function (e) {
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
                var url = form.attr('action');
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (response) {
                        if (response.length >= 2 && response[1]) {
                            var weighbridgeData = response[1];
                            if ('weighbridgeCode' in weighbridgeData && 'weighbridgeName' in weighbridgeData) {
                                var newRow = '<tr class="bg-white"><td class="px-6 py-4">' + weighbridgeData.weighbridgeCode + '</td><td class="px-6 py-4">' + weighbridgeData.weighbridgeName + '</td></tr>';
                                $('#weighbridge-table-body').append(newRow);
                                swalFire('عملیات موفقیت آمیز بود!', response[0].original.message.weighbridgeAdded[0], 'success', 'بستن');
                                document.getElementById('name').value = '';
                            }
                        } else if (response.errors.nameIsNull) {
                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.repeatedName[0]) {
                            swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                        }
                    },
                });
            }
        });
    });

    //New Load
    $('#catalog-load').submit(function (e) {
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
                var url = form.attr('action');
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (response) {
                        if (response.length >= 2 && response[1]) {
                            var loadData = response[1];
                            if ('loadCode' in loadData && 'loadName' in loadData) {
                                var newRow = '<tr class="bg-white"><td class="px-6 py-4">' + loadData.loadCode + '</td><td class="px-6 py-4">' + loadData.loadName + '</td></tr>';
                                $('#load-table-body').append(newRow);
                                swalFire('عملیات موفقیت آمیز بود!', response[0].original.message.loadAdded[0], 'success', 'بستن');
                                document.getElementById('name').value = '';
                            }
                        } else if (response.errors.nameIsNull) {
                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.repeatedName[0]) {
                            swalFire('خطا!', response.errors.repeatedName[0], 'error', 'تلاش مجدد');
                        }
                    },
                });
            }
        });
    });

    //New Tariff
    $('#catalog-tariff').submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: 'این مقدار به صورت دائمی برای تمامی خودروها و انواع بار تعریف خواهد شد.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'خیر',
            confirmButtonText: 'بله',
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(this);
                var url = form.attr('action');
                var data = form.serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    success: function (response) {
                        if (response.success && response.message.tariffAdded) {
                            swalFire('عملیات موفقیت آمیز بود!', response.message.tariffAdded[0], 'success', 'بستن');
                            document.getElementById('price').value = '';
                        } else if (response.errors.priceIsNull) {
                            swalFire('خطا!', response.errors.priceIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.priceIsNotNumeric) {
                            swalFire('خطا!', response.errors.priceIsNotNumeric[0], 'error', 'تلاش مجدد');
                        }
                    },
                });
            }
        });
    });

    //New Contractor
    $('#new-contractor').submit(function (e) {
        e.preventDefault();
        var name = document.getElementById('name').value;
        var m_name = document.getElementById('m-name').value;
        var m_family = document.getElementById('m-family').value;
        var m_phone = document.getElementById('m-phone').value;
        var m_mobile = document.getElementById('m-mobile').value;
        var e_name = document.getElementById('e-name').value;
        var e_family = document.getElementById('e-family').value;
        var e_phone = document.getElementById('e-phone').value;
        var e_mobile = document.getElementById('e-mobile').value;
        var phone = document.getElementById('phone').value;

        if (isNaN(m_phone)) {
            swalFire('خطا!', 'تلفن ثابت مدیر اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (isNaN(m_mobile)) {
            swalFire('خطا!', 'تلفن همراه مدیر اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (isNaN(e_phone)) {
            swalFire('خطا!', 'تلفن ثابت کارشناس وارد شده است.', 'error', 'تلاش مجدد');
        } else if (isNaN(e_mobile)) {
            swalFire('خطا!', 'تلفن همراه کارشناس اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (isNaN(phone)) {
            swalFire('خطا!', 'تلفن ثابت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (hasNumber(m_name)) {
            swalFire('خطا!', 'نام مدیر اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (hasNumber(m_family)) {
            swalFire('خطا!', 'نام خانوادگی مدیر اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (hasNumber(e_name)) {
            swalFire('خطا!', 'نام کارشناس اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else if (hasNumber(e_family)) {
            swalFire('خطا!', 'نام خانوادگی کارشناس اشتباه وارد شده است.', 'error', 'تلاش مجدد');
        } else {
            var form = $(this);
            var data = form.serialize();

            $.ajax({
                type: 'POST',
                url: '/NewContractor',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (!response[1]) {
                        if (response.errors.nameIsNull) {
                            swalFire('خطا!', response.errors.nameIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_nameIsNull) {
                            swalFire('خطا!', response.errors.m_nameIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_familyIsNull) {
                            swalFire('خطا!', response.errors.m_familyIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_phoneIsNull) {
                            swalFire('خطا!', response.errors.m_phoneIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_mobileIsNull) {
                            swalFire('خطا!', response.errors.m_mobileIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_phoneIsNull) {
                            swalFire('خطا!', response.errors.m_phoneIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.e_familyIsNull) {
                            swalFire('خطا!', response.errors.e_familyIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.e_phoneIsNull) {
                            swalFire('خطا!', response.errors.e_phoneIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.e_mobileIsNull) {
                            swalFire('خطا!', response.errors.e_mobileIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.addressIsNull) {
                            swalFire('خطا!', response.errors.addressIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.phoneIsNull) {
                            swalFire('خطا!', response.errors.phoneIsNull[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.phoneIsWrong) {
                            swalFire('خطا!', response.errors.phoneIsWrong[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_phoneIsWrong) {
                            swalFire('خطا!', response.errors.m_phoneIsWrong[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.m_mobileIsWrong) {
                            swalFire('خطا!', response.errors.m_mobileIsWrong[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.e_phoneIsWrong) {
                            swalFire('خطا!', response.errors.e_phoneIsWrong[0], 'error', 'تلاش مجدد');
                        } else if (response.errors.e_mobileIsWrong) {
                            swalFire('خطا!', response.errors.e_mobileIsWrong[0], 'error', 'تلاش مجدد');
                        }
                    } else if (response.length >= 2 && response[1]) {
                        var contData = response[1];
                        if ('contCode' in contData && 'contName' in contData) {
                            swalFire('عملیات موفقیت آمیز بود!', response[0].original.message.contractorAdded[0], 'success', 'بستن');
                            const inputs = document.querySelectorAll('input');
                            inputs.forEach(input => input.value = null);
                            const textareas = document.querySelectorAll('textarea');
                            inputs.forEach(input => textareas.value = null);
                            var newRow = '<tr class="bg-white"><td class="px-6 py-4">' + contData.contCode + '</td><td class="px-6 py-4">' + contData.contName + '</td></tr>';
                            $('#cont-table-body').append(newRow);
                            toggleModal(newContractorModal.id);
                        }
                    } else {
                        location.reload();
                    }
                }
            });
        }
    });

    if (window.location.pathname === '/Riders') {
        async function getCarInfo(CarCode) {
            try {
                const response = await $.ajax({
                    url: '/getCarInfo',
                    type: 'GET',
                    data: {
                        CarCode: CarCode
                    },
                });
                return response;
            } catch (error) {
                console.log('خطا در دریافت اطلاعات ماشین با کد: ' + CarCode);
                throw error;
            }
        }

        async function getContractorInfo(ContCode) {
            try {
                const response = await $.ajax({
                    url: '/getContractorInfo',
                    type: 'GET',
                    data: {
                        ContCode: ContCode
                    },
                });
                return response;
            } catch (error) {
                console.log('خطا در دریافت اطلاعات پیمانکار با کد: ' + ContCode);
                throw error;
            }
        }

        async function updateTableData() {
            var codeValue = $('#search-rider-catalog-code').val();
            var nameValue = $('#search-rider-catalog-name').val();
            var familyValue = $('#search-rider-catalog-family').val();
            var contValue = $('#search-rider-catalog-cont').val();

            try {
                const data = await $.ajax({
                    url: '/Search',
                    type: 'GET',
                    data: {
                        code: codeValue,
                        name: nameValue,
                        family: familyValue,
                        cont: contValue,
                        work: 'RiderCatalogSearch'
                    },
                });

                var tableBody = $('.w-full.border-collapse.rounded-lg.overflow-hidden.text-center tbody');
                tableBody.empty();

                for (const rider of data) {
                    try {
                        const [carInfoResponse, contInfoResponse] = await Promise.all([
                            getCarInfo(rider.CarCode),
                            getContractorInfo(rider.ContCode)
                        ]);

                        var row = '<tr class="bg-white">' +
                            '<td class="px-6 py-4">' + rider.nationalCode + '</td>' +
                            '<td class="px-6 py-4">' + rider.Name + ' ' + rider.Family + '</td>' +
                            '<td class="px-6 py-4">' + carInfoResponse + '</td>' +
                            '<td class="px-6 py-4">' + contInfoResponse + '</td>' +
                            '<td class="px-6 py-4">' +
                            '<button type="button" data-nationalcode="' + rider.nationalCode + '" ' +
                            'class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 editriderbutton">' +
                            'جزئیات و ویرایش' +
                            '</button>' +
                            '</td>' +
                            '</tr>';

                        tableBody.append(row);
                    } catch (error) {
                        console.log('خطا در ارتباط با سرور');
                    }
                }

            } catch (error) {
                console.log('خطا در ارتباط با سرور');
            }
        }


        $('#search-rider-catalog-code, #search-rider-catalog-name, #search-rider-catalog-family').on('input', updateTableData);
        $('#search-rider-catalog-cont').on('change', updateTableData);

        //Toggle Modals
        $('#new-rider-button, #cancel-new-rider, .outer-modal-new').on('click', function () {
            toggleModal(newRiderModal.id);
        });

        $('#cancel-edit-rider, .outer-modal-edit').on('click', function () {
            toggleModal(editRiderModal.id);
        });

        //New Rider
        $('#new-rider').submit(function (e) {
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
                    if (!isNaN(Name.value)) {
                        swalFire('خطا!', 'نام راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(Family.value)) {
                        swalFire('خطا!', 'نام خانوادگی راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(FatherName.value)) {
                        swalFire('خطا!', 'نام پدر راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(IdentifyCode.value)) {
                        swalFire('خطا!', 'شماره شناسنامه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(nationalCode.value)) {
                        swalFire('خطا!', 'کد ملی اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(BirthPlace.value)) {
                        swalFire('خطا!', 'محل صدور اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(Phone.value)) {
                        swalFire('خطا!', 'شماره ثابت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(Mobile.value)) {
                        swalFire('خطا!', 'شماره همراه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else {
                        var formData = new FormData();
                        var serializedData = $(this).serializeArray();
                        $.each(serializedData, function (index, item) {
                            formData.append(item.name, item.value);
                        });
                        var files = $("#new-rider input[type='file']");
                        $.each(files, function (index, fileInput) {
                            var file = fileInput.files[0];
                            formData.append(fileInput.name, file);
                        });
                        $.ajax({
                            type: 'POST',
                            url: '/NewRider',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (!response[1]) {
                                    if (response.errors.nationalCodeIsFounded) {
                                        swalFire('خطا!', response.errors.nationalCodeIsFounded[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.NameIsNull) {
                                        swalFire('خطا!', response.errors.NameIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.FamilyIsNull) {
                                        swalFire('خطا!', response.errors.FamilyIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.FatherNameIsNull) {
                                        swalFire('خطا!', response.errors.FatherNameIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.IdentifyCodeIsNull) {
                                        swalFire('خطا!', response.errors.IdentifyCodeIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.nationalCodeIsNull) {
                                        swalFire('خطا!', response.errors.nationalCodeIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.BirthPlaceIsNull) {
                                        swalFire('خطا!', response.errors.BirthPlaceIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.Birthdate3IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate3IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.Birthdate2IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate2IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.Birthdate1IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate1IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.PhoneIsNull) {
                                        swalFire('خطا!', response.errors.PhoneIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.MobileIsNull) {
                                        swalFire('خطا!', response.errors.MobileIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.AddressIsNull) {
                                        swalFire('خطا!', response.errors.AddressIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseTypeIsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseTypeIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseSerialIsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseSerialIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseIssuanceDate3IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate3IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseIssuanceDate2IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate2IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseIssuanceDate1IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate1IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseExpirationDate3IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate3IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseExpirationDate2IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate2IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarLicenseExpirationDate1IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate1IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarTypeIsNull) {
                                        swalFire('خطا!', response.errors.CarTypeIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarModelIsNull) {
                                        swalFire('خطا!', response.errors.CarModelIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.License_Plate_P1IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P1IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.License_Plate_P2IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P2IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.License_Plate_P3IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P3IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.License_Plate_P4IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P4IsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarMotorCodeIsNull) {
                                        swalFire('خطا!', response.errors.CarMotorCodeIsNull[0], 'error', 'تلاش مجدد');

                                    } else if (response.errors.CarChassisNumberIsNull) {
                                        swalFire('خطا!', response.errors.CarChassisNumberIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.phoneIsWrong) {
                                        swalFire('خطا!', response.errors.phoneIsWrong[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.mobileIsWrong) {
                                        swalFire('خطا!', response.errors.mobileIsWrong[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nationalCodeIsWrong) {
                                        swalFire('خطا!', response.errors.nationalCodeIsWrong[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.length >= 2 && response[1]) {
                                    var contData = response[1];
                                    if ('Name' in contData && 'Family' in contData && 'nationalCode' in contData && 'ContCode' in contData) {
                                        swalFire('عملیات موفقیت آمیز بود!', response[0].original.message.riderAdded[0], 'success', 'بستن');
                                        const inputs = document.querySelectorAll('input');
                                        inputs.forEach(input => input.value = null);
                                        const textareas = document.querySelectorAll('textarea');
                                        inputs.forEach(input => textareas.value = null);
                                        const selects = document.querySelectorAll('select');
                                        inputs.forEach(input => selects.value = null);
                                        var newRow = '<tr class="bg-white"><td class="px-6 py-4">' + contData.nationalCode + '</td>' + '<td class="px-6 py-4">' + contData.Name + '</td>' + '<td class="px-6 py-4">' + contData.Family + '</td>' + '<td class="px-6 py-4">' + contData.ContCode + '</td>' + '</tr>';
                                        $('#rider-table-body').append(newRow);
                                        toggleModal(newRiderModal.id);
                                    }
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    }
                }
            });

        });

        //Edit Rider
        $(document).on('click', '.editriderbutton', function (e) {
            var nationalCode = $(this).data('nationalcode');
            $.ajax({
                url: '/getRiderInfo',
                type: 'GET',
                data: {
                    nationalCode: nationalCode
                },
                success: function (response) {
                    var headline = document.getElementById('modal-edit-headline');
                    headline.innerText = 'ویرایش راننده با کد ' + response.nationalCode;
                    NameForEdit.value = response.Name;
                    FamilyForEdit.value = response.Family;
                    FatherNameForEdit.value = response.FatherName;
                    IdentifyCodeForEdit.value = response.IdentifyCode;
                    BirthPlaceForEdit.value = response.BirthPlace;
                    var BirthDate = response.Birthdate.split('/');
                    Birthdate1ForEdit.value = BirthDate[2];
                    Birthdate2ForEdit.value = BirthDate[1];
                    Birthdate3ForEdit.value = BirthDate[0];
                    PhoneForEdit.value = response.Phone;
                    MobileForEdit.value = response.Mobile;
                    AddressForEdit.value = response.Address;
                    contractorSelectForEdit.value = response.ContCode;
                    CarLicenseTypeForEdit.value = response.CarLicenseType;
                    CarLicenseSerialForEdit.value = response.CarLicenseSerial;
                    var CarLicenseIssuanceDate = response.CarLicenseIssuanceDate.split('/');
                    CarLicenseIssuanceDate1ForEdit.value = CarLicenseIssuanceDate[2];
                    CarLicenseIssuanceDate2ForEdit.value = CarLicenseIssuanceDate[1];
                    CarLicenseIssuanceDate3ForEdit.value = CarLicenseIssuanceDate[0];
                    var CarLicenseExpirationDate = response.CarLicenseExpirationDate.split('/');
                    CarLicenseExpirationDate1ForEdit.value = CarLicenseExpirationDate[2];
                    CarLicenseExpirationDate2ForEdit.value = CarLicenseExpirationDate[1];
                    CarLicenseExpirationDate3ForEdit.value = CarLicenseExpirationDate[0];
                    carTypeSelectForEdit.value = response.CarCode;
                    CarModelForEdit.value = response.CarModel;
                    License_Plate_P4ForEdit.value = response.License_Plate_P4;
                    License_Plate_P3ForEdit.value = response.License_Plate_P3;
                    License_Plate_P2ForEdit.value = response.License_Plate_P2;
                    License_Plate_P1ForEdit.value = response.License_Plate_P1;
                    CarMotorCodeForEdit.value = response.CarMotorCode;
                    CarChassisNumberForEdit.value = response.CarChassisNumber;
                    nationalcode.value = response.nationalCode;
                    toggleModal(editRiderModal.id);
                },
                error: function (error) {
                    console.error('Error fetching carTypes:', error);
                }
            });
        });

        $('#edit-rider').submit(function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: 'راننده انتخابی ویرایش خواهد شد.',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'خیر',
                confirmButtonText: 'بله',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (!isNaN(NameForEdit.value)) {
                        swalFire('خطا!', 'نام راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(FamilyForEdit.value)) {
                        swalFire('خطا!', 'نام خانوادگی راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(FatherNameForEdit.value)) {
                        swalFire('خطا!', 'نام پدر راننده اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(IdentifyCodeForEdit.value)) {
                        swalFire('خطا!', 'شماره شناسنامه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (!nationalcode.value) {
                        swalFire('خطا!', 'خطا در کد ملی.', 'error', 'تلاش مجدد');
                    } else if (!isNaN(BirthPlaceForEdit.value)) {
                        swalFire('خطا!', 'محل صدور اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(PhoneForEdit.value)) {
                        swalFire('خطا!', 'شماره ثابت اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else if (isNaN(MobileForEdit.value)) {
                        swalFire('خطا!', 'شماره همراه اشتباه وارد شده است.', 'error', 'تلاش مجدد');
                    } else {
                        var formData = new FormData();
                        var serializedData = $(this).serializeArray();
                        $.each(serializedData, function (index, item) {
                            formData.append(item.name, item.value);
                        });
                        var files = $("#edit-rider input[type='file']");
                        $.each(files, function (index, fileInput) {
                            var file = fileInput.files[0];
                            formData.append(fileInput.name, file);
                        });
                        $.ajax({
                            type: 'POST',
                            url: '/EditRider',
                            data: formData,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response.errors) {
                                    if (response.errors.NameIsNull) {
                                        swalFire('خطا!', response.errors.NameIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.FamilyIsNull) {
                                        swalFire('خطا!', response.errors.FamilyIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.FatherNameIsNull) {
                                        swalFire('خطا!', response.errors.FatherNameIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.IdentifyCodeIsNull) {
                                        swalFire('خطا!', response.errors.IdentifyCodeIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nationalCodeIsNull) {
                                        swalFire('خطا!', response.errors.nationalCodeIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.BirthPlaceIsNull) {
                                        swalFire('خطا!', response.errors.BirthPlaceIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.Birthdate3IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate3IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.Birthdate2IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate2IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.Birthdate1IsNull) {
                                        swalFire('خطا!', response.errors.Birthdate1IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.PhoneIsNull) {
                                        swalFire('خطا!', response.errors.PhoneIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.MobileIsNull) {
                                        swalFire('خطا!', response.errors.MobileIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.AddressIsNull) {
                                        swalFire('خطا!', response.errors.AddressIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseTypeIsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseTypeIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseSerialIsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseSerialIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseIssuanceDate3IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate3IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseIssuanceDate2IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate2IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseIssuanceDate1IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseIssuanceDate1IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseExpirationDate3IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate3IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseExpirationDate2IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate2IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarLicenseExpirationDate1IsNull) {
                                        swalFire('خطا!', response.errors.CarLicenseExpirationDate1IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarTypeIsNull) {
                                        swalFire('خطا!', response.errors.CarTypeIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarModelIsNull) {
                                        swalFire('خطا!', response.errors.CarModelIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.License_Plate_P1IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P1IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.License_Plate_P2IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P2IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.License_Plate_P3IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P3IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.License_Plate_P4IsNull) {
                                        swalFire('خطا!', response.errors.License_Plate_P4IsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarMotorCodeIsNull) {
                                        swalFire('خطا!', response.errors.CarMotorCodeIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.CarChassisNumberIsNull) {
                                        swalFire('خطا!', response.errors.CarChassisNumberIsNull[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.phoneIsWrong) {
                                        swalFire('خطا!', response.errors.phoneIsWrong[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.mobileIsWrong) {
                                        swalFire('خطا!', response.errors.mobileIsWrong[0], 'error', 'تلاش مجدد');
                                    } else if (response.errors.nationalCodeIsWrong) {
                                        swalFire('خطا!', response.errors.nationalCodeIsWrong[0], 'error', 'تلاش مجدد');
                                    }
                                } else if (response.message.riderEdited) {
                                    swalFire('عملیات موفقیت آمیز بود!', response.message.riderEdited[0], 'success', 'بستن');
                                    const inputs = document.querySelectorAll('input');
                                    inputs.forEach(input => input.value = null);
                                    const textareas = document.querySelectorAll('textarea');
                                    inputs.forEach(input => textareas.value = null);
                                    const selects = document.querySelectorAll('select');
                                    inputs.forEach(input => selects.value = null);
                                    toggleModal(editRiderModal.id);
                                } else {
                                    location.reload();
                                }
                            }
                        });
                    }
                }
            });

        });

    }
});
