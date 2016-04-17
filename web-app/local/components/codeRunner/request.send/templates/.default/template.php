<form id="input-form">
	<div class="input-field-description" id="first-description">
		Введите запрос в поле
	</div>
	<textarea id="input-field" name="request"><?=trim($arResult['templates'][$arResult['langs'][0]], "\t")?></textarea>
	<div class="input-field-description" id="two-description">
		Результат исполнения
	</div>
	<textarea id="result-block"></textarea>
	<select name="lang" id="input-select">
		<?foreach($arResult['langs'] as $lang){?>
			<option value="<?=$lang?>"><?=$lang?></option>
		<?}?>
	</select><input type="submit" id="submit-field">
	<input type="hidden" value="<?=$arResult['COMPONENT_DIRECTORY']?>" id="SEND_REQUEST_COMPONENT_DIRECTORY">
</form>

<div id="code-templates">
	<?foreach($arResult['templates'] as $lang => $template){?>
		<div id="<?=$lang?>"><?=$template?></div>
	<?}?>
</div>