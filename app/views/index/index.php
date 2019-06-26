<html>
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
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        };

        function preView() {
            let form = $('#addForm')[0];
            $.ajax({
                url: form.action,
                type: 'POST',
                dataType: "JSON",
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function (data, status)
                {
                    console.log(data);
                    let card = $('#preViewCard');
                    card.find( ".card-header h4").first().text(data["header"]);
                    card.find('img').remove();
                    if(data["image"])
                    {
                        let img = $('<img align="center" style="max-height: 240px;max-width: 320px" src="/images/'+data['image']+'" class="card-img-top" ></img>');
                        card.find( ".card-header").first().after(img)
                    }
                    card.find( ".card-body h6").first().text(data["username"]+" ("+data["email"]+")");
                    card.find( ".card-body .card-text").first().text(data["text"]);
                    $('#preViewModal').modal('show')
                }
            });
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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Сортировка
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/username/<?php echo $data['dest']?>">По имени пользователя</a>
                    <a class="dropdown-item" href="/email/<?php echo $data['dest']?>">По email</a>
                    <a class="dropdown-item" href="/isClose/<?php echo $data['dest']?>">По статусу</a>
                    <a class="dropdown-item" href="/created_at/<?php echo $data['dest']?>">По дате добавления</a>
                </div>
            </li>
        </ul>
        <a class="nav-link btn btn-primary" href="#" data-toggle="modal" data-target="#addNewTaskModal">
           Добавить задачу
        </a>
        <?php if(!$data['isAdmin']){?>
        <form class="nav-link form-inline my-2 my-lg-0" action="/User/Login" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="username" name="username" aria-label="username">
            <input class="form-control mr-sm-2" type="password" placeholder="password" name="password" aria-label="username">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
        </form>
        <?php }else{?>
            <a class="nav-link btn btn-primary" href="/User/Logout">Выйти</a>
        <?php }?>
    </div>
</nav>


<div class="container-fluid">
    <?php  foreach ($data['paginator']['items'] as $task){?>
    <div class="card text-center mb-5">
        <div class="card-header">
            <h4><?php echo $task['header']?></h4>
        </div>
        <?php if (!is_null($task['image'])){?>
            <img align="center" style="max-height: 240px;max-width: 320px" src="/images/<?php echo $task['image']?>" class="card-img-top" alt="...">
        <?php }?>

        <div class="card-body">

            <h6>
                <?php echo $task['username'].' ('.$task['email'].')'?>
            </h6>
            <p class="card-text">
                <?php echo $task['text']?>
            </p>
            <p><?php if($task['isClose']){echo 'Задание закрыто';}else {echo 'Задание открыто';}?></p>
            <p>Дата создания <?php echo $task['created_at'];?></p>
            <p>Дата последнего изменения <?php echo $task['updated_at'];?></p>

            <?php if($data['isAdmin'] && !$task['isClose']){?>
            <a href="/Task/edit/<?php echo $task['id']?>" class="btn btn-primary">Редактировать</a>
            <a href="/Task/close/<?php echo $task['id']?>" class="btn btn-primary">Закрыть</a>
            <?php }?>

        </div>
    </div>
    <?php } ?>
    <nav>
        <ul class="pagination  justify-content-center align-bottom">
            <?php foreach ($data['paginator']['pages'] as $page){
                echo "<li class='page-item'><a class='page-link' href='{$page['url']}'>{$page['name']}</a></li>";
            }?>
        </ul>
    </nav>
</div>

<div class="modal fade" id="addNewTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавить задачу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="addForm" action="/Task/add" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row mb-2">
                  <div class="col">
                      <input type="text" placeholder="Username" name="username" required class="form-control">
                  </div>
              </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" placeholder="Email" name="email" id="emailField" required class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <input type="text" placeholder="Header" name="header" required class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <textarea placeholder="Description" name="textTask" required class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image">
                            <label class="custom-file-label" for="inputGroupFile01">Фото</label>
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-secondary" onclick="preView()">Предпросмотр</button>
                <button type="submit" class="btn btn-primary" onclick="return validEmail('emailField')">Сохранить</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="preViewModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card text-center mb-5" id="preViewCard">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body">
                    <h6>
                    </h6>
                    <p class="card-text">
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>