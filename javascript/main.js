$(window).load(function(){
    setTimeout(function(){
        $('#loading').addClass("oculto");
    }, 400);
    
    (function () {
        /*==========INICIO DE SESIÓN==============*/
        $('#boton-menu').click(function(){
            $('.contenido-form').toggleClass('visible');
            $('#boton-menu').toggleClass('visible');
            if($('.contenido-form').hasClass('visible')){
                $('.contenido-form #email').focus();
            }
        });

        $('#btLogin2').click(function(){
            $('.contenido-form').toggleClass('visible');
            $('#boton-menu').toggleClass('visible');
        });

        $('#form-login').submit(function (event) {
            event.preventDefault();
            var email = $('#email').val();
            var clave = $('#clave').val();
            if(isEmail(email) && isClave(clave)){
                var parametros = {
                    email: email,
                    clave: clave,
                };
                //validar formulario
                $.ajax({
                    url: 'ajax/ajaxlogin.php',
                    data: parametros,
                    type: 'post',
                    beforesend: function () {
                        $('#btLogin').text("Cargando...");
                    },
                    success: function (response) {
                        if(response > 0){
                            window.location = "index.php";
                        }else{
                            $('.contenido-form').find('span.lg-error').text('El email o la contraseña no son correctas.');
                        }
                    },
                    error: function (xhr, status) {
                        alert('Disculpe, se ha producido un error un problema' + xhr + status);
                    },
                });
            }else{
                $('.contenido-form').find('span.lg-error').text('Debe introducir un email y una contraseña.');
            }
        });

        $('#btLogout').on('click', function () {
            $.ajax({
                url: 'ajax/ajaxlogout.php',
                type: 'post',
                beforesend: function () {
                    $('#btSalir').text("Cargando...");
                },
                success: function (response) {
                    if (response === '0') {
                        window.location = "login.php";
                    }
                },
                error: function (xhr, status) {
                    alert('Disculpe, existió un problema' + xhr + status);
                },
            });
        });

    /*VALIDAR FORMULARIO REGISTRO*/
        $('#nombre').on('blur', function(){
            if(!isNombre($(this).val())){
                $(this).next().text('Introduzca su nombre');
            }else{
                $(this).next().text('');
            }
        });

        $('#apellidos').on('blur', function(){
            if(!isApellidos($(this).val())){
                $(this).next().text('Introduzca sus apellidos');
            }else{
                $(this).next().text('');
            }
        });

        $('#emailReg').blur(function(){
            if(!isEmail($(this).val())){
                $(this).next().text('Email no válido');
            }else{
                $(this).next().text('');
            }
        });

        $('#claveReg').on('blur', function(){
            if(!isClave($(this).val())){
                $(this).next().text('Contraseña no válida');
            }else{
                $(this).next().text('');
            }
            if($('#claveR').val() != ''){
                if(!isIgual($(this).val(), $('#claveR').val())){
                    $(".lg-error.e2").text('Las contraseñas no coinciden');
                }else{
                    $(".lg-error.e2").text('');
                }
            }
        });

        $('#claveR').on('blur', function(){
            if(!isClave($(this).val())){
                $(this).next().text('Contraseña no válida');
            }else{
                $(this).next().text('');
            }
            if($('#claveReg').val() != ''){
                if(!isIgual($(this).val(), $('#claveReg').val())){
                    $(".lg-error.e2").text('Las contraseñas no coinciden');
                }else{
                    $(".lg-error.e2").text('');
                }
            }
        });

        $('#btRegistro').click(function(){
            var nombre = $('#nombre').val();
            var apellidos = $('#apellidos').val();
            var email = $('#emailReg').val();
            var clave = $('#claveReg').val();
            var claveR = $('#claveR').val();
            var terminos = $('#terminos');
            if(isNombre(nombre) && isApellidos(apellidos) && isEmail(email) && isClave(clave) && isClave(claveR) && isIgual(clave, claveR) && isChecked(terminos)){
                //peticion ajax!!!!!
                var parametros = {
                    nombre: nombre,
                    apellidos: apellidos,
                    email: email,
                    clave: clave,
                    claveR: claveR,
                    terminos: terminos.val()
                };
                //validar formulario
                    $.ajax({
                        url: 'ajax/ajaxregistro.php',
                        data: parametros,
                        type: 'post',
                        beforesend: function () {
                            $('#btRegistro').text("Cargando...");
                        },
                        success: function (response) {
                            if(response != ""){
                                $('.form-grupo.submit').find('.mensaje').text("Usuario creado con éxito");
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 2000);
                            }else{
                                $('.form-grupo.submit').find('.mensaje').text("No se ha podido crear el usuario");
                            }
                        },
                        error: function (xhr, status) {
                            alert('Disculpe, existió un problema' + xhr + status);
                        },
                    });

            }else{
                alert("nada bien");
            }
        });

    /*subir archivos*/
        $('#upload').on('click', function() {
            var file_data = $('#archivo1').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);                           
            $.ajax({
                url: 'ajax/ajaxrecibe.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(response){
                    alert(response);
                    if(response == 0){
                        $('#mensaje').append('<span>Archivos subidos.</span>'); // display response from the PHP script, if any
                    }else{
                        $('#mensaje').append('<span>Se ha producido algún error.</span>');
                    }
                }
            });
        });
    
        /*Ajustes físicos*/
        $('#btGuardar').on('click', function(){
            var nombre = $('#nombre').val();
            var apellidos = $('#apellidos').val();
            var sexo = $('input:radio[name=sexo]:checked').val();
            var dia = $('#select-dia option:selected').val();
            var mes = $('#select-mes option:selected').val();
            var ano = $('#select-ano option:selected').val();
            var altura = $('#altura').val();
            var peso = $('#peso').val();
            var fcmax = $('#fcmax').val();
            var fcrep = $('#fcrep').val();
            var email = $('#emailReg').val(); 

            var parametros = {
                nombre: nombre,
                apellidos: apellidos,
                sexo: sexo,
                dia: dia,
                mes: mes,
                ano: ano,
                altura: altura,
                peso: peso,
                fcmax: fcmax,
                fcrep: fcrep,
                email: email
            };
            $.ajax({
                url: 'ajax/ajaxajustes.php',
                data: parametros,
                type: 'post',
                beforesend: function () {
                    $('#btGuardar').text("Cargando...");
                },
                success: function (response) {
                    if(response != "" && response != "00"){
                        setTimeout(function() {
                            window.location.href = "ajustes.php";
                        }, 10);
                    }else{
                        setTimeout(function() {
                            window.location.href = "ajustes.php?error=guardar";
                        }, 10);
                    }
                },
                error: function (xhr, status) {
                    alert('Disculpe, existiÃ³ un problema' + xhr + status);
                },
            });
        });
        
        $('#btCancelar').on('click', function(){
            window.location = "index.php";
        });

    })();
    
    
});






/*FUNCIONES DE VALIDACIÓN*/
function isNombre(nombre){
    nombre = $.trim(nombre);
    if(nombre.length > 1){
        return true;
    }
    return false;
}
function isApellidos(apellidos){
    apellidos = $.trim(apellidos);
    if(apellidos.length > 1){
        return true;
    }
    return false;
}
function isEmail(email){
    email = $.trim(email);
    var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    return pattern.test(email);
}
function isClave(clave){
    clave = $.trim(clave);
    if(clave.length > 5){
        return true;
    }
    return false;
}
function isIgual(clave1, clave2){
    if(clave1 === clave2){
        return true;
    }
    return false;
}

function isChecked(checkbox){
    if(checkbox.is(':checked')){
        return true;
    }
    return false;
}



