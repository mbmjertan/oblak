<form action="<?php echo domainpath.activeInstance.'/datoteke/folder/'.$folderData['id']; ?>" method="post" enctype="multipart/form-data">
			<div class="input-field">
					<input type="hidden" name="action" value="newFolder">
					<input type="hidden" name="csrfToken" value="<?php echo csrfToken; ?>">
                    <label for="folderName">Naziv nove mape...</label>
					    <input name="folderName" type="text" required>

					</div>

					<input type="submit" value="Stvori mapu" class="btn btn-large cyan accent-4">

			</form>

			<p style="margin-top:16px;"><br><br>Maksimalna duljina naziva mape je 128 znakova. Mape uvijek nasljeđuju vidljivost svojih roditelja.</p>