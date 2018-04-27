<div class="width1200">
<ul>
	{section name=i loop=$errors}
		<li>{$errors[i]}</li>
	{/section}
	{section name=i loop=$messages}
		<li>{$errors[i]}</li>
	{/section}
</ul>
</div>