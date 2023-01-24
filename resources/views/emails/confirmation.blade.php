<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
    </head>
    <body>
        <table>
            <tr><td>Xin chào {{ $name }} !</td></tr>
            <tr><td>Vui lòng nhấp vào liên kết bên dưới để kích hoạt Tài Khoản TheCoffeeHome của bạn:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><a href="{{ url('/user/confirm/'.$code) }}">Xác Nhận Tài Khoản</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Cảm ơn & Trân Trọng,</td></tr>
            <tr><td>TheCoffeeHome.</td></tr>
        </table>
    </body>
</html>