<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 20.06.2019
 * Time: 12:52
 */

class IndexController extends Controller
{

    private $pageSize = 3;

    public function Index($sort = 'username',$destination = 'desc', $page = 0)
    {

        if(!intval($page))$page=0;
        if(!in_array($sort,['username','email','isClose','created_at']))$sort='username';
        if(!in_array($destination,['asc','desc']))$sort='desc';

        $allTasks = Task::orderBy($sort,$destination)->get();

        $this->view('index/index',
            [
                'isAdmin'=> isset($_SESSION["isAdmin"])?$_SESSION["isAdmin"]:false,
                'paginator'=>$this->CreatePaginator($allTasks,$sort,$destination,$page),
                'dest'=>$destination=="desc"?'asc':'desc'
            ]);
    }

    private function CreatePaginator($items,$sort,$destination,$page)
    {
        $pages=[];
        $pageCount = ceil ($items->count()/$this->pageSize);
        $paginator = [
            'pageCount'=>$pageCount,
            'currentPage'=>$page,
            'items'=>array_slice($items->toArray(), $page*$this->pageSize, $this->pageSize),
            'sort'=>$sort
        ];

        if($pageCount>1)
        {
            $pages[]=  [
                'name'=>'First',
                'url'=>'/'.$sort.'/'.$destination
            ];
            if($page>0)
            {
                $pages[]=[
                    'name'=>'Prev',
                    'url'=>'/'.$sort.'/'.$destination.'/'.($page-1)
                ];
            }

            if($page+1<$pageCount)
            {
                $pages[]=[
                    'name'=>'Next',
                    'url'=>'/'.$sort.'/'.$destination.'/'.($page+1)
                ];
            }
            $pages[]= [
                'name'=>'Last',
                'url'=>"/".$sort.'/'.$destination."/".($pageCount-1)
            ];
        }
        $paginator['pages']=$pages;
        return $paginator;
    }
}