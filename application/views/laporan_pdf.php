<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #0e1e0e;
        color: white;
    }

    h1{
        text-align: center;
    }
    </style>
</head>

<body>

    <h1>Daftar User Aplikasi Keuangan</h1>

    <table id="customers">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Tanggal</th>
            <th>Email</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th>Level</th>
        </tr>
        <?php 
        $no = 1;
        foreach ($users as $a){
        ?>
        <tr>
            <th><?= $no++;?></th>
            <td><?= $a['username']?></td>
            <td><?= $a['tanggal_lahir']?></td>
            <td><?= $a['email']?></td>
            <td><?= $a['no_hp']?></td>
            <td><?= $a['alamat']?></td>
            <td><?= $a['level_name']?></td>
        </tr>
        <?php
        }
      ?>
    </table>

</body>

</html>