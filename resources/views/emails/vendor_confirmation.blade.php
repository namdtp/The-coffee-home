<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
    <tr><td>Xin chào {{ $name }}!</td><tr>
    <tr><td>&nbsp;<br /></td><tr>
    <tr><td>Vui lòng nhấp vào liên kết bên dưới để xác nhận Tài Khoản nhà cung cấp của bạn.</td><tr>
    <tr><td><a href="{{ url('vendor/confirm/'.$code) }}">{{ url('vendor/confirm/'.$code) }}</a></td><tr>
    <tr><td>&nbsp;<br /></td><tr>
    <tr><td>Cảm ơn & Trân Trọng,</td><tr>
    <tr><td>&nbsp;<br /></td><tr>
    <tr><td>Azalea Clothing</td><tr>
</body>

</html>