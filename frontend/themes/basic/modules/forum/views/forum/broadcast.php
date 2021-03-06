<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */
/* @var $model app\modules\forum\models\Broadcast */

$this->title = $model->forum_name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->forum_name]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->forum_desc]);
$this->params['forum'] = $model->toArray;
?>

<div class="col-xs-12 col-sm-8 col-md-8">
    <?php if ($model->user_id === Yii::$app->user->id) : ?>
        <?= $this->render('/broadcast/_form', ['model' => $newBroadcast]) ?>
    <?php endif; ?>
    <div class="widget-container">
        <?php if ($model->broadcastCount >= 1): ?>
            <div class="thread-list">
                <?php foreach ($model->broadcasts['result'] as $broadcast): ?>
                    <div class="thread-item" id="div<?= $broadcast['id']; ?>">
                        <div class="media">
                            <div class="media-body">
                                <div class="media-heading">
                                    <div class="pull-left">
                                        <h3 class="media-title"
                                            style="margin: 0;"><?= Html::encode($broadcast['title']) ?></h3>
                                    </div>
                                    <div class="pull-right">
                                        <?php if ($model->user_id == Yii::$app->user->id) : ?>
                                            <a href="<?= Url::toRoute(['/forum/broadcast/update', 'id' => $broadcast['id']]) ?>">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="<?= Url::toRoute(['/forum/broadcast/delete', 'id' => $broadcast['id']]) ?>"
                                               data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>"
                                               data-method="broadcast">
                                                <span class="glyphicon glyphicon-remove-circle"></span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="clearfix"></div>
                                    <span style="color: #aaa; font-size: 12px;">
                                        <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($broadcast['created_at']) ?>
                                    </span>
                                </div>
                                <div class="media-content">
                                    <?php echo $broadcast['content']; ?>
                                </div>
                                <div class="thread-time"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?= InfiniteScrollPager::widget([
                'pagination' => $model->broadcasts['pages'],
                'widgetId' => '.thread-list',
            ]); ?>
        <?php else: ?>
            <div class="widget-container">
                <div style="padding:50px">
                    <h1><?= Yii::t('app', 'No data to display.') ?></h1>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-4">
    <?= \app\widgets\login\Login::widget([
        'title' => Yii::t('app', 'Log in'),
        'visible' => Yii::$app->user->isGuest
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">About</div>
        <div class="panel-body">
            <?= Html::encode($model->forum_desc) ?>
        </div>
    </div>
</div>
