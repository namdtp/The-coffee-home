<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
        <title></title>
    </head>
    <body>
        <table>
            <tr><td>Xin chào {{ $name }}!</td></tr>
            <tr><td>Bạn được yêu cầu thay đổi Mật khẩu của mình. Mật khẩu mới như sau:</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email: {{ $email }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Mật Khẩu: {{ $password }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Cảm ơn & Trân Trọng,</td></tr>
            <tr><td>The Coffee Home.</td></tr>
        </table>
    </body>
</html>