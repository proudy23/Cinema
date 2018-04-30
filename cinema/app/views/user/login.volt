{{ content() }}
<div class="page-header">
	<h3>Log In</h3>
</div>
{{ form('user/authorize', 'role': 'form') }}
	<fieldset>
		<div class="form-group">
			<label for="username">Username</label>
			<div class="controls">
				{{ text_field('username', 'class': "form-control") }}
			</div>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<div class="controls">
				{{ password_field('password', 'class': "form-control") }}
			</div>
		</div>
		<div class="form-group">
			{{ submit_button('Login', 'class': 'btn btn-primary btn-large') }}
		</div>
	</fieldset>
{{  endform() }}