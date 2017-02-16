<ul data-role="listview" data-inset="true" data-theme="a" data-split-icon="gear" data-split-theme="a">
	<li data-role="list-divider">User</li>
	<li data-split-icon="gear" data-split-theme="a">
		<a href="<?php echo $this->createUrl( 'user/view', array( 'id' => $model->user_id ) ); ?>">
		<img src="/images/icons/large/user.png" />
		<h3><?= $model->user_login; ?></h3>
		<p><?= $model->displayName(); ?><?= $model->user_status == 'suspended' ? '(Suspended)' : ''; ?></p>
		<p><?= $model->user_email_address; ?></p></a>
		</a><a data-rel="dialog" href="<?php echo $this->createUrl( 'user/update', array( 'id' => $model->user_id ) ); ?>">Edit User</a>
	</li>
	<li class="list-footer-control" data-theme="a" data-icon="arrow-r">
		<a data-role="simpledialog-link" href="#">
			<h4>Security Questions</h4>
		</a>
		<div class="simpledialog-content">
			<ul class="small-thumb" data-role="listview" data-inset="false" data-theme="a">
				<li data-role="list-divider"><?= $model->user_login; ?></li>
				<li data-role="list-divider" data-theme="b">Question 1</li>
				<li><img src="/images/icons/question.png" /><?= $model->user_security_question_1; ?></li>
				<li><img src="/images/icons/answer.png" /><?= $model->user_security_answer_1; ?></li>
				<li data-role="list-divider" data-theme="b">Question 2</li>
				<li><img src="/images/icons/question.png" /><?= $model->user_security_question_2; ?></li>
				<li><img src="/images/icons/answer.png" /><?= $model->user_security_answer_2; ?></li>
				<li data-role="list-divider" data-theme="b">Question 3</li>
				<li><img src="/images/icons/question.png" /><?= $model->user_security_question_3; ?></li>
				<li><img src="/images/icons/answer.png" /><?= $model->user_security_answer_3; ?></li>
			</ul>
		</div>
	</li>
</ul>

