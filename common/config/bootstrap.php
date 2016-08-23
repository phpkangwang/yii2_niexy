<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@imgcdn', dirname(dirname(__DIR__)) . '/frontend/web');
Yii::setAlias('cdnUrl', "http://localhost:10086/yii2_niexy/frontend/web");
