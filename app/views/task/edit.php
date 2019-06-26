<html lang="ru">
<head>
    <title>Задачник</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">
    <script src="/js/jquery-3.3.1.slim.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <style>
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }
    </style>

    <script type="text/javascript">
        let validEmail = function (elementId) {
            let field = $('#'+elementId);
            if(!validateEmail(field.val()))
            {
                field.css("color", "red");
                return false;
            }
        };
        function validateEmail(email) {
            let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        };

        function clearImage(btn)
        {
            $(btn).remove();
            $('img').remove();
            $('#imageName').val(null);
        }
    </script>

</head>
<body style="background-color: #faffd9">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная страница <span class="sr-only"></span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid">
    <form method="post" id="addForm" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row mb-2">
                <div class="col">
                    <input type="text" placeholder="Username" id="username" name="username" value="<?php echo $data['task']['username']?>" required class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <input type="text" placeholder="Email" name="email" id="emailField"  value="<?php echo $data['task']['email']?>" required class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <input type="text" placeholder="Header" name="header" id="header" value="<?php echo $data['task']['header']?>" required class="form-control">
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <textarea placeholder="Description" name="textTask" id="textTask" required class="form-control"> <?php echo $data['task']['text']?></textarea>
                </div>
            </div>
            <div class="row mb-2">
                <?php if (!is_null($data['task']['image'])){?>
                    <img align="center" style="max-height: 240px;max-width: 320px" src="/images/<?php echo $data['task']['image']?>" class="card-img-top" alt="...">
                <?php }?>
            </div>
            <input type="hidden" name="imageName" id="imageName" value="<?php echo $data['task']['image']?>">
            <div class="row mb-2">
                <div class="col">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image">
                            <label class="custom-file-label">Новое изображение</label>
                        </div>
                        <?php if (!is_null($data['task']['image'])){?>
                        <div class="input-group-append">
                            <input type="button" onclick="clearImage(this)" class="btn btn-outline-primary" value="Удалить изображение">
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="return validEmail('emailField')">Сохранить</button>
            </div>
    </form>
    </div>
</body>
</html>