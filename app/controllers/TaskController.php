<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 21.06.2019
 * Time: 9:38
 */

class TaskController extends Controller
{

    private $uploadDir = 'images/';

    public function Index()
    {
        header('Location: /');
    }

    public function Add()
    {
        if($this->app->isAJAX && $this->app->isPost)
        {
            $username='';
            if(isset($_POST['username']))
            {
                $username = $_POST["username"];
            }
            $text='';
            if(isset($_POST["textTask"]))
            {
                $text = $_POST["textTask"];
            }
            $header='';
            if(isset($_POST["header"]))
            {
                $header = $_POST["header"];
            }
            $email='';
            if(isset($_POST["email"]))
            {
                $email = $_POST["email"];
            }
            $image = $this->SaveFile();


            header('Content-Type: application/json');
           echo json_encode([
               'username'=> $username,
               'text'=> $text,
               'header'=> $header,
               'email'=> $email,
               'image'=>$image
           ]);
        }
        elseif($this->app->isPost)
        {
            $username = $_POST["username"];
            $text = $_POST["textTask"];
            $header = $_POST["header"];
            $email = $_POST["email"];
            $image = $this->SaveFile();
            Task::create([
                'username'=> trim($username),
                'text'=> trim($text),
                'header'=> trim($header),
                'email'=> trim($email),
                'image'=>$image
            ]);
            header('Location: /');
        }
    }

    private function SaveFile()
    {
        if(count($_FILES)==0)return null;
        $name = $_FILES["image"]["name"];
        $fileNameParts = explode(".", $name);
        $ext = end($fileNameParts);
        $fileName = uniqid().'.'.$ext;
        $uploadFileName = $this->uploadDir .$fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFileName)) {
            $img = $this->ImageCreateFromFile($uploadFileName);
            if($img)
            {
                $img = imagescale($img,320,240,IMG_BILINEAR_FIXED );
                if(imagejpeg ( $img , $uploadFileName))
                {
                    return $fileName;
                }
            }
        }
        return null;
    }

    private function ImageCreateFromFile( $filename ) {
        if (!file_exists($filename)) {
            throw new InvalidArgumentException('File "'.$filename.'" not found.');
        }
        switch ( strtolower( pathinfo( $filename, PATHINFO_EXTENSION ))) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($filename);
                break;

            case 'png':
                return imagecreatefrompng($filename);
                break;

            case 'gif':
                return imagecreatefromgif($filename);
                break;

            default:
                return null;
                break;
        }
    }

    public function Close($idTask=-1)
    {
        if(isset($_SESSION['isAdmin'])&& $_SESSION['isAdmin'])
        {
            Task::find($idTask)->update(['isClose'=>1]);
            header('Location: /');
        }
    }

    public function Edit($idTask=-1)
    {
        if($idTask==-1||!intval($idTask))
        {
            header('Location: /');
        }
        if(isset($_SESSION['isAdmin'])&& $_SESSION['isAdmin'])
        {
            if($this->app->isPost)
            {
                $username = $_POST["username"];
                $text = $_POST["textTask"];
                $header = $_POST["header"];
                $email = $_POST["email"];
                $imageName = $_POST["imageName"];
                $image = $this->SaveFile();
                if($image==null)
                {
                    if(!empty($imageName))
                    {
                        $image=$imageName;
                    }
                }

                Task::find($idTask)->update([
                    'username'=> trim($username),
                    'text'=> trim($text),
                    'header'=> trim($header),
                    'email'=> trim($email),
                    'image'=>$image
                ]);
                $task = Task::find($idTask);
                $this->view('task/edit',[
                    'task'=>$task
                ]);
            }
            else
            {
                $task = Task::find($idTask);
                $this->view('task/edit',[
                    'task'=>$task
                ]);
            }
        }
        else
        {
            header('Location: /');
        }
    }
}