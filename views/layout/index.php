<?php
$userModel = new \models\Users();
$user = $userModel->getCurrentUser();
$year = date('Y');
?>
<!doctype html>
<html lang="ua">
<head>
    <meta charset="UTF-8">
    <title><?= $MainTitle ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">CMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/news">Новини</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/journals">Журнали</a>
                        </li>
                        <? if($userModel->isUserAuthenticated()) :?>
                            <li class="nav-item">
                                <a class="nav-link" href="/chat">Чат</a>
                            </li>
                        <? endif; ?>
                        <? if($userModel->isUserAuthenticated() && $userModel->isUserAccessIsAdmin()) :?>
                            <li class="nav-item">
                                <a class="nav-link" href="/users">Користувачі</a>
                            </li>
                        <? endif; ?>
                    </ul>
                    <? if(!$userModel->isUserAuthenticated()) :?>
                        <a class="btn btn-outline-primary" type="submit" href="/users/login">Увійти</a>
                        <a class="btn btn-outline-success" type="submit" href="/users/register">Реєстрація</a>
                    <? else : ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $user['login'] ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/users/logout">Вийти</a></li>
                            </ul>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </nav>
        <div class="container">
            <h1 class="mt-3"><?= $PageTitle ?></h1>
            <? if(!empty($MessageText)) : ?>
                <div class="alert alert-<?= $MessageClass?>" role="alert">
                    <?= $MessageText?>
                </div>
            <? endif; ?>
            <?= $PageContent ?>
        </div>
    </div>
    <footer class="bg-light mt-4">
        <div class="container p-3">© <?= $year ?> Copyright: Grozer</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <? if($userModel->isUserAuthenticated() && !($user['access'] === 'user')) : ?>
        <script src="/alien/build/ckeditor.js"></script>
        <script>
            let editors = document.querySelectorAll('.editor');
            for(let i in editors) {
                ClassicEditor
                    .create(editors[i], {

                        toolbar: {
                            items: [
                                'heading',
                                '|',
                                'bold',
                                'italic',
                                'link',
                                'bulletedList',
                                'numberedList',
                                '|',
                                'outdent',
                                'indent',
                                '|',
                                'imageUpload',
                                'blockQuote',
                                'insertTable',
                                'mediaEmbed',
                                'undo',
                                'redo',
                                'alignment',
                                'fontColor',
                                'fontSize',
                                'fontFamily',
                                'horizontalLine',
                                'imageInsert'
                            ]
                        },
                        language: 'uk',
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:full',
                                'imageStyle:side'
                            ]
                        },
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        },
                        licenseKey: '',


                    })
                    .then(editor => {
                        window.editor = editor;


                    })
                    .catch(error => {
                        console.error('Oops, something went wrong!');
                        console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                        console.warn('Build id: jt24hc9kan1y-pxirrcz3cj5d');
                        console.error(error);
                    });
            }
        </script>
    <? endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
</body>
</html>
