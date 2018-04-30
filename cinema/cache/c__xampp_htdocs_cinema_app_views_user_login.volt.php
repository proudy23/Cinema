<?= $this->getContent() ?>
<div class="page-header">
	<h3>Log In</h3>
</div>
<?= $this->tag->form(['user/authorize', 'role' => 'form']) ?>
	<fieldset>
		<div class="form-group">
			<label for="username">Username</label>
			<div class="controls">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				<?= $this->tag->textField(['username', 'class' => 'form-control']) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<div class="controls">
			<small id="passwordhelp" class="form-text text-muted">Your Password is in good hands.</small>
				<?= $this->tag->passwordField(['password', 'class' => 'form-control']) ?>
			</div>
		</div>
		<div class="form-group">
			<?= $this->tag->submitButton(['Login', 'class' => 'btn btn-primary btn-large']) ?>
		</div>
	</fieldset>
<?= $this->tag->endform() ?>