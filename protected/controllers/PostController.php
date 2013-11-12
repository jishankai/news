 <?php

class PostController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLatestPosts()
    {
        $latest = Yii::app()->db->createCommand("SELECT id, title, outline, created_at, updated_at, author, category, price, (SELECT COUNT(*) FROM images i WHERE i.post_id=p.id) AS images_count, thumbnail, free FROM posts p WHERE publish=1 ORDER BY id DESC LIMIT 20")->queryAll();
        foreach ($latest as $key=>$value) {
            if (!empty($value['thumbnail'])) {
                $latest[$key]['thumbnail'] = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/thumb/'.$value['thumbnail'];
            } else {
                $latest[$key]['thumbnail'] = '';
            }
        }
        $this->echoJson($latest);
    }

    public function actionPosts($id=NULL)
    {
        if (isset($id)) {
            Yii::app()->theme = 'mobile';
            $post = Yii::app()->db->createCommand("SELECT * FROM posts WHERE id=$id")->queryRow();
            $this->render('posts', array('post'=>$post));
        } else {
            $posts = Yii::app()->db->createCommand("SELECT  id, title, outline, created_at, updated_at, author, category, price, (SELECT COUNT(*) FROM images i WHERE i.post_id=p.id) AS images_count, thumbnail, free FROM posts p")->queryAll();
            foreach ($posts as $key=>$value) {
                if (!empty($value['thumbnail'])) {
                    $posts[$key]['thumbnail'] = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/thumb/'.$value['thumbnail'];
                }
            }
            $this->echoJson($posts);
        }
    }

    public function actionPrevious($id)
    {
        $previous = Yii::app()->db->createCommand("SELECT  id, title, outline, created_at, updated_at, author, category, price, (SELECT COUNT(*) FROM images i WHERE i.post_id=p.id) AS images_count, thumbnail, free FROM posts p WHERE id<$id and publish!=0 ORDER BY id DESC LIMIT 20")->queryAll();
        foreach ($previous as $key=>$value) {
            if (!empty($value['thumbnail'])) {
                $previous[$key]['thumbnail'] = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/thumb/'.$value['thumbnail'];
            }
        }
        $this->echoJson($previous);
    }

    public function actionImage($id) {
        $image =  Yii::app()->db->createCommand("SELECT id, file, post_id FROM images WHERE post_id=$id")->queryRow();
        $image['url'] = Yii::app()->request->hostInfo.Yii::app()->baseUrl.'/images/thumb/'.$image['post_id'].'_'.$image['file'];
        $this->echoJson($image);
        /*
        $file = Yii::app()->basePath.'/../images/thumb/'.$image['post_id'].'_'.$image['file'];
        if (file_exists($file)) {
            $content = file_get_contents($file);
            $content = utf8_encode($content);
            echo $content;
        } else {
            $this->echoJson(array());
        }
        */
    }
    // Uncomment the following methods and override them if needed
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'checkSig',
        );
    }
    /*
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
