<html>
    <body>
        <h1>Hola Nuevo Usuario {{$email}}, Bienvenido a la API de Prueba :)</h1>
        <h3>Para continuar con tu registro <br>
        es necesario dar click en el siguiente enlace;
        </h3>
        <a href="{{url('refister/verify/'. $confirmationCode)}}"></a>
    </body>
</html>