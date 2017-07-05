/**
 * Created by jose on 6/3/17.
 */

$(document).ready(function () {
    // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
    $('.modal').modal();
});


$(document).ready(function () {
    $('.tooltipped').tooltip({delay: 50});
});

function saveCatgory() {
    $.post();
}

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

$("#formValidate").validate({
    rules: {
        formemail: {
            required: true,
            email:true
        }
    },
    //For custom messages
    messages: {
        uname:{
            required: "Enter a username",
            minlength: "Enter at least 5 characters"
        },
        curl: "Enter your website",
    },
    errorElement : 'div',
    /*errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    }*/
});

$(document).ready(function(){
    $('#phone').mask('(00) 0000-00009');
});

$(document).ready(function(){
    $('#phone').mask('(00) 0000-0000'); //Telefone
});


