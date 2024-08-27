// Chart Js
function fetchAndRenderChart(route, idElement, chartType) {
    fetch(route)
        .then(response => response.json())
        .then(json => {
            new Chart(document.getElementById(idElement), {
                type: chartType,
                data: {
                    labels: json.labels,
                    datasets: json.datasets,
                },
                options: {
                    borderWidth: 0,
                    pointStyle: 'rectRounded',
                    datasets: {
                        bar: {
                          barThickness: 25, // ضبط عرض الشريط
                        },
                      },
                    scales: {
                        x: {
                            stacked: true, // يمكنك تغيير هذا بناءً على احتياجاتك
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // إذا كنت ترغب في ضبط قيم المحور Y
                            },
                            grid: {
                                display: false, // إخفاء شبكة المحور Y إذا لزم الأمر
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true, // إظهار الأسطورة إذا لزم الأمر
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    // يمكنك تخصيص شكل التلميحات هنا
                                    return context.dataset.label + ': ' + context.raw;
                                }
                            }
                        }
                    },
                    elements: {
                        bar: {
                            borderWidth: 1, // سمك الحدود إذا كان مطلوبًا
                            borderRadius: 5, // نصف قطر الزوايا
                            barThickness: 20, // عرض العمود (يمكنك تغييره حسب الحاجة)
                            maxBarThickness: 30 // أقصى عرض للعمود
                        }
                    }
                }
            });
        });
}
// ==============================================
document.addEventListener("DOMContentLoaded", function() {
    const body = document.body;
    const navToggle = document.querySelector('.nav-toggle');

    // استرجاع حالة القائمة من localStorage وتطبيقها على <body>
    const isMenuCollapsed = localStorage.getItem('menu-collapsed');

    // إذا كانت قيمة القائمة محفوظة في localStorage، قم بتطبيقها
    if (isMenuCollapsed === 'false') {
        body.classList.remove('menu-collapsed');
    }

    // إضافة مستمع للضغط على زر القائمة
    navToggle.addEventListener('click', function() {
        // التبديل بين إضافة/إزالة الكلاس "menu-collapsed"
        body.classList.toggle('menu-collapsed');

        // تحديث الحالة في localStorage بناءً على وجود الكلاس
        localStorage.setItem('menu-collapsed', body.classList.contains('menu-collapsed'));
    });
});
// ==============================================
// Save Data
function addData(method, storeUrl, formData, formId, reload) {
    axios({
        method: method,
        url: storeUrl,
        data: formData
    })
        .then(function (response) {
            toastr.success(response.data.message);
            $(formId).trigger("reset");
            $(reload).DataTable().ajax.reload();
            // window.setTimeout(function() {
            //     window.location.href = to_route
            // }, 500)
        })
        .catch(function (error) {
            seeting_toastr()
            var message = (error.response.status === 422) ?
                Object.values(error.response.data.errors)[0][0] : error.response.data.message;
            toastr.error(message);
        });
}
// ==============================================
//Fetch Data
function fetchData(url, callback) {
    let editUrl = url;
    axios.get(editUrl)
        .then(function (response) {
            // console.log(response);
            callback(response.data);
        });
}
// ==============================================
// Delete Row
function deleteRow(deleteUrl, to_route, reload) {
    Swal.fire({
        title: 'هل أنت واثق؟',
        text: "لن تتمكن من التراجع عن هذا!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'نعم ، احذفها!',
        cancelButtonText: 'إلغاء',
    })
        .then((result) => {
            if (result.isConfirmed) {
                axios.delete(deleteUrl)
                    .then(function (response) {
                        showMessage(response.data);
                        $(reload).DataTable().ajax.reload();
                        window.setTimeout(function () {
                            window.location.href = to_route
                        }, 500)
                    })
                    .catch(function (error) {
                        showMessage(error.response.data);
                    });
            }
        });
}
// ==============
function showMessage(data) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    Toast.fire({
        icon: data.icon,
        title: data.title,
    })
}
// ==============
function seeting_toastr() {
    toastr.options = {
        "closeButton": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-left",
        "preventDuplicates": true,
        "onclick": null,
    };
}
// ==============================================

// ==============================================
