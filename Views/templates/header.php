<?php
/** @var string $title */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title><?= esc((string) $title) ?> | BINIPOS</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: #202938;
            background: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
        }

        nav {
            padding: 18px 8%;
            background: #172033;
        }

        nav a {
            display: inline-block;
            margin-right: 20px;
            color: #ffffff;
            text-decoration: none;
        }

        nav a:hover {
            color: #93c5fd;
            text-decoration: underline;
        }

        main {
            width: 84%;
            min-height: 80vh;
            margin: 40px auto;
        }

        h1 {
            margin-bottom: 10px;
            color: #172033;
        }

        h2 {
            margin-top: 30px;
            color: #172033;
        }

        p {
            line-height: 1.6;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 14px;
            border: 1px solid #dddddd;
            text-align: left;
        }

        th {
            color: #ffffff;
            background: #2563eb;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        footer {
            padding: 20px 8%;
            color: #64748b;
            background: #e2e8f0;
            text-align: center;
        }

        @media (max-width: 700px) {
            nav {
                padding: 14px 5%;
            }

            nav a {
                margin: 5px 10px 5px 0;
            }

            main {
                width: 90%;
                margin: 25px auto;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <nav aria-label="Main navigation">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/customers">Customers</a>
        <a href="/users">Users</a>
    </nav>

    <main>