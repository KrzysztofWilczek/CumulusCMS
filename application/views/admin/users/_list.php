	<?php if (!count($items)):?>
		<tr><td colspan="4"><?= __('labelNullUsers'); ?></td></tr>	
	<?php else:?>
	<?php foreach($items as $user):?>
		<tr>
			<td>
                            
                            <?php if (empty($user->avatar)): ?>
                                <img src="http://placehold.it/50x50" alt="" class="pull-left"/>
                            <?php else: ?>
                                <img src="<?= Model_User::getAvatarPath($user->id, false).$user->avatar; ?>" alt="" class="pull-left"/>                               
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= $user->login;?><br/>
                            <?= Html::mailto($user->email);?></td>
			<td><?= $user->registration_date;?></td>
			<td><?= Model_User::$rolesNames[$user->role]; ?></td>
			<td>
                                <div class="btn-group pull-left">
					<button class="btn btn-danger btn-small"><?= __('buttonManage'); ?></button>
					<button class="btn dropdown-toggle btn-small btn-danger" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
                                                <li><?= Html::anchor('admin/users/edit/'.$user->id, '<i class="icon-edit"></i> '.__('buttonEdit')) ;?></li>
                                                <li><?= Html::anchor('admin/users/password/'.$user->id, '<i class="icon-barcode"></i> '.__('buttonChangePass'));?></li>
						
					</ul>
				</div> 
                            
                                <?php if ($user->id != Session::instance()->get('user')->id):?>
				<?= Html::anchor('admin/users/del/'.$user->id, '<i class="icon-trash icon-white"></i> '.__('buttonDel'), array('class'=>'btn btn-small btn-inverse delete pull-left', 'style'=>'margin-left: 10px;'));?>
                                <?php endif; ?>
			</td>
		</tr>
	<?php endforeach;?>
	<?php endif;?>