<form action="<?php echo domainpath.activeInstance.'/datoteke/folder/'.$folderData['id']; ?>" method="post" enctype="multipart/form-data">
			<div class="file-field input-field">
				<div class="btn cyan accent-4">
					<span>Odaberi</span>

					<input type="hidden" name="action" value="uploadNewFiles">
					<input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
					<input name="files[]" type="file" multiple>
					</div>
					<div class="file-path-wrapper">
					<input class="file-path validate" type="text" placeholder="Prijenos jedne ili više datoteka">
					</div>
					</div>

					<input type="submit" value="Prenesi odabrane datoteke" class="btn btn-large cyan accent-4">

			</form>

			<p style="margin-top:16px;"><br><br>Dopušten je prijenos datoteka do 250MB veličine s nazivom duljine do 128 znakova.</p>