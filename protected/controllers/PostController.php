 <?php

class PostController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLatestPosts()
    {
        $latest = Yii::app()->db->createCommand("SELECT * FROM posts ORDER BY id DESC LIMIT 20")->queryAll();
        $this->echoJson($latest);
    }

    public function actionPosts($id=NULL)
    {
        if (isset($id)) {
            Yii::app()->theme = 'mobile';
            $this->render('posts');
        } else {
            $posts = Yii::app()->db->createCommand("SELECT * FROM posts")->queryAll();
            $this->echoJson($posts);
        }
    }

    public function actionPrevious($id)
    {
        $previous = Yii::app()->db->createCommand("SELECT * FROM posts WHERE id<$id ORDER BY id DESC LIMIT 20")->queryAll();
        $this->echoJson($previous);
    }

    public function actionCreate()
    {
        $model=new Post;

        if(isset($_POST['ajax']) && $_POST['ajax']==='post-create-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Post']))
        {
            $model->attributes=$_POST['Post'];
            if($model->validate())
            {
                // form inputs are valid, do something here
                return;
            }
        }
        $this->render('create',array('model'=>$model));
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
     */
}
