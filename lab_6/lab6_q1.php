<!DOCTYPE html>
<html lang="en">
<head>
 Usr: <title>Lab 6 Q1</title>
</head>
<body>
    <?php
        $name = "Nurzahirah Binti Muhamad  Ahwan";
        $matricNumber = "CI230100";
        $course = "Multimedia Computing";
        $year = "Year 2 Sem 2";
        $address = "31,Jln Cuepacs 4b Tmn Koperasi Cuepacs Bt12 Cheras,43000 Kajang Selangor";
    ?>
    <table>
        <tr><td>Name</td><td><?php echo $name; ?></td></tr>
        <tr><td>Matric Number</td><td><?php echo $matricNumber; ?></td></tr>
        <tr><td>Course</td><td><?php echo $course; ?></td></tr>
        <tr><td>Year of Study</td><td><?php echo $year; ?></td></tr>
        <tr><td>Address</td><td><?php echo $address; ?></td></tr>
    </table>
</body>
</html>