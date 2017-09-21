var url = "../Controlador/Registro_Empresa_Controlador.php";
$(document).ready(function () {
    $(".fecha").datepicker();
    $(".fecha").val(fechaActual());
});
function crearRestaurante()
{
    var nombres = $("#nombres").val().trim().toLowerCase();
    var razonsocial = $("input[name=razonsocial]").val().trim().toLowerCase();
    var nombrer = $("input[name=nombre]").val().trim().toLowerCase();
    var regional = $("#regionaloption:selected").val();
    var nit = $("input[name=nit]").val();
    var direccions = $("input[name=direccions]").val();
    var direccionp = $("input[name=direccionp]").val();
    var fechacontratado=$("input[name=fechacontratado]").val();
    var cuenta = $("input[name=cuenta]").val();
    var rol = $("#rol option:selected").text();
    var sueldo = $("input[name=sueldo]").val();
    var nombrep = $("#nombrep").val().trim().toLowerCase();
    var telefono = $("input[name=telefono]").val();
    var password=$("#password").val();
    var rpassword=$("#rpassword").val();
    var logo = $("#logo").attr('src');
    var text = "";

    if (!validar("vacio", nombrer))
    {
        text += "<p>el campo nombre no puede estar vacio</p>";
    }
    if (!validar("texto", nombrer))
    {
        text += "<p>por favor instrodusca su nombre correctamente</p>";
    }
    if (!validar("vacio", nombrep))
    {
        text += "<p>el campo nombre del personal no puede estar vacio</p>";
    }
    if (!validar("texto", nombrep))
    {
        text += "<p>por favor instrodusca el nombre del personal correctamente</p>";
    }
    if (!validar("vacio", razonsocial))
    {
        text += "<p>el campo razon social no debe estar vacio</p>";
    }
    if (!validar("texto", razonsocial))
    {
        text += "<p>por favor instroduzca su direccion correctamente, no estan permitidos los carateres especiales</p>";
    }
      if (!validar("vacio", nombres))
    {
        text += "<p>el campo nombre en el registro de sucursal no puede estar vacio</p>";
    }
    if (!validar("texto", nombres))
    {
        text += "<p>por favor instrodusca su nombre correctamente</p>";
    }
    if (!validar("entero", nit))
    {
        text += "<p>por favor instrodusca su nit correctamente</p>";
    }
    if (!validar("vacio", nit))
    {
        text += "<p>el campo NIT no puede estar vacio</p>";
    }
    if (!validar("texto y entero", direccions))
    {
        text += "<p>por favor instrodusca su direccion correctamente</p>";
    }
    if (!validar("vacio", direccions))
    {
        text += "<p>el campo direccion en el registro sucursal no puede quedar vacio</p>";
    }
    if (!validar("texto y entero", direccionp))
    {
        text += "<p>por favor instrodusca la direccion del personal correctamente</p>";
    }
    if (!validar("vacio", direccionp))
    {
        text += "<p>el campo direccion en el registro personal no puede quedar vacio</p>";
    }
    if (!validar("vacio", regional))
    {
        text += "<p>debe de seleccionar una regional</p>";
    }
   if (!validar("texto y entero", cuenta))
    {
        text += "<p>por favor instroduzca su cuenta correctamente</p>";
    }
   if (!validar("vacio", cuenta))
    {
        text += "<p>el campo cuenta no puede quedar vacio</p>";
    }
   if (!validar("entero", sueldo))
    {
        text += "<p>por favor introduzca el sueldo correctamente</p>";
    }   
   if (!validar("entero", telefono))
    {
        text += "<p>por favor introduzca el sueldo correctamente</p>";
    }   
    if ($('#password').val().length < 4 || $('#rpassword').val().length > 8)
    {
        text += "<p>el password tiene que tener mayor a 4  y menor a 8 caracteres</p>";
    }

    if (text.length > 0) {
        $("body").msmOK(text);
        return;
    }
    $("#cargando").visible();
    $.post(url, {proceso: 'insertarRestaurante', nombrep: nombrep.toLocaleLowerCase(), razonsocial: razonsocial,
        logo: logo, nombrer:nombrer.toLocaleString(),regional:regional,nombres:nombres,nit:nit,direccions:direccions,
    direccionp:direccionp,cuenta:cuenta,sueldo:sueldo,rol:rol,fechacontratado:fechacontratado,telefono:telefono,password:password,rpassword:rpassword}, function (response) {
        $("#cargando").ocultar();
        var json = $.parseJSON(response);
        if (json.error !== "") {
            $("body").msmOK(json.error);
        } else {

        }
    });
}

