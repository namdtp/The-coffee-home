<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
    </head>
    <body>
        <table>
            <tr><td>Xin chào {{ $name }}!</td></tr>
            <tr><td>Chào mừng bạn đến với The Coffee Home. Tài khoản của bạn đã được tạo thành công với thông tin bên dưới:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Tên: {{ $name }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Số Điện Thoại: {{ $mobile }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email: {{ $email }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Cảm ơn & Trân Trọng,</td></tr>
            <tr><td>TheCoffeeHome  .</td></tr>
        </table>
    </body>
</html>