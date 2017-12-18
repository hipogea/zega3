<?php $this->pageTitle=Yii::app()->name; ?>

<h4 align="center">Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h4>
<h2>You have to pay attention to:</h2>
<ul>
    <li>configure db connection string in you &laquo;config/main.php&raquo; file</li>
    <li>append in &laquo;config/main.php&raquo; file
<pre>
'modules'=>array(
      'cal'=>array(
           'debug'=>true,            <i>create tables, need for first run only!</i>
           'layout'=>'column2',      <i>optional, not required</i>
        ),
</pre>
</li>
    <li>modify function <i>renderContent()</i> in &laquo;cal/components/ChangeUser.php&raquo;
        to check admin privileges and create users list in you own way.
    </li>
    <li>default calendar options in &laquo;cal/CalModule.php&raquo;</li>
    <li>updating list of sms-gate in &laquo;cal/controller/CronController.php&raquo;</li>
    <li>creating new translation under folder &laquo;cal/messages&raquo;</li>
</ul>

<h2>See event-based calendar in action:</h2>
<ul>
    <li>
        <a href="<?php echo $this->createUrl('/cal', array('layout' => 'column1')); ?>">
            Single column layout
        </a>
    </li>
    <li>
        <a href="<?php echo $this->createUrl('/cal', array('layout' => 'column2')); ?>">
            Two column layout
        </a>
    </li>
</ul>

<h2>Simple cron</h2>
<p>Check all events for all users from &laquo;now&raquo; to &laquo;now+cronPeriod&raquo;
and send alert via e-mail or/and sms.
<br>Call &laquo;<a href="<?php echo $this->createUrl('/cal/cron'); ?>">CronController</a>&raquo;
every &laquo;cronPeriod&raquo; minutes.
</p>