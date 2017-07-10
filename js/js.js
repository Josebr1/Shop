/**
 * Created by jose on 6/3/17.
 */


$(document).ready(function () {
    $('select').material_select();
});

//
function reload() {
    location.reload();
}

function validarSelect() {
    if (document.statusform.status.options[status.selectedIndex].value == "") {
        alert("Escolha um status");
        document.statusform.status.focus();
        return false;
    }
    return true;
}

function deleteCategory(id) {
    $.ajax({
        type: "DELETE",
        url: "http://localhost:8000/category/" + id,
        success: function (msg) {
            alert(msg);
            window.location = 'list-category.php';
        },
        statusCode: {
            404: function () {
                //alert("404");
            },
            500: function () {
                // alert("500");
            }
        },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("Não é possivel excluir categoria, existem produtos associados a ela.");
        }
    });
}

function deleteProduct(id) {
    $.ajax({
        type: "DELETE",
        url: "http://localhost:8000/product/" + id,
        success: function (msg) {
            alert(msg);
            window.location = 'list-products.php';
        },
        statusCode: {
            404: function () {
                //alert("404");
            },
            500: function () {
                // alert("500");
            }
        },
        error: function (xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("Não é possivel excluir produto, existem pedido associados a ela.");
        }
    });
}

//Validaçao de comparaçao das senhas
$("#password").on("focusout", function (e) {
    if ($(this).val() != $("#passwordRefresh").val()) {
        $("#passwordRefresh").removeClass("valid").addClass("invalid");
    } else {
        $("#passwordRefresh").removeClass("invalid").addClass("valid");
    }
});

$("#passwordRefresh").on("keyup", function (e) {
    if ($("#password").val() != $(this).val()) {
        $(this).removeClass("valid").addClass("invalid");
    } else {
        $(this).removeClass("invalid").addClass("valid");
    }
});



