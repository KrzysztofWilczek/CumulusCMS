<div class="row-fluid">
<h1><?= __('menuHome'); ?></h1>
</div>
<div class="row-fluid">
    <div class="span3">
        <div class="well sidebar-nav">
            <ul class="nav nav-list">
                
                <li class="nav-header"><?= __('menuSettings'); ?></li>
                <li class="active"><a href="#"><?= __('menuPanel'); ?></a></li>
                <li><?= Html::anchor('admin/users', __('menuUsers')); ?></li>
                
                <li class="nav-header"><?= __('menuNews'); ?></li>
                <li><?= Html::anchor('admin/articles', __('menuNewsList')); ?></li>
                <li><?= Html::anchor('admin/articles/add', __('menuNewsAdd')); ?></li>
                
                <li class="nav-header"><?= __('menuPages'); ?></li>
                <li><?= Html::anchor('admin/pages', __('menuPagesList')); ?></li>
                <li><?= Html::anchor('admin/pages/add', __('menuPagesAdd')); ?></li>
                
                <li class="nav-header"><?= __('menuNewsletter'); ?></li>
                <li><?= Html::anchor('admin/newsletter', __('menuNewsletterList')); ?></li>
                <li><?= Html::anchor('admin/subscribers', __('menuSubscribersList')); ?></li>
                <li><?= Html::anchor('admin/newsletter/add', __('menuNewsletterAdd')); ?></li>
                
                <li class="nav-header"><?= __('menuTemplates'); ?></li>
                <li><?= Html::anchor('admin/templates', __('menuTemplatesList')); ?></li>
                
            </ul>
        </div>
    </div>
    
    <div class="span9">
        <div class="well">
            <p class="lead">Witaj!<br/>
            Pracujesz obecnie na systemie zarządzania treścią Cumulus CMS v.1.0. Wybierz jeden z elementów, którym chcesz zarządzać.
            </p>
        </div>
        <blockquote>
            <p>Rozruch podstawowego moduł CMS z podłączony WebAPI.</p>
            <small>01.10.2012</small>
        </blockquote>
    </div>
</div>