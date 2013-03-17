<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <a class="brand" >Nissen Idea - <?php echo Yii::app()->params['engine']; ?></a>
          
          <div class="nav-collapse">
			<?php 
                if ('Lotofacil' == Yii::app()->params['engine']) {
                    $items = array(
                            /*array('label'=>'Dashboard', 'url'=>array('/site/index')),*/
                            array('label'=>'Engine', 'url'=>array('/lf_combinationEngine/index')),
                            array('label'=>'Combinations', 'url'=>array('/lf_combinationSet/admin')),
                            array('label'=>'Drawn', 'url'=>array('/lf_combinationDrawn/admin')),
                            array('label'=>'Users', 'url'=>array('/user/admin')),
                            array('label'=>'Settings <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'items'=>array(
                                array('label'=>'System', 'url'=>array('/systemOptions/index')),
                                array('label'=>'Engine', 'url'=>array('/engineSettings/index')),
                            )),
                            array('label'=>'Systems <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'items'=>array(
                                array('label'=>'Mega Sena', 'url'=>array('/combinationEngine/index')),
                                array('label'=>'Lotto Facil', 'url'=>array('/lf_combinationEngine/index')),
                            )),
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                        );
                } else {
                    $items = array(
                            /*array('label'=>'Dashboard', 'url'=>array('/site/index')),*/
                            array('label'=>'Engine', 'url'=>array('/combinationEngine/index')),
                            array('label'=>'Combinations', 'url'=>array('/combinationSet/admin')),
                            array('label'=>'Drawn', 'url'=>array('/combinationDrawn/admin')),
                            array('label'=>'Users', 'url'=>array('/user/admin')),
                            /*array('label'=>'Graphs & Charts', 'url'=>array('/site/page', 'view'=>'graphs')),
                            array('label'=>'Forms', 'url'=>array('/site/page', 'view'=>'forms')),
                            array('label'=>'Tables', 'url'=>array('/site/page', 'view'=>'tables')),
                            array('label'=>'Interface', 'url'=>array('/site/page', 'view'=>'interface')),
                            array('label'=>'Typography', 'url'=>array('/site/page', 'view'=>'typography')),*/
                            /*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/
                            array('label'=>'Settings <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'items'=>array(
                                array('label'=>'System', 'url'=>array('/systemOptions/index')),
                                array('label'=>'Engine', 'url'=>array('/engineSettings/index')),
                            )),
                            array('label'=>'Systems <span class="caret"></span>', 'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 
                            'items'=>array(
                                array('label'=>'Mega Sena', 'url'=>array('/combinationEngine/index')),
                                array('label'=>'Lotto Facil', 'url'=>array('/lf_combinationEngine/index')),
                            )),
                            array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                            array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                        );
                }
                $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=> $items,
                )); ?>
    	</div>
    </div>
	</div>
</div>

<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">
            <form class="navbar-search pull-right" action=""><input type="text" class="search-query span2" placeholder="Search"></form>
    	</div><!-- container -->
    </div><!-- navbar-inner -->
</div><!-- subnav -->