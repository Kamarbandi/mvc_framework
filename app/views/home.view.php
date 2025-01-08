<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MVC Framework</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= ROOT ?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <link href="<?= ROOT ?>/assets/css/cover.css" rel="stylesheet">
</head>
<body class="d-flex h-100 text-center text-white bg-dark">

<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0">Mein</h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link active" aria-current="page" href="<?= ROOT ?>">Home</a>
                <a class="nav-link" href="<?= ROOT ?>/login">Login</a>
                <a class="nav-link" href="<?= ROOT ?>/logout">Logout</a>
            </nav>
        </div>
    </header>

    <main class="px-3">
        <h4>Hello, <?= $username ?></h4>
        <h1>Jus for code review.</h1>
        <p>This mini-framework, I'm still working on it, this framework is in the process of improvement.</p>
        <p>An diesem Mini-Framework arbeite ich immer noch, dieses Framework wird verbessert.</p>
    </main>

    <footer class="mt-auto text-white-50">
        <p>Footer page Test</p>
    </footer>
</div>
</body>
</html>
